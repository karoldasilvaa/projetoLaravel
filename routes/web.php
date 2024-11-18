<?php

use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\TaskController;

Route::get('/', [TaskController::class, 'index']);
Route::get('/tasks/create/{id?}', [TaskController::class, 'create']);
Route::post("/tasks", [TaskController::class, 'store']);

Route::get('/contact', function() {
    return view('contact');
});