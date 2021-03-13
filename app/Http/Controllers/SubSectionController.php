<?php

namespace App\Http\Controllers;

use App\Department;
use App\Division;
use App\ManageStructures;
use App\Section;
use App\SubSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // variable declaration
        $subsections = [];
        $title = '';

        $user = Auth::user();
        $admin = false;
        $division = [];

        // principles to view and edit members of their departments
        if ($user->hasRole('Principle')) {

            return view('structureManager.structure_members');
        }

        if ($user->hasRole('Administrator')) {

            $subsections = SubSection::latest()->get();
            $title = 'All Sub-Sections Management';
            $admin = true;
        } else {
            $subsections = SubSection::where('created_by', $user->id)->latest()->get();

            // get user's structure
            $user_subsection = ManageStructures::where('manager_id', $user->id)->first();

            // dd($subsections);

            // dd($user_department->structure_id);

            // division
            $section = Section::where('id', $user_subsection->structure_id)->first();
            // dd($section);
            $title = $section->section_name . ' Section Subsections Management';
        }
        // $subsections = SubSection::latest()->paginate(10);

        return view('subsection.index', (['subsections' => $subsections, 'title'=>$title, 'admin'=>$admin]));
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
        $sections = Section::get();

        return view('subsection.create', compact(['divisions', 'departments', 'sections']));
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
            'division_name' => 'required',
            'section_name' => 'required|unique:sub_sections,subsection_name',
            'department_name' => 'required',
            'subsection_name' => 'required'
        ]);

        $subsection = SubSection::create([
            'division_id' => $request->input('division_name'),
            'department_id' => $request->input('department_name'),
            'section_id' => $request->input('section_name'),
            'sub_section_name' => $request->input('subsection_name'),
            'created_by' => Auth::user()->id
        ]);

        return redirect()->route('subsections.index')
            ->with('success', 'SubSection created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SubSection  $subsection
     * @return \Illuminate\Http\Response
     */
    public function show(SubSection $subsection)
    {

        // $subsection = SubSection::findOrFail($id);
        return view('subsection.show', compact('subsection'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SubSection  $subsection
     * @return \Illuminate\Http\Response
     */
    public function edit(SubSection $subsection)
    {
        $divisions = Division::get();
        $departments = Department::get();
        $sections = Section::get();

        return view('subsection.edit', compact(['subsection', 'divisions', 'departments', 'sections']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SubSection  $subsection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubSection $subsection)
    {
        $this->validate($request, [
            'division_name' => 'required',
            'section_name' => 'required|unique:sub_sections,subsection_name',
            'department_name' => 'required',
            'subsection_name' => 'required'
        ]);

        $subsection->section_id = $request->input('section_name');
        $subsection->division_id = $request->input('division_name');
        $subsection->department_id = $request->input('department_name');
        $subsection->sub_section_name = $request->input('subsection_name');
        $subsection->save();

        return redirect()->route('subsections.index')
            ->with('success', 'SubSection updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SubSection  $subsection
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubSection $subsection)
    {
        $subsection->delete();
        return redirect()->route('subsections.index')
            ->with('success', 'SubSection deleted successfully');
    }
}
