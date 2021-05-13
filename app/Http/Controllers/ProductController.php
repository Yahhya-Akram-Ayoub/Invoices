<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products =  product::all();
        $sections = Section::all();
        return view('section.section-products', compact(['products', 'sections']));
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
    public function store(ProductRequest $request)
    {
        $validated = $request->validated();

        product::create([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'section_id' => $request->section_id

        ]);

        return redirect('product');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request)
    {
        $validated = $request->validated();

        product::where('id', '=', $request->id)->update([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'section_id' => $request->section_id

        ]);

        return redirect('product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $product = product::find($request->id);
        $product->delete();
        session()->flash('delete', 'تم حذف المنتج ');
        return redirect('product');
    }

    public function getProduct($id)
    {
        $products = product::all()->where('section_id',  $id)->pluck('product_name','id');

        //json for ajax
        return json_encode( $products);// return responde()->josn($product);
    }
}
