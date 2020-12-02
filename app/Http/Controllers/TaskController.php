<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('task.create_task');
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
            'task' => 'required',
            'key' => 'required',
            'status' => 'required',
            "created_date" => 'required',
            "resolution_date" => 'required'
        ]);
        // count the number of tasks of this kpi
        $kpi_task_count = Task::where('description', $request->key)->where('flag', 0)->count() + 1;
        //generate the task id
        $taskID = str_pad($kpi_task_count, 4, '0', STR_PAD_LEFT);
        // create task
        Task::create([
            "key" => $request->key.'-'.$taskID,
            "task" => $request->task,
            "status" => $request->status,
            "created_date" => $request->created_date,
            "resolution_date" => $request->resolution_date,
            "description" => $request->key,
            "responsible" => Auth::user()->staff_no
        ]);

        return response()->json(['success' => true, 'message' => 'Task Saved'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $key)
    {
        // get the task
        $task = Task::where('key', $key)->update([
            "task" => $request->task,
            "status" => $request->status,
            "created_date" => $request->created_date,
            "resolution_date" => $request->resolution_date,
        ]);

        return response()->json(['success'=>true, 'message'=>'Task Updated', 'kpi_key'=>$request->key], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
