<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Jobs\FbCampaignInsightJob;
use App\Jobs\FbCampaignJob;
use App\Jobs\FbInsightJob;
use Illuminate\Console\Command;

class FbCampaigns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaign:fb {act?} {--dp=t}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return void
     */
    public function handle()
    {
        if ($this->argument('act')) {
            $this->executeJob($this->argument('act'));
        } else {
            $acts = Account::All();
            foreach ($acts as $act) {
                $this->executeJob($act->id);
            }
        }
    }

    /**
     * @param int $act
     * @return void
     */
    protected function executeJob(Int $act)
    {
        FbCampaignJob::dispatch($act, 'Facebook')->onQueue('alldata');
        FbInsightJob::dispatch($act, 'Facebook')->onQueue('alldata');
        FbCampaignInsightJob::dispatch($act, 'Facebook',$this->option('dp'))->onQueue('alldata');
    }
}
