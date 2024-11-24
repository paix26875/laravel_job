<?php

namespace App\Jobs\Middleware;

use App\Jobs\Contracts\ShowProgressInterface;
use Closure;

class ShowProgressMiddleware
{
    public function handle(ShowProgressInterface $job, Closure $next): void
    {
        $job->markAsWip();
        try {
            $next($job);
        } finally {
            $job->markAsFinished();
        }
    }
}