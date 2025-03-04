<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'comments', 'due_date', 'status', 'created_by'
    ];

    // One Task can have many participants (users who are assigned to the task)
    public function participants()
    {
        return $this->hasMany(Task_participants::class, 'task_id');
    }

    // Task has many users via the pivot table task_user (many-to-many relationship)
    public function users()
    {
        return $this->belongsToMany(User::class, 'task_user', 'task_id', 'user_id');
    }

    // Task has many files
    public function files()
    {
        return $this->hasMany(Files::class, 'task_id');
    }
}
