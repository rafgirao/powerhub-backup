<?php

namespace App\Jobs;

use App\Models\CampaignInsight;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FbCampaignInsightJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 5000;
    public $act;
    public $source;
    public $datePreset;


    /**
     * Create a new job instance.
     *
     * @param $act
     * @param $source
     * @param $datePreset
     */
    public function __construct($act, $source, $datePreset)
    {
        $this->act = $act;
        $this->source = $source;
        $this->datePreset = $datePreset;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->source === 'Facebook') {
            (new CampaignInsight)->listFbAdAccounts($this->act, $this->datePreset);
        }
    }
}
