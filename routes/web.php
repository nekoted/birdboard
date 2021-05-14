<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

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
    Route::get('/projects', [ProjectController::class, "index"]);
    Route::get('/projects/create', [ProjectController::class, "create"]);
    Route::get('/projects/{project}', [ProjectController::class, "show"]);
    Route::post('/projects', [ProjectController::class, "store"]);
});



require __DIR__ . '/auth.php';
