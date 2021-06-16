<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\invoices_attachment;
use App\Models\invoices_details;
use App\Models\Section;
use Illuminate\Http\Request;

class InvoicesDetailsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $result =  $this->getDitails($id);
        $invoice = $result[0];
        $attachment = $result[1];
        $details = $result[2];

        return view('invoices.inoice_detail', compact('invoice', 'attachment', 'details'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result =  $this->getDitails($id);
        $invoice = $result[0];
        $attachment = $result[1];
        $details = $result[2];

        $sections = Section::all();
        return view('invoices.edit_invoice', compact('invoice', 'attachment', 'details',  'sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoices_details $invoices_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function destroy(invoices_details $invoices_details)
    {
        //
    }

    public function getDitails($id)
    {

        // عدله ا عالعلاقات
        $invoice = invoices::find($id);
        $attachment = invoices_attachment::where('invoice_id', '=', $id)->get();
        $details = invoices_details::where('invoice_id', $id)->get();
        foreach ($attachment as $att) {
            $att->create_date =  $att->created_at->format('d/m/Y');
        }

        $result =  [$invoice, $attachment, $details];
        return $result;
    }

    public function pay($id)
    {
        $result =  $this->getDitails($id);
        $invoice = $result[0];
        $attachment = $result[1];
        $details = $result[2];

        $sections = Section::all();
        return view('invoices.edit_pay', compact('invoice', 'attachment', 'details', 'sections'));
    }
}
