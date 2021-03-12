<?php

namespace App\Http\Controllers;

use App\Department;
use App\Division;
use App\ManageStructures;
use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // variable declaration
        $sections = [];
        $title = '';

        $user = Auth::user();

        if ($user->hasRole('Administrator')) {
            $sections = Section::latest()->paginate(10);
            $title = 'All Sections Management';
        } else {
            $sections = Section::where('created_by', $user->id)->latest()->paginate(10);
            // get user's structure
            $user_department = ManageStructures::where('manager_id', $user->id)->first();

            // dd($user_department->structure_id);
            // division
            $department = Department::where('id', $user_department->structure_id)->first();
            // dd($department);
            $title = $department->department_name . ' Department Sections Management';
        }

        return view('section.index', compact(['sections', 'title']));
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
            'department_id' => $request->input('department_name'),
            'created_by' => Auth::user()->id
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
        $section->created_by = Auth::user()->id;
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
