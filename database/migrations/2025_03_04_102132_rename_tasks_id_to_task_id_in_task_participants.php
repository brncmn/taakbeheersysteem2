<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('task_participants', function (Blueprint $table) {
            if (Schema::hasColumn('task_participants', 'tasks_id')) {
                $table->renameColumn('tasks_id', 'task_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('task_participants', function (Blueprint $table) {
            if (Schema::hasColumn('task_participants', 'task_id')) {
                $table->renameColumn('task_id', 'tasks_id');
            }
        });
    }
};
