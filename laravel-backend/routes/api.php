<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ArticlesController;

Route::resource('students', ArticlesController::class)->only(['index', 'show', 'store', 'update', 'destroy']);