<?php

namespace App\Jobs;

use App\Models\Stat;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DashboardStatsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 5000;
    private $act;

    /**
     * Create a new job instance.
     *
     * @param $act
     */
    public function __construct($act)
    {
        $this->act = $act;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $datePresets = [
            'All',
            'Today',
            'Yesterday',
            'Last 7 Days',
            'Last 14 Days',
            'Last 30 Days',
            'Last 60 Days',
            'Last 90 Days',
            'Last 180 Days',
            'Last 365 Days',
        ];

        $datePresetsBefore = [
            'All Before',
            'Today Before',
            'Yesterday Before',
            'Last 7 Days Before',
            'Last 14 Days Before',
            'Last 30 Days Before',
            'Last 60 Days Before',
            'Last 90 Days Before',
            'Last 180 Days Before',
            'Last 365 Days Before',
        ];

        foreach ($datePresets as $datePreset) {
            (new Stat)->leadsStats($this->act, $datePreset, 'leadsCount');
            (new Stat)->salesStats($this->act, $datePreset, 'salesCount');
            (new Stat)->salesStats($this->act, $datePreset, 'salesValue');
            (new Stat)->trafficStats($this->act, $datePreset, 'trafficValue');
            (new Stat)->chartSalesCountStats($this->act, $datePreset, 'chartSalesCount');
            (new Stat)->chartSalesSumStats($this->act, $datePreset, 'chartSalesSum');
        }

        foreach ($datePresetsBefore as $datePresetBefore) {
            (new Stat)->leadsStats($this->act, $datePresetBefore, 'leadsCount');
            (new Stat)->salesStats($this->act, $datePresetBefore, 'salesCount');
            (new Stat)->salesStats($this->act, $datePresetBefore, 'salesValue');
            (new Stat)->trafficStats($this->act, $datePresetBefore, 'trafficValue');
        }
    }
}
