<?php

namespace App\Http\Controllers;

use App\Exports\InvoiceExport;
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = invoices::all();
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_Date,
            'due_date' => $request->Due_date,
            'branch_id' => $request->branch,
            'section_id' => $request->Section,
            'amount_collection' => $request->Amount_collection,
            'amount_commission' => $request->Amount_Commission,
            'discount' => $request->Discount,
            'value_vat' => $request->Value_VAT,
            'rate_vat' => $request->Rate_VAT,
            'total_amount' => $request->Total,
            'note' => $request->note,
            'user_id' => Auth::user()->id
        ]);

        $invoice_id = invoices::latest()->first()->id;

        invoices_details::create([
            'invoice_id' => $invoice_id,
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


        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show(invoices $invoices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit($invoices)
    {
        return $invoices;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        invoices::where('id', $request->id)->update([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_Date,
            'due_date' => $request->Due_date,
            'branch_id' => $request->branch,
            'section_id' => $request->Section,
            'amount_collection' => $request->Amount_collection,
            'amount_commission' => $request->Amount_Commission,
            'discount' => $request->Discount,
            'value_vat' => $request->Value_VAT,
            'rate_vat' => $request->Rate_VAT,
            'total_amount' => $request->Total,
            'note' => $request->note,
            'user_id' => Auth::user()->id
        ]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        $page_id = $request->page_id;

        $invoice = invoices::where('id', $id)->first();
        if ($page_id == 1) {
            //نحذف المرفقات قبل الفاتورة عشان نقدر نوصل للملف تبعهم لان بس حذفن الفاتورة رح ينحذف المرفقات واسماء الملفات
            // $attachment = invoices_attachment::where('invoice_id', $id)->get();
            $attachment = invoices_attachment::where('invoice_id', $id)->first();
            if (isset($attachment)) {

                // foreach ($attachment as $item) {
                // Storage::disk('public_uploads')->deleteDirectory($item->invoice_number);
                Storage::disk('public_uploads')->deleteDirectory($attachment->invoice_number);
                // }
            }

            $invoice->forceDelete();
            session()->flash('delete_invoice');
        } else {
            $invoice->delete();
            session()->flash('archived_invoice');
        }
        return back();
    }



    public function addAttachment(Request $request)
    {

        if ($request->hasFile('pic')) {

            $request->validate([
                'pic' => 'mimes:pdf,jpeg,png,jpg',
            ]);

            $fileName =  $request->file('pic')->getClientOriginalName();
            $invoice_number =  $request->invoice_number;
            invoices_attachment::create(
                [
                    'file_name' =>  $fileName,
                    'user_id' => Auth::user()->id,
                    'invoice_id' => $request->invoice_id
                ]
            );

            $request->pic->move(public_path('Attachments/' . $invoice_number), $fileName);
        }
        return back();
    }


    public function updateDetails(Request $request)
    {

        invoices_details::create([
            'invoice_id' => $request->id,
            'invoice_number' => $request->invoice_number,
            'amount_paid' => $request->amount_paid,
            'note' => $request->note,
            'user_id' => (Auth::user()->id),
        ]);

        return back();
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
        $invoices = invoices::where('archive' , '=' , 1)->get();
        return view('invoices.archived_invoiced', compact('invoices'));
    }
    public function restore(Request $request)
    {
        $id = $request->invoice_id;
        $invoice = invoices::withTrashed()->where('id', $id)->restore();
        session()->flash('restore');
        return back();
    }
    public function destroyWithTrashed(Request $request)
    {
        $id = $request->invoice_id;
        $invoice = invoices::withTrashed()->where('id', $id)->first();
        $invoice->forceDelete();
        session()->flash('delete_invoice');
        return back();
    }
    public function print_invoice($id)
    {

        $invoice = invoices::find($id);
        $details = invoices_details::where('invoice_id', $id)->get();
        return view('invoices.print_invoice', compact('invoice', 'details'));
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
}
