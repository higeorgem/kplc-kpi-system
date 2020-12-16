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
        // get tasks 
        $tasks = Task::latest()->get();

        return view('task.tasks');
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
        if($fileSize <= $maxFileSize){
         // move the file to temp file upload directory
            $location = 'temp_uploads';
            $file->move($location,$filename);
            // Import CSV to Database
          $filepath = public_path($location."/".$filename);

          // Reading file
          $file = fopen($filepath,"r");
            
          // file variables
            $importData_arr = array();
            $i = 0;

            if ($file) {
                // get the file store values into and array 
                while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                 $num = count($filedata );
                 
                 // Skip first row (Remove below comment if you want to skip the first row)
                 /*if($i == 0){
                    $i++;
                    continue; 
                 }*/
                 for ($c=0; $c < $num; $c++) {
                    $importData_arr[$i][] = $filedata [$c];
                 }
                 $i++;
              }
              // close file
                fclose($file);
            } else {
                flash("Unable to open file")->warning();
            }
          

          // Insert to MySQL database
            foreach($importData_arr as $importData){

                $insertData = array(
                   "key"=>$importData[1],
                   "task"=>$importData[2],
                   "status"=>$importData[3],
                   "created_date"=>$importData[4],
                   "resolution_date"=>$importData[5],
                   "description"=>$importData[6],
                   "responsible"=>Auth::user()->staff_no);

                Task::create($insertData);

            }

        }else{
          flash('message','File too large. File must be less than 2MB.')->warning();
        }
        flash('File Successfully Uploaded')->success();
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
            'status' => 'required',
            "created_date" => 'required',
            "resolution_date" => 'required'
        ]);
        // count the number of tasks of this kpi
        $kpi_task_count = Task::withTrashed()->where('description', $request->key)->where('flag', 0)->count() + 1;
        //generate the task id
        $taskID = str_pad($kpi_task_count, 4, '0', STR_PAD_LEFT);
        // create task
        Task::create([
            "key" => $request->key . '-' . $taskID,
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

        return response()->json(['success' => true, 'message' => 'Task Updated', 'kpi_key' => $request->key], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($key)
    {
        $task = Task::where('key', $key)->first();

        $task->delete();

        return response()->json(['success' => true, 'message' => 'Task Deleted', $task]);
    }
}
