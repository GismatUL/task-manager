<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

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

Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks', [TaskController::class, 'create'])->name('tasks.create');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');

Route::get('/tasks/edit/{task}', [TaskController::class, 'edit'])->name('tasks.edit');
Route::put('/tasks/update/{task}', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/destroy/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

Route::post('/tasks/update-order', [TaskController::class, 'updateOrder'])->name('tasks.updateOrder');

