<?php

/**
 * Manages kpis
 *
 * */

namespace App\Http\Controllers;

use App\Group;
use App\KPI;
use App\Task;
use Illuminate\Http\Request;
use flash;
use Illuminate\Support\Facades\Auth;

class KPIController extends Controller
{
    public function getAllKpis()
    {
        $kpis = KPI::latest()->get();
        return view('kpi.all_kpis',['kpis'=>$kpis]);
    }
    public function getTasks($id)
    {
        $kpi = KPI::findOrFail($id);
        $kpi_tasks =  Task::where('description', $kpi->code)->where('responsible', Auth::user()->staff_no)->get();
        return view('task.kpi_tasks', ['kpi' => $kpi, 'kpi_tasks' => $kpi_tasks]);
    }
    public function getGroups($group_id)
    {
        // return response()->json(['reg'=>request('id')]);
        $groups = Group::where('division_id', $group_id)->get();
        return response()->json($groups);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //    get user's kpis
        $user_kpis = KPI::where('group_id', Auth::user()->group_id)
            ->where('division_id', Auth::user()->division_id)
            ->get();
            
        // return view with kpis
        return view('kpi.index', ['my_kpis' => $user_kpis]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kpi/create_kpi');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'perspective' => 'required',
            'kpi' => 'required',
            'kpi_type' => 'required',
            'unit_of_mesure'  => 'required',
            'weight' => 'required',
            'previous_target' => 'required',
            'group_id' => 'required',
            'division_id' => 'required',
            // 'achievement' => 'required',
            // 'validated_achievement' => 'required',
            'target' => 'required',
            'period' => 'required',

        ]);
        // get last inserted kpi code
        $kpi = new KPI();
        // dd($kpi->getNewCode());

        KPI::create([
            'code' => $kpi->getNewCode(),
            'perspective' => $request->perspective,
            'kpi' => $request->kpi,
            'kpi_type' => $request->kpi_type,
            'unit_of_measure' => $request->unit_of_mesure,
            'weight' => $request->weight,
            'period' => $request->period,
            'previous_target' => $request->previous_target,
            'group_id' => $request->group_id,
            'division_id' => $request->division_id,
            // 'achievement' => $request->achievement,
            // 'validated_achievement' => $request->validated_achievement,
            'target' => $request->target,
        ]);

        flash('KPI Created')->success();

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\KPI  $kPI
     * @return \Illuminate\Http\Response
     */
    public function show(KPI $kPI)
    {
        dd($kPI);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\KPI  $kPI
     * @return \Illuminate\Http\Response
     */
    public function edit($kPI)
    {
        $kpi = KPI::where('id', $kPI)->first();
        // dd($kpi);
        return view('kpi.edit_kpi')->with('kpi', $kpi);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\KPI  $kPI
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $kPI)
    {
        $request->validate([
            'perspective' => 'required',
            'kpi' => 'required',
            'kpi_type' => 'required',
            'unit_of_mesure'  => 'required',
            'weight' => 'required',
            'previous_target' => 'required',
            // 'achievement' => 'required',
            // 'validated_achievement' => 'required',
            'target' => 'required',
            'period' => 'required',
            'group_id' => 'required',
            'division_id' => 'required',
        ]);

        $kpi = KPI::where('id', $kPI)->first();

        $kpi->update([
            'perspective' => $request->perspective,
            'kpi' => $request->kpi,
            'kpi_type' => $request->kpi_type,
            'unit_of_measure' => $request->unit_of_mesure,
            'weight' => $request->weight,
            'period' => $request->period,
            'previous_target' => $request->previous_target,
            'group_id' => $request->group_id,
            'division_id' => $request->division_id,
            // 'achievement' => $request->achievement,
            // 'validated_achievement' => $request->validated_achievement,
            'target' => $request->target,
        ]);

        flash('KPI Updated')->success();

        return redirect()->route('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\KPI  $kPI
     * @return \Illuminate\Http\Response
     */
    public function destroy(KPI $kPI)
    {
        $kPI->delete();

        flash('KPI Deleted !!')->success();

        return redirect()->back();

    }
}
