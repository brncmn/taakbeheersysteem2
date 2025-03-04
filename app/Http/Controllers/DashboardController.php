<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get tasks for the logged-in user
        $tasks = Tasks::whereIn('id', function ($query) {
            $query->select('task_id')
                  ->from('task_participants')
                  ->where('user_id', Auth::id());
        })->get();

        // Return the view with tasks
        return view('dashboard', compact('tasks'));
    }
}
