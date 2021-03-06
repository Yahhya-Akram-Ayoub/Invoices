<?php

namespace App\Http\Controllers;

use App\Exports\InvoiceExport;
use App\Http\Requests\InvoiceRequest;
use App\Models\Section;
use App\Models\invoices;
use Illuminate\Http\Request;
use App\Models\invoices_details;
use App\Notifications\addInvoice;
use App\Models\invoices_attachment;
use App\Models\User;
use App\Notifications\notifi_addInvoice;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

class invoicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Add invoice', ['only' => ['store']]);
        $this->middleware('permission:Delete invoice', ['only' => ['destroy']]);
        $this->middleware('permission:Add invoice', ['only' => ['store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = invoices::where('archive', '=', 0)->get();
        // return $invoices;
        return view('invoices.invoice', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = Section::all();
        return view('invoices.add_invoice', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoiceRequest $request)
    {
        $validate = $request->validate();

        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'branch_id' => $request->branch,
            'section_id' => $request->section,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'rate_vat' => $request->rate_vat,
            'value_vat' => $request->value_vat,
            'total_amount' => $request->total_amount,
            'note' => $request->note,
            'user_id' => Auth::user()->id
        ]);

        $invoice_id = invoices::latest()->first()->id;

        invoices_details::create([
            'invoices_id' => $invoice_id,
            'amount_paid' => 0,
            'note' => $request->note,
            'user_id' => Auth::user()->id,
        ]);


        if ($request->hasFile('pic')) {
            $request->invoice_id = $invoice_id;
            $this->addAttachment($request);
        }

        $users = User::where('id', '!=', Auth::user()->id)->get();
        Notification::send(Auth::user(), new addInvoice($invoice_id));
        Notification::send($users, new notifi_addInvoice($request->invoice_number, $invoice_id));


        session()->flash('Add', '???? ?????????? ???????????????? ??????????');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\invoices $invoices
     * @return \Illuminate\Http\Response
     */
    public function show(invoices $invoices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\invoices $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\invoices $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(InvoiceRequest $request)
    {
        $validate = $request->validate();

        // for get old invoice number and get new from request
        $invoice = invoices::find($request->id);

        invoices::where('id', $request->id)->update([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'branch_id' => $request->branch,
            'section_id' => $request->section,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'rate_vat' => $request->rate_vat,
            'value_vat' => $request->value_vat,
            'total_amount' => $request->total_amount,
            'note' => $request->note,
            'user_id' => Auth::user()->id
        ]);


        if (isset($invoice->invoices_attachments)) {
            rename(public_path('Attachments/' . $invoice->invoice_number), public_path('Attachments/' . $request->invoice_number));
            // Storage::disk('public_uploads')->deleteDirectory($invoice->invoice_number);
        }


        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\invoices $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        $invoice = invoices::where('id', $id)->first();

        if (isset($invoice)) {
            $invoice->delete();
            session()->flash('archived_invoice');
        }

        return back();
    }


    public function addAttachment(Request $request)
    {

        $validate = $request->validate([
            'pic' => 'required|max:255|mimes:pdf,jpeg,png,jpg',
            'invoice_number' => 'required|max:255',
        ]);

        if ($request->hasFile('pic')) {

            $fileName = $request->file('pic')->getClientOriginalName();
            $invoice_number = $request->invoice_number;
            invoices_attachment::create(
                [
                    'file_name' => $fileName,
                    'user_id' => Auth::user()->id,
                    'invoices_id' => $request->invoice_id
                ]
            );

            $request->pic->move(public_path('Attachments/' . $invoice_number), $fileName);
        }

        return back();
    }


    public function updateDetails(Request $request)
    {
        $validate = $request->validate([
            'id' => 'required',
            'amount_paid' => 'required',
            'note' => 'max:255',
        ]);

        $invpice = invoices::find($request->id);

        if (isset($invpice)) {

            invoices_details::create([
                'invoices_id' => $request->id,
                'amount_paid' => $request->amount_paid,
                'note' => $request->note,
                'user_id' => (Auth::user()->id),
            ]);

            $invpice->total_paid += $request->amount_paid;

            if ($invpice->total_paid >= $invpice->total_amount) {
                $invpice->value_status = 2;
            } else if ($invpice->total_paid > 0) {
                $invpice->value_status = 1;
            }
            $invpice->save();
        }
        return $this->index();
    }

    public function invoices_paid()
    {
        $invoices = invoices::where('value_status', 2)->get();
        return view('invoices.invoices_paid', compact('invoices'));
    }

    public function invoices_unpaid()
    {
        $invoices = invoices::where('value_status', 0)->get();
        return view('invoices.invoices_unpaid', compact('invoices'));
    }

    public function invoices_partially_paid()
    {
        $invoices = invoices::where('value_status', 1)->get();
        return view('invoices.invoices_partially_paid', compact('invoices'));
    }

    public function deleted_invoiced()
    {
        $invoices = invoices::onlyTrashed()->get();
        return view('invoices.deleted_invoiced', compact('invoices'));
    }

    public function archived_invoiced()
    {
        $invoices = invoices::where('archive', '=', 1)->get();
        // return $invoices;
        return view('invoices.archived_invoiced', compact('invoices'));
    }

    public function restore(Request $request)
    {
        $validate = $request->validate([
            'invoice_id' => 'required',
        ]);

        $id = $request->invoice_id;
        $invoice = invoices::withTrashed()->where('id', $id)->first();

        if (isset($invoice)) {
            $invoice = $invoice->restore();
            session()->flash('restore');
        }
        return back();
    }

    public function destroyWithTrashed(Request $request)
    {
        $validate = $request->validate([
            'invoice_id' => 'required',
        ]);

        $id = $request->invoice_id;
        $invoice = invoices::withTrashed()->where('id', $id)->first();

        if (isset($invoice)) {
            if (isset($invoice->invoices_attachments)) {
                Storage::disk('public_uploads')->deleteDirectory($invoice->invoice_number);
            }

            $invoice->forceDelete();
            session()->flash('delete_invoice');
        }

        return back();
    }

    public function print_invoice($id)
    {

        $invoice = invoices::find($id);

        if (isset($invoice)) {
            return view('invoices.print_invoice', compact('invoice', 'details'));
        } else {
            return back();
        }
    }

    public function export()
    {
        return Excel::download(new InvoiceExport, 'Invoices.xlsx');
    }

    public function archive(Request $request)
    {
        if ($request->page_id == 2) {
            invoices::find($request->invoice_id)->update(['archive' => 1]);
        } else if ($request->page_id == 1) {
            invoices::find($request->invoice_id)->update(['archive' => 0]);
        }

        return back();
    }

    public function markAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return redirect()->back();
    }


    public function search($txt)
    {
        $result = invoices::search($txt)
            ->with(['invoices_attachments', 'invoices_details'])
            ->withTrashed()
            ->distinct()
            ->get();

        $result = isset($result) ? $result : ["found" => "not result found"];

        return response()->json($result);
    }
}
