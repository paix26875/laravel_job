<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ExampleJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        Log::debug('ExampleJobのコンストラクタが実行されました。');
    }

    /**
     * Execute the job.
     */
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
