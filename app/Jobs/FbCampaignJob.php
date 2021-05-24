<?php

namespace App\Jobs;

use App\Models\Campaign;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FbCampaignJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 5000;
    public $act;
    public $source;

    /**
     * Create a new job instance.
     *
     * @param $act
     * @param $source
     */
    public function __construct($act, $source)
    {
        $this->act = $act;
        $this->source = $source;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->source === 'Facebook') {
            (new Campaign)->listFbAdAccounts($this->act);
        }
    }
}
