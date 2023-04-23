<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',function(){
    return view('auth.login');
})->middleware(['auth']);

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    // Ruta za prikaz obrasca za otvaranje novog projekta
    Route::get('/projects/create', [App\Http\Controllers\ProjectController::class, 'create'])->name('projects.create');
    
    // Ruta za spremanje novog projekta
    Route::post('/projects', [App\Http\Controllers\ProjectController::class, 'store'])->name('projects.store');
    
    // Ruta za prikaz pojedinog projekta
    Route::get('/projects/{project}', [App\Http\Controllers\ProjectController::class, 'show'])->name('projects.show');
    
    // Ruta za prikaz obrasca za uređivanje pojedinog projekta
    Route::get('/projects/{project}/edit', [App\Http\Controllers\ProjectController::class, 'edit'])->name('projects.edit');
    
    // Ruta za ažuriranje pojedinog projekta
    Route::put('/projects/{project}', [App\Http\Controllers\ProjectController::class, 'update'])->name('projects.update');
    
    // Ruta za brisanje pojedinog projekta
    Route::delete('/projects/{project}', [App\Http\Controllers\ProjectController::class, 'destroy'])->name('projects.destroy');
    
    // Ruta za prikaz svih projekata za prijavljenog korisnika
    Route::get('/projects', [App\Http\Controllers\ProjectController::class, 'index'])->name('projects.index');
 });
 
