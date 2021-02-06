<?php

namespace App\Http\Controllers;

use App\KPI;
use App\Report;
use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

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
    // return query report view
    public function getQuery()
    {
        return view('report.queryReport');
    }
// return json response for the query results
    public function getTaskQuery(Request $query)
    {
        $query->validate([
            'kpi_id' => 'required',
            'inputStartDate' => 'required',
            'inputEndDate'=> 'required',
        ]);
         $tasks =[];
        // all my tasks
        if($query->kpi_id === 'all'){
            // $tasks = ['something' => 'yes'];
        //    $tasks = Task::all()->filter(function($query) {
        //         if (Carbon::now()->between($query->inputStartDate, $query->inputendDate)) {
        //             return $query;
        //         }
        //     });
                 $tasks = Task::whereRaw("(created_date >= ? AND created_date <= ?)",[$query->inputStartDate."T00:00:00", $query->inputEndDate."T23:59:59"])
                    ->where('responsible', Auth::user()->staff_no)
                    ->whereNull('deleted_at')->get();
            // dd($tasks);
            // return DataTables::of($tasks)
            //         ->addIndexColumn()
            //         ->addColumn('action', function($row){
            //             $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
            //             return $btn;
            //         })->rawColumns(['action'])->make(true);

            // $tasks = Task::whereBetween('created_date', [date($query->inputStartDate),date($query->inputendDate)])
            //         ->where('responsible', Auth::user()->staff_no)->get();

            // $tasks = Task::where('created_date', 'LIKE', "%{date($query->inputStartDate)}%")
            //     ->where('created_date', 'LIKE', "%{date($query->inputEndtDate)}%")
            //     ->where('responsible', Auth::user()->staff_no)->get();
        //    $tasks = Task::whereRaw(
        //         "(created_date >= ? AND created_date <= ?)",
        //         [$query->inputStartDate."T00:00:00", $query->inputEndDate."T23:59:59"]
        //         )->get();

        }else{
             $tasks = ['nothing'=>'yes'];
        }
        // else{
        //     $tasks = Task::where('')->get();
        // }


        return response()->json($tasks);
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
