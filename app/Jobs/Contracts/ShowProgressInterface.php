<?php

namespace App\Jobs\Contracts;

interface ShowProgressInterface
{
    public function markAsWaiting();
    public function markAsWip();
    public function markAsFinished();
}