<?php

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')->group(function () {
    Route::get('/progress', function () {
        $waitingJobCount = Redis::command('SCARD', ['waiting']);
        $wipJobCount = Redis::command('SCARD', ['wip']);
        $totalJobCount = Redis::command('GET', ['total']);

        return response()->json([
            'waitingJobCount' => $waitingJobCount,
            'wipJobCount' => $wipJobCount,
            'totalJobCount' => $totalJobCount,
        ]);
    });

    Route::post('/enqueue', [App\Http\Controllers\QueuingController::class, 'enqueue']);
    Route::post('/reset', [App\Http\Controllers\QueuingController::class, 'reset']);
});
