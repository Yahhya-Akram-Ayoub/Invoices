<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\Section;
use Illuminate\Http\Request;

class reportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->invoices_report();
    }

    public function invoices_report()
    {
        return view('reports.invoices_report');
    }

    public function custmers_report()
    {
        $sections = Section::all();
        return view('reports.customers_report', compact('sections'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

    }

    public function search_invoices_report(Request $request)
    {

        $rdio = $request->rdio;

        // raio == 1 search by invoive type
        //  raio == 2 search by invoive number

        if ($rdio == 1) {

            if (isset($request->type) && empty($request->start_at) && empty($request->end_at)) {

                $type = $request->type;
                $invoices = invoices::where('value_status', $request->type)->get();
                return isset($invoices) ? view('reports.invoices_report', compact('type'))->withDetails($invoices) : back();
            } else {
                $type = $request->type;
                $start_at = date($request->start_at);
                $end_at = date($request->end_at);
                $invoices = invoices::whereBetween('invoice_date', [$start_at, $end_at])->where('value_status', $request->type)->get();
                return isset($invoices) ? view('reports.invoices_report', compact('type', 'end_at', 'start_at'))->withDetails($invoices) : back();
            }
        } else if ($rdio == 2) {
            $invoice_number = $request->invoice_number;
            $invoice = [invoices::where('invoice_number', '=', $invoice_number)->first()];
            return isset($invoices) ? view('reports.invoices_report', compact('invoice_number', 'rdio'))->withDetails($invoice) : back();
        }

        return back();
    }

    public function search_customers_report(Request $request)
    {
        $validate = $request->validate([
            'branch' => 'required',
            'Section' => 'required',
        ]);

        if (empty($request->start_at) && empty($request->end_at)) {

            $invoices = invoices::where('section_id', $request->Section)->where('branch_id', $request->branch)->get();
            $sections = Section::all();

            if (isset($invoices)) {
                return view('reports.customers_report', compact('sections'))->withDetails($invoices);
            }

        } else {

            $validate = $request->validate([
                'start_at' => 'required',
                'end_at' => 'required',
            ]);

            $start_at = date($request->start_at);
            $end_at = date($request->end_at);


            $invoices = invoices::whereBetween('invoice_date', [$start_at, $end_at])->where('section_id', '=', $request->Section)->where('branch_id', '=', $request->branch)->get();
            $sections = Section::all();

            if (isset($invoices)) {
                return view('reports.customers_report', compact('sections', 'end_at', 'start_at'))->withDetails($invoices);
            }

        }

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
