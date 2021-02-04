<?php

namespace App\Http\Controllers;

use App\KPI;
use App\Report;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd('here');
        $data = [];
        /**
         * reports generated as per kpi
         * TODO: i. get kpi with tasks
         * TODO: ii. generate report accordingly
         */
        #get kpis
        $kpis = KPI::all();

        foreach ($kpis as $key => $kpi) {
           $data[$key] = KPI::find($kpi->id)
                        ->tasks()
                        ->where('description', Auth::user()->staff_no)
                        ->where('flag', '0')
                        ->get();
        }

        // dd($kpis);
        // dd($data);


        // loop through the kpi map taks

        return view('report.index', ['data' => $data]);

    }
    public function getQuery()
    {
        return view('report.queryReport');
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }
}
