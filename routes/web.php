<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectTasksController;
use App\Http\Controllers\ProjectInvitationController;

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
    Route::resource('projects', ProjectController::class);
    Route::post('/projects/{project}/tasks', [ProjectTasksController::class, "store"]);
    Route::patch('/projects/{project}/tasks/{task}', [ProjectTasksController::class, "update"]);
    Route::post('/projects/{project}/invite', [ProjectInvitationController::class, "invite"]);
});



require __DIR__ . '/auth.php';
