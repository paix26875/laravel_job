<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Uid\Ulid;

class ExampleJob implements ShouldQueue, Contracts\ShowProgressInterface
{
    use Queueable;
    use Traits\ShowProgressTraits;

    private string $jobProgressId;

    public function middleware(): array
    {
        return [new Middleware\ShowProgressMiddleware()];
    }

    public function __construct()
    {
        $this->jobProgressId = Ulid::generate();
        $this->markAsWaiting();
        Log::debug('ExampleJobのコンストラクタが実行されました。');
    }

    public function handle(): void
    {
        Log::debug('非同期処理を開始します。ExampleJob');
        // 時間がかかる処理を想定
        for ($i = 1; $i <= 5; $i++) {
            sleep(1);
            Log::debug('ExampleJob - 処理中['.$i.'s]');
        }

        Log::debug('非同期処理が完了しました。ExampleJob');
    }
}
