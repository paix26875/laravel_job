<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/enqueue', [App\Http\Controllers\QueuingController::class, 'enqueue'])->name('enqueue');
