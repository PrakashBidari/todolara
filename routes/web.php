<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ToDoListController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/dashboard',[ToDoListController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/todo', [ToDoListController::class, 'store'])->name('todo.store');
Route::put('/toDoLists/{id}', [ToDoListController::class, 'update'])->name('toDoLists.update');
Route::delete('/toDoLists/{id}', [ToDoListController::class, 'destroy'])->name('toDoLists.destroy');



