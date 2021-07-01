<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Add Section', ['only' => ['create', 'store']]);
        $this->middleware('permission:Modify Section', ['only' => ['update', 'edit']]);
        $this->middleware('permission:Delete Section', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::all();
        return view('section.section', compact('sections'));
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
        // الطريقة الاولى
        // $input = $request->all();

        // $b_exists = Section::where('section_name', '=', $input['section_name'])->exists();

        // if ($b_exists) {

        //     session()->flash('error', 'القسم مضاف مسبقا ');
        //     return redirect('/section');
        // } else {

        //     Section::create([
        //         'section_name' => $request->section_name,
        //         'description' => $request->description,
        //         'user_id' => Auth::user()->id
        //     ]);
        //     session()->flash('add', 'تم اضافة الاسم ');
        //     return redirect('/section');
        // }


        $validatedData = $request->validate([
            'section_name' => 'required|unique:sections|max:255',
            'description' => 'required',
        ], [
            'section_name.required' => 'يجب ادخال اسم القسم ',
            'section_name.unique' => 'هذا القسم موجود بالفعل',

            'description.required' => 'يجب ادخال وصف اسم القسم ',

        ]);

        Section::create([
            'section_name' => $request->section_name,
            'description' => $request->description,
            'user_id' => Auth::user()->id
        ]);
        session()->flash('add', 'تم اضافة الاسم ');
        return redirect('/section');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Section $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        ///
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Section $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Section $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;

        $validatedData = $request->validate([
            'section_name' => 'required|unique:sections,section_name,' . $id . '|max:255',
            'description' => 'required',
        ], [
            'section_name.required' => 'يجب ادخال اسم القسم ',
            'section_name.unique' => 'هذا القسم موجود بالفعل',

            'description.required' => 'يجب ادخال وصف اسم القسم ',

        ]);

        $section = Section::find($id);

        if (isset($section)) {

            $section->update([
                'section_name' => $request->section_name,
                'description' => $request->description
            ]);

            session()->flash('edit', 'تم تعديل القسم بنجاج');
        }


        return redirect('section');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Section $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $section = Section::find($request->id);

        if (isset($section)) {
            $section->delete();
            session()->flash('delete', 'تم حذف القسم ');
        }

        return redirect('section');
    }
}
