<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Jobs\DashboardStatsJob;
use Illuminate\Console\Command;

class DashboardStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Total Last Week Sales';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $acts = Account::All();
        foreach ($acts as $act) {
            DashboardStatsJob::dispatch($act->id);

        }
    }
}
