<?php
/**
 * Manages kpis
 *
 * */
namespace App\Http\Controllers;

use App\KPI;
use Illuminate\Http\Request;
use flash;
use Illuminate\Support\Facades\Auth;

class KPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //    get user's kpis
        $user_kpis = KPI::where('group_id', Auth::user()->group_id)->get();

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
            'unit_of_mesure'  => 'required',
            'weight' => 'required',
            'previous_target' => 'required',
            'achievement' => 'required',
            'validated_achievement' => 'required',
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
            'unit_of_measure' => $request->unit_of_mesure,
            'weight' => $request->weight,
            'period' => $request->period,
            'previous_target' => $request->previous_target,
            'achievement' => $request->achievement,
            'validated_achievement' => $request->validated_achievement,
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
            'unit_of_mesure'  => 'required',
            'weight' => 'required',
            'previous_target' => 'required',
            'achievement' => 'required',
            'validated_achievement' => 'required',
            'target' => 'required',
            'period' => 'required',

        ]);
        $kpi = KPI::where('id', $kPI)->first();

        $kpi->update([
            'perspective' => $request->perspective,
            'kpi' => $request->kpi,
            'unit_of_measure' => $request->unit_of_mesure,
            'weight' => $request->weight,
            'period' => $request->period,
            'previous_target' => $request->previous_target,
            'achievement' => $request->achievement,
            'validated_achievement' => $request->validated_achievement,
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
        //
    }
}
