<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use App\Models\User;
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
        $tasks = Tasks::all();
        $users = User::all();
        return view('admin.managetasks', compact('tasks', 'users'));
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
        $data = $request->validate([
            'name' => 'required',
            'participants' => 'required',
            'taskdescription' => 'required',
            'information' => 'nullable',
            'due_date' => 'required|date'
        ]);

        $tasks = new Tasks();
        $tasks->name = $data['name'];
        $tasks->user_id = $data['participants'];
        $tasks->description = $data['taskdescription'];
        $tasks->comments = $data['information'];
        $tasks->due_date = $data['due_date'];
        $tasks->created_by = Auth::id();

        $tasks->save();
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
    public function update(Request $request, Tasks $tasks)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tasks $tasks)
    {
        //
    }
}
