<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $tasks = Tasks::whereBetween('due_date', [$startOfWeek, $endOfWeek])
                        ->whereHas('participants', function($query) {
                            $query->where('user_id', auth()->id());
                        })
                        ->with('participants')
                        ->get()
                        ->groupBy('status');

        return view('dashboard', compact('tasks'));
    }
}
