<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task_participants extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id', 'user_id', 'assigned_at'
    ];

    // A Task_participant belongs to a Task
    public function task()
    {
        return $this->belongsTo(Tasks::class);
    }

    // A Task_participant belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

