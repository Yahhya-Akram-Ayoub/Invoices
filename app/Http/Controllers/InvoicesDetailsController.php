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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\invoices_details $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function show($id, $opreation = null)
    {

        if (empty($opreation)) {
            $invoice = invoices::find($id);

            if (isset($invoice)) {
                return view('invoices.inoice_detail', compact('invoice'));
            }

        } else if ($opreation == 2) {

            // for deleted invoices
            $invoice = invoices::withTrashed()->find($id);
            if (isset($invoice)) {
                return view('invoices.inoice_detail', compact('invoice'));
            }

        }

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\invoices_details $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = invoices::find($id);
        if (isset($invoice)) {
            $sections = Section::all();
            return view('invoices.edit_invoice', compact('invoice', 'sections'));
        }

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\invoices_details $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoices_details $invoices_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\invoices_details $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function destroy(invoices_details $invoices_details)
    {
        //
    }

    public function pay($id)
    {
        $invoice = invoices::find($id);

        if (isset($invoice)) {
            $sections = Section::all();
            return view('invoices.edit_pay', compact('invoice', 'sections'));
        }

        return back();
    }
}
