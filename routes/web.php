<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\todolistController;

Route::get('/', [todolistController::class, 'index']) -> name('home');
Route::post('/', [todolistController::class, 'store']) -> name('store');
Route::delete('/{todolist:id}', [todolistController::class, 'destroy']) -> name('destroy');
Route::post('/{todolist}/toggle-status', [todoListController::class, 'toggleStatus'])->name('status');
// Route::get('/todolists/{todolist}/edit', [todolistController::class, 'edit'])->name('todolists.edit');
Route::post('/todolists/{todolist}', [todolistController::class, 'update'])->name('update');