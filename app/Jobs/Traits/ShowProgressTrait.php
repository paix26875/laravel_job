<?php

namespace App\Jobs\Traits;

use Illuminate\Support\Facades\Redis;

trait ShowProgressTrait
{
    public function markAsWaiting(): void
    {
        Redis::command('SADD', ['waiting', $this->jobProgressId]);
    }

    public function markAsWip(): void
    {
        Redis::command('SMOVE', ['waiting', 'wip', $this->jobProgressId]);
    }

    public function markAsFinished(): void
    {
        Redis::command('SREM', ['wip', $this->jobProgressId]);
        if (Redis::command('SCARD', ['wip']) === 0 && Redis::command('SCARD', ['waiting']) === 0) {
            Redis::command('DEL', ['total']);
        }
    }
}