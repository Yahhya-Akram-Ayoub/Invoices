<?php

namespace App\Http\Controllers;

use App\Models\Invoives;
use Illuminate\Http\Request;

class InvoivesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('invoices.invoice');
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
     * @param  \App\Models\Invoives  $invoives
     * @return \Illuminate\Http\Response
     */
    public function show(Invoives $invoives)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoives  $invoives
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoives $invoives)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoives  $invoives
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoives $invoives)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoives  $invoives
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoives $invoives)
    {
        //
    }
}
