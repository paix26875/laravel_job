<?php

namespace App\Http\Controllers;

use App\Jobs\ExampleJob;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class QueuingController
{
    public function enqueue(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        ExampleJob::dispatch();
        Redis::command('INCR', ['total']);
        Log::debug('Job has been queued');
        return redirect('/');
    }

    public function reset(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        Redis::command('DEL', ['waiting']);
        Redis::command('DEL', ['wip']);
        Redis::command('DEL', ['total']);
        return redirect('/');
    }

}