<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoices_attachment;
use Illuminate\Support\Facades\Storage;

class InvoicesAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
     * @param  \App\Models\invoices_attachment  $invoices_attachment
     * @return \Illuminate\Http\Response
     */
    public function show( $invoice_number,$attachment_name )
    {

        $file = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'\\'.$attachment_name);
        return response()->file($file);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices_attachment  $invoices_attachment
     * @return \Illuminate\Http\Response
     */
    public function edit(invoices_attachment $invoices_attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices_attachment  $invoices_attachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoices_attachment $invoices_attachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices_attachment  $invoices_attachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(invoices_attachment $invoices_attachment)
    {
        // كيف تشتنغل ؟؟؟؟؟؟؟؟
    }


    public function delete(Request $request)
    {
        Storage::disk('public_uploads')->delete($request->invoive_number.'\\'.$request->file_name);
        invoices_attachment::find($request->id)->delete();
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }

    public function download( $invoice_number,$attachment_name )
    {
        $file = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'\\'.$attachment_name);
        return  response()->download($file);
    }
}
