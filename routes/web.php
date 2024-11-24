<?php

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('api/progress', function () {
    $waitingJobCount = Redis::command('SCARD', ['waiting']);
    $wipJobCount = Redis::command('SCARD', ['wip']);
    $totalJobCount = Redis::command('GET', ['total']);

    return response()->json([
        'waitingJobCount' => $waitingJobCount,
        'wipJobCount' => $wipJobCount,
        'totalJobCount' => $totalJobCount,
    ]);
});

Route::get('/enqueue', [App\Http\Controllers\QueuingController::class, 'enqueue'])->name('enqueue');
Route::get('/reset', [App\Http\Controllers\QueuingController::class, 'reset'])->name('reset');
