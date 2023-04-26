<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\Controller;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [Controller::class, 'getDashboardData'])
->middleware(['auth'])
->name('dashboard');

Route::get('/edit/{id}', [UserController::class, 'getRoleEditingView'])
->middleware('auth')
->name('edit.role');

Route::post('/edit/{id}', [UserController::class, 'editRoleForUser'])
->middleware('auth');

Route::get('/createTask', [TasksController::class, 'getCreateTaskView'])
->middleware('auth')
->name('create.task');

Route::post('/createTask', [TasksController::class, 'createTask'])
->middleware('auth');

Route::post('/applyForTask', [Controller::class, 'applyForTask'])
->middleware('auth')
->name('apply.for.task');

Route::get('/getApplicationsView/{taskId}', [Controller::class, 'getApplicationsView'])
->middleware('auth');

Route::post('/reserveTask', [Controller::class, 'reserveTask'])
->middleware('auth')
->name('reserve.task');

Route::get('/locale/{locale}', function ($locale) {
    session()->put('locale', $locale);
    return redirect()->back();
})
->name('locale/{locale}');


require __DIR__.'/auth.php';