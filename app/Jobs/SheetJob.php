<?php

namespace App\Jobs;

use App\Models\Sale;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class SheetJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 5000;
    public $project;
    public $datePreset;

    /**
     * Create a new job instance.
     *
     * @param $project
     * @param $datePreset
     */
    public function __construct($project, $datePreset)
    {
        $this->project = $project;
        $this->datePreset = $datePreset;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Exception
     */
    public function handle()
    {
        if ($this->project->end_at > Carbon::now()->subDays(30)->format('Y-m-d')) {

            if ($this->datePreset != 0) {
                $datePreset = $this->datePreset;
            } else {
                $now = Carbon::now();
                $start = Carbon::createFromDate($this->project->start_at);
                $datePreset = $start->diffInMinutes($now);
            }

            (new Sale)->updateSpreadsheet($this->project, $datePreset);
        }
    }
}
