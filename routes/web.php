<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectTasksController;

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

Route::view('/', 'welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('/projects', [ProjectController::class, "index"])->name('projects');
    Route::get('/projects/create', [ProjectController::class, "create"]);
    Route::get('/projects/{project}/edit', [ProjectController::class, "edit"]);
    Route::get('/projects/{project}', [ProjectController::class, "show"]);
    Route::patch('/projects/{project}', [ProjectController::class, "update"]);
    
    Route::post('/projects', [ProjectController::class, "store"]);
    Route::post('/projects/{project}/tasks', [ProjectTasksController::class, "store"]);
    Route::patch('/projects/{project}/tasks/{task}', [ProjectTasksController::class, "update"]);
});



require __DIR__ . '/auth.php';
