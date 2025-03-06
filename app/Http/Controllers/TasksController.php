<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use App\Models\User;
use App\Models\Files;
use App\Models\Task_participants;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin = auth()->user();
        $tasks = Tasks::where('created_by', $admin->id)->get();
        $users = User::all();
        return view('admin.managetasks', compact('tasks', 'users'));
    }
    public function taskFiles()
    {
        // Get the logged-in user's ID
        $userId = Auth::id();

        // Fetch files where the logged-in user is a participant in the task
        $files = Files::whereHas('task', function ($query) use ($userId) {
            $query->whereHas('participants', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            });
        })->with('task')->get();

        return view('tasks.taskFiles', compact('files'));
    }


    public function updateStatus(Request $request, $taskId)
    {
        $task = Tasks::findOrFail($taskId);
        $task->status = $request->status;
        $task->save();

        return redirect()->route('dashboard')->with('status', 'Taakstatus bijgewerkt!');
    }
    public function allTasks()
    {
        $tasks = Tasks::all(); // Or you could filter tasks as per your requirement
        $users = User::all();

        return view('admin.alltasks', compact('tasks', 'users'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validate incoming data
    $data = $request->validate([
        'name' => 'required',
        'participants' => 'required|array', // Ensure participants is an array
        'taskdescription' => 'required',
        'information' => 'nullable',
        'due_date' => 'required|date',
        'files.*' => 'nullable|file|mimes:jpg,png,pdf|max:10240'
    ]);

    // Create the new task
    $task = new Tasks();
    $task->name = $data['name'];
    $task->description = $data['taskdescription'];
    $task->comments = $data['information'];
    $task->due_date = $data['due_date'];
    $task->created_by = Auth::id(); // Set the current user as creator
    $task->save();  // Save the task to the tasks table

    if($request->hasFile('file')){
        $file = $request->file('file');
        $filePath = $file->store('task_files', 'public');

        $taskFile = new Files();
        $taskFile->task_id = $task->id;
        $taskFile->file_path = $filePath;
        $taskFile->file_name = $file->getClientOriginalName();
        $taskFile->save();
    }
    // Loop through the participants and add them to the task_participants table
    if (is_array($data['participants'])) {
        foreach ($data['participants'] as $participantId) {
            Task_participants::create([
                'task_id' => $task->id, // Link the participant to the task
                'user_id' => $participantId, // Assign the participant
                'assigned_at' => now(), // Timestamp of when the participant is assigned
            ]);
        }
    }

    // Flash success message and redirect to the task management page
    session()->flash('success', 'Taak succesvol toegevoegd!');
    return redirect()->route('admin.managetasks');  
}

    /**
     * Display the specified resource.
     */
    public function show(Tasks $tasks)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tasks $tasks)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Find the task by ID
    $task = Tasks::findOrFail($id);

    // Validate the incoming request data (optional, but recommended)
    $request->validate([
        'name' => 'required|string|max:255',
        'taskdescription' => 'nullable|string',
        'comments' => 'nullable|string',
        'due_date' => 'nullable|date',
        'status' => 'required|in:To Do,In Progress,Completed,On Hold',
    ]);

    // Update the task with the data from the form
    $task->update([
        'name' => $request->name,
        'taskdescription' => $request->taskdescription,
        'comments' => $request->comments,
        'due_date' => $request->due_date,
        'status' => $request->status,
    ]);

    // Return back to the manage tasks page with a success message
    return redirect()->route('admin.managetasks')->with('success', 'Task updated successfully');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tasks $tasks)
    {
        $tasks->delete();
        session()->flash('success', 'Task deleted successfully.');

        // Redirect back to the tasks management page   
        return redirect()->route('admin.managetasks');
    }
}
