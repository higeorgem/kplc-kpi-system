<?php

namespace App\Http\Controllers;

use App\KPI;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use File;
use Illuminate\Support\Facades\File as FacadesFile;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        // get tasks
        $my_tasks = Task::where('user_id', $user->staff_no)
            ->latest()
            ->get();
        // dd($my_tasks);

        return view('task.tasks', ['my_tasks' => $my_tasks]);
    }
    public function closeTask($id)
    {
        $task = Task::where('id', $id)
            ->update([
                'status' => 'closed',
                'resolution_date' => \Carbon\Carbon::now()
                ]);

        return response()->json(['success' => true, 'message' => 'Task Saved', 'data' => $task], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kpis = [];
        $user = Auth::user();
        if ($user->roles('User')) {
            $kpis = KPI::where('structure', 'sections')
                    ->where('structure_id', $user->section_id)->get();
        }
        // dd($kpis);
        return view('task.create_task', ['kpis'=>$kpis]);
    }
    /**
     * get the task template.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTemplate()
    {

        return Storage::disk('public')
            ->download(
                'tasks_sample_template.csv',
                'tasks_sample_template.csv',
                [
                    'Content-Description' =>  'File Transfer',
                    'Content-Type' => 'application/octet-stream',
                    'Content-Disposition' => 'attachment; filename=tasks_sample_template.csv'
                ]
            );
    }
    /**
     * Show the form for uploading a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showUploadTaskForm()
    {
        return view('task.upload_tasks');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeUploadTask(Request $request)
    {
        // validation
        $request->validate([
            'task_file' => 'required|mimes:csv,txt'
        ]);
        // get file
        $file = $request->file('task_file');
        // File Details
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $tempPath = $file->getRealPath();
        $fileSize = $file->getSize();
        $mimeType = $file->getMimeType();
        // 2MB in Bytes
        $maxFileSize = 2097152;
        // Check file size
        if ($fileSize <= $maxFileSize) {
            // move the file to temp file upload directory
            $location = 'temp_uploads';
            $file->move($location, $filename);
            // Import CSV to Database
            $filepath = public_path($location . "/" . $filename);

            // Reading file
            $file = fopen($filepath, "r");

            // file variables
            $importData_arr = array();
            $i = 0;

            if ($file) {
                // get the file store values into and array
                while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                    $num = count($filedata);

                    // Skip first row
                    if ($i == 0) {
                        $i++;
                        continue;
                    }

                    for ($c = 0; $c < $num; $c++) {
                        $importData_arr[$i][] = $filedata[$c];
                    }
                    $i++;
                }
                // close file
                fclose($file);
            } else {
                flash("Unable to open file")->warning();
            }
            // dd($importData_arr);
            // Insert to MySQL database
            foreach ($importData_arr as $key => $importData) {
                // count the number of tasks of this kpi
                $kpi_task_count = Task::withTrashed()
                    ->where('description', $importData[0])
                    ->where('flag', 0)->count() + 1;

                //generate the task id
                $taskID = str_pad($kpi_task_count, 4, '0', STR_PAD_LEFT);

                // if (empty($importData[$key])) {
                //     flash('Empty values Are not allowed.')->warning();
                //     return redirect()->back();
                // }else {
                $insertData = array(
                    "key" => $importData[0] . '-' . $taskID,
                    "task" => $importData[1],
                    "status" => $importData[2],
                    "created_date" => $importData[3],
                    "resolution_date" => $importData[4],
                    "description" => $importData[0],
                    "responsible" => Auth::user()->staff_no
                );

                Task::create($insertData);
                // }
            }
            flash('File Successfully Uploaded')->success();
        } else {
            flash('message', 'File too large. File must be less than 2MB.')->warning();
        }
        // Redirect to index
        return redirect()->route('tasks.index');
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
            // 'status' => 'required',
            "created_date" => 'required',
            // "resolution_date" => 'required'
        ]);
        // count the number of tasks of this kpi
        $kpi_task_count = Task::withTrashed()->where('kpi_id', $request->key)->where('flag', 0)->count() + 1;
        //generate the task id
        $taskID = str_pad($kpi_task_count, 4, '0', STR_PAD_LEFT);
        // create task
        Task::create([
            "key" => $request->key . '-' . $taskID,
            "task" => $request->task,
            "status" => 'open',
            "created_date" => date('Y-m-d h:i:s', strtotime($request->created_date)),
            // "resolution_date" => $request->resolution_date,
            "kpi_id" => $request->key,
            "user_id" => Auth::user()->staff_no
        ]);

        flash('Task Created.')->success();

        return redirect()->route('tasks.index');
        // return response()->json(['success' => true, 'message' => 'Task Saved'], 200);
    }

    /**
     * Display the specified resources.
     *
     * @param  $task
     * @return \Illuminate\Http\Response
     */
    public function showTasks($task)
    {
        $target = Task::where('description', $task)
            ->where('responsible', Auth::user()->staff_no)->get();
        return response()->json($target, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return response()->json($task);
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
    public function update(Request $request, Task $task)
    {
        // get the task
        $task->update([
            "key" => $request->kpi,
            "task" => $request->task,
            // "status" => $request->status,
            "created_date" => date('Y-m-d h:i:s', strtotime($request->created_date)),
            // "resolution_date" => $request->resolution_date,
        ]);

        return response()->json(['success' => true, 'message' => 'Task Updated', 'kpi_key' => $request->key], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        // dd('here');
        // $task = Task::where('key', $key)->first();

        $task->delete();

        return response()->json(['success' => true, 'message' => 'Task Deleted', $task]);
    }
}
