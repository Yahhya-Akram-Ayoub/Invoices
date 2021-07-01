<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Requests\branchRequest;

class BranchController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Add Branch', ['only' => ['create', 'store']]);
        $this->middleware('permission:Modify branch', ['only' => ['update', 'edit']]);
        $this->middleware('permission:Delete Branch', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branchs = Branch::all();
        $sections = Section::all();
        return view('section.section-branchs', compact(['branchs', 'sections']));
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
    public function store(branchRequest $request)
    {
        $validated = $request->validated();

        Branch::create([
            'branch_name' => $request->branch_name,
            'description' => $request->description,
            'section_id' => $request->section_id

        ]);

        return redirect('branch');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function show(branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function edit(branch $branch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function update(branchRequest $request)
    {
        $validated = $request->validated();

        try {
            Branch::where('id', '=', $request->id)->update([
                'branch_name' => $request->branch_name,
                'description' => $request->description,
                'section_id' => $request->section_id
            ]);
        } catch (Throwable $e) {
            report($e);
            return back();
        }


        return redirect('branch');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(branchRequest $request)
    {
        $validated = $request->validated();

        $branch = Branch::find($request->id);

        if (isset($branch)) {
            $branch->delete();
            session()->flash('delete', 'تم حذف المنتج ');
        }

        return redirect('branch');
    }

    public function getbranch($id)
    {

        $branchs = Branch::all()->where('section_id', $id)->pluck('branch_name', 'id');

        //json for ajax
        return json_encode($branchs);// return responde()->josn($branch);


    }
}
