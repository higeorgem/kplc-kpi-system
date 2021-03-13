<?php

namespace App\Http\Controllers;

use App\Department;
use App\Division;
use App\ManageStructures;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = [];
        $title = '';
        $admin = false;
        $division = [];
        $user = Auth::user();

        // admin departments all
        if ($user->hasRole('Administrator')) {

            $departments = Department::latest()->get();
            $title = 'All Departments Management';
            $admin = true;

        }else{
            $departments = Department::where('created_by', $user->id)->latest()->get();
            // get user's structure
            $user_division = ManageStructures::where('manager_id', $user->id)->first();
            // dd($user_division);
            // division
            $division = Division::where('id', $user_division->structure_id)->first();
            // dd($division);
            $title = $division->division_name.' Division Departments Management';
        }

        return view('department.index', [
            'departments' => $departments,
            'title' => $title,
            'structure' => $division,
            'admin' => $admin
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // check roles
        $user = Auth::user();

        $divisions = [];
        $division_select = false;

        if ($user->hasRole('Administrator')) {
            $divisions = Division::orderBy('division_name')->get();
            $division_select = true;
            // dD($divisions);
        }else{
            // get user assigned division id
            $user_division = ManageStructures::where('manager_id', $user->id)->first();
            $divisions = Division::where('id', $user_division->structure_id)->orderBy('division_name')->first();
        }

        return view('department.create', compact(['divisions', 'division_select']));
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
            'department_name' => 'required|unique:departments,department_name',
        ]);

        // dd(Auth::user()->id);

        $department = Department::create([
            'division_id' => $request->input('division_name'),
            'department_name' => $request->input('department_name'),
            'created_by'=> Auth::user()->id
        ]);

        return redirect()->route('department.index')
            ->with('success', 'Department created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {

        // $department = Department::findOrFail($id);
        return view('department.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        return view('department.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $this->validate($request, [
            'department_name' => 'required'
        ]);

        $department->department_name = $request->input('department_name');
        $department->save();

        return redirect()->route('department.index')
            ->with('success', 'Department updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('department.index')
            ->with('success', 'Department deleted successfully');
    }
}
