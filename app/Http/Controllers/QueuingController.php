<?php

namespace App\Http\Controllers;

use App\Jobs\ExampleJob;
use Illuminate\Support\Facades\Log;

class QueuingController
{
    public function enqueue(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        ExampleJob::dispatch();
        Log::debug('Job has been queued');
        return redirect('/');
    }

}