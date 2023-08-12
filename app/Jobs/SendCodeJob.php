<?php

namespace App\Jobs;

use App\Packages\CodeSender\Interfaces\CodeSender;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendCodeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private string $code,
        private string $to
    ) {}

    /**
     * Execute the job.
     */
    public function handle(CodeSender $codeSender): void
    {
        $codeSender->send($this->code, $this->to);
    }
}
