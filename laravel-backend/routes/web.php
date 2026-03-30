<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrudController;

Route::get('/', function () {
    return view('welcome');
});

// CRUD Routes
Route::get('/crud', [CrudController::class, 'index'])->name('crud.index');
Route::get('/crud/create', [CrudController::class, 'create'])->name('crud.create');
Route::post('/crud', [CrudController::class, 'store'])->name('crud.store');
Route::get('/crud/{id}', [CrudController::class, 'show'])->name('crud.show');
Route::get('/crud/{id}/edit', [CrudController::class, 'edit'])->name('crud.edit');
Route::put('/crud/{id}', [CrudController::class, 'update'])->name('crud.update');
Route::get('/crud/{id}/delete', [CrudController::class, 'delete'])->name('crud.delete');
Route::delete('/crud/{id}', [CrudController::class, 'destroy'])->name('crud.destroy');
