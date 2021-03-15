<?php

/**
 * Manages kpis
 *
 * */

namespace App\Http\Controllers;

use App\Group;
use App\KPI;
use App\KPIAchievement;
use App\KPIStructure;
use App\KPITarget;
use App\KPIUnitOfMeasure;
use App\KPIWeight;
use App\Task;
use Illuminate\Http\Request;
use flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KPIController extends Controller
{
    public function getAllKpis($structure = null)
    {
        $kpis = [];
        $title = 'All KPIs';
        // dd(!$structure);

        if ($structure) {
            flash($structure.' KPIs')->info();
            $kpis = KPI::where('structure', $structure)->latest()->get();
            $title = $structure.' KPIs';
        } else {
            // dd(!$structure);
            $kpis = KPI::latest()->get();
        }


        return view('kpi.all_kpis', ['kpis' => $kpis, 'title'=>$title]);
    }
    public function getTasks($id)
    {
        $kpi = KPI::findOrFail($id);
        $kpi_tasks =  Task::where('description', $kpi->code)->where('responsible', Auth::user()->staff_no)->get();
        return view('task.kpi_tasks', ['kpi' => $kpi, 'kpi_tasks' => $kpi_tasks]);
    }

    public function getStructure($structure)
    {
        // dd(['reg'=>$structure]);
        $data = DB::table($structure)
            ->select('id', substr($structure, 0, -1) . '_name as name')
            ->get();

        // $groups = Group::where('structure', $structure_id)->get();

        return response()->json($data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get user data
        $user = Auth::user();
        dd($user);
        //    get user's kpis
        $user_kpis = KPI::where('section_id', Auth::user()->section_id)
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
        // dd($request);
        $request->validate([
            'perspective' => 'required',
            'kpi_type' => 'required',
            'structure' => 'required',
            'structure_id' => 'required',
            'kpi' => 'required',
            'period' => 'required',
            'unit_of_mesure'  => 'required',
            'weight' => 'required',
        ]);

        // get last inserted kpi code
        $kpi = new KPI();

        // get logged in user
        $user = Auth::user()->id;

        // create new kpi
        $kpi = KPI::create([
            'code' => $kpi->getNewCode(),
            'perspective' => $request->perspective,
            'kpi_type' => $request->kpi_type,
            'structure' => $request->structure,
            'structure_id' => $request->structure_id,
            'kpi' => $request->kpi,
            'period' => $request->period,
            'created_by' => $user,
        ]);
        // add kpi to structure
        KPIStructure::create([
            'kpi_id' => $kpi->id,
            'structure_type' => $request->structure,
            'structure_id' => $request->structure_id,
            'created_by' => $user
        ]);
        //add unit of measure
        KPIUnitOfMeasure::create([
            'kpi_id' => $kpi->id,
            'created_by' => $user,
            'unit_of_measure' => $request->unit_of_mesure,
        ]);
        // add kpi weight
        KPIWeight::create([
            'kpi_id' => $kpi->id,
            'weight' => $request->weight,
            'created_by' => $user,
        ]);

        flash('KPI Created')->success();

        return redirect()->route('kpi.edit', [$kpi->id]);
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

        $structures = DB::table($kpi->structure)
            ->select('id', substr($kpi->structure, 0, -1) . '_name as name')
            ->get();

        // dd($kpi->structure);

        return view('kpi.edit_kpi')
            ->with('kpi', $kpi)
            ->with('structures', $structures);
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
            // 'previous_target' => 'required',
            'achievement' => 'required',
            'validated_achievement' => 'required',
            'target' => 'required',
            // 'period' => 'required',
            'structure_id' => 'required',
            'structure' => 'required',
        ]);



        $kpi = KPI::where('id', $kPI)->first();

        $kpi->update([
            'perspective' => $request->perspective,
            'kpi_type' => $request->kpi_type,
            'structure' => $request->structure,
            'structure_id' => $request->structure_id,
            'kpi' => $request->kpi,
            'period' => $request->period,

        ]);

        $user_id = Auth::user()->id;

        //unit of measure
        KPIUnitOfMeasure::where('kpi_id', $kpi->id)->latest()->updateOrCreate([
            'kpi_id' => $kpi->id,
            'unit_of_measure' => $request->unit_of_mesure,
            'created_by' => $user_id
        ]);

        // weight
        KPIWeight::where('kpi_id', $kpi->id)->latest()->updateOrCreate([
            'kpi_id' => $kpi->id,
            'weight' => $request->weight,
            'created_by' => $user_id
        ]);

        // target
        KPITarget::where('kpi_id', $kpi->id)->latest()->updateOrCreate([
            'kpi_id' => $kpi->id,
            'target' => $request->target,
            'created_by' => $user_id
        ]);

        // achievement
        KPIAchievement::where('kpi_id', $kpi->id)->latest()->updateOrCreate([
            'kpi_id' => $kpi->id,
            'achievement' => $request->achievement,
            'validated_achievement' => $request->validated_achievement,
            'created_by' => $user_id
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
