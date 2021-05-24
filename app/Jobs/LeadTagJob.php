<?php

namespace App\Jobs;

use App\Models\LeadTag;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LeadTagJob implements ShouldQueue
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
        if ($this->source === 'Active Campaign') {
            (new LeadTag)->prepareAcLeadTag($this->act, $this->datePreset, 'updatedAt');
        }
    }
}
