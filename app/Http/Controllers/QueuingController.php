<?php

namespace App\Http\Controllers;

use App\Jobs\ExampleJob;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class QueuingController
{
    public function enqueue(): \Illuminate\Http\JsonResponse
    {
        ExampleJob::dispatch();
        Redis::command('INCR', ['total']);
        Log::debug('Job has been queued');
        return response()->json(['message' => 'Job has been queued']);
    }

    public function reset(): \Illuminate\Http\JsonResponse
    {
        Redis::command('DEL', ['waiting']);
        Redis::command('DEL', ['wip']);
        Redis::command('DEL', ['total']);
        Artisan::call('queue:clear'); // なんかhorizon:clearが使えないのでqueue:clearを使う
        return response()->json(['message' => 'Reset']);
    }

}