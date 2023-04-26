<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getDashboardData(Request $request){
        $users = User::get();
        $loggedUser = $request->user();
        $tasks = Task::get();

        return view('dashboard', ['users' => $users, 'loggedUser'=> $loggedUser, 'tasks' => $tasks]);
    }

    public function applyForTask(Request $request) {
        $loggedUserId = $request->user()->id;
        $taskId = $request->taskId;

        $loggedUser = User::findOrFail($loggedUserId);
        $taskToApply = Task::findOrFail($taskId);

        $loggedUser->tasks()->attach($taskToApply);

        return redirect()->back();
    }

    public function getApplicationsView($taskId) {
        $task = Task::findOrFail($taskId);
        $students = $task->users()->get();
        if (count($students) < 1)  {
            return response('No students applied for the task', 404);
        }
        return view('applications', ['students' => $students, 'task' => $task]);
    }

    public function reserveTask(Request $request) {
        $taskId = $request->taskId;

        // Since user does not have a property in which to store their accepted task, the accepted 
        // task is flagged so others can not see it any more in their dashboard tasks table
        $task = Task::findOrFail($taskId);
        $task->isReserved = true;
        $task->save();

        return redirect('dashboard');

    }
}
