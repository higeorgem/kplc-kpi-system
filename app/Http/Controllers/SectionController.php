<?php

namespace App\Http\Controllers;

use App\Department;
use App\Division;
use App\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::latest()->paginate(10);

        return view('section.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $divisions = Division::get();
        $departments = Department::get();

        return view('section.create', compact(['divisions','departments']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'division_name'=>'required',
            'section_name' => 'required|unique:sections,section_name',
            'department_name' => 'required'
        ]);
// dd($request);
        $section = Section::create([
            'section_name' => $request->input('section_name'),
            'division_id' => $request->input('division_name'),
            'department_id' => $request->input('department_name')
            ]);

        return redirect()->route('sections.index')
            ->with('success', 'Section created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {

        // $section = Section::findOrFail($id);
        return view('section.show', compact('section'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        $divisions = Division::get();
        $departments = Department::get();

        return view('section.edit', compact(['section','divisions', 'departments']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section)
    {
        $this->validate($request, [
            'division_name' => 'required',
            'section_name' => 'required|unique:sections,section_name',
            'department_name' => 'required'
        ]);
        $section->section_name = $request->input('section_name');
        $section->division_id = $request->input('division_name');
        $section->department_id = $request->input('department_name');
        $section->save();

        return redirect()->route('sections.index')
            ->with('success', 'Section updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        $section->delete();
        return redirect()->route('sections.index')
            ->with('success', 'Section deleted successfully');
    }
}
