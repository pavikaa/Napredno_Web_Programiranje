<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\App;

class TasksController extends Controller
{
    public function getCreateTaskView() {
        return view('create-task');
    }

    public function createTask(Request $request) {
        $name = $request->name;
        $english_name = $request->english_name;
        $assignment = $request->assignment;
        $study_type = $request->study_type;

        $task = new Task();
        $task->name = $name;
        $task->english_name = $english_name;
        $task->assignment = $assignment;
        $task->study_type = $study_type;

        $task->save();

        return redirect('dashboard');
    }
}