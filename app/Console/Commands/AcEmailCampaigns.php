<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Jobs\EmailCampaignJob;
use Illuminate\Console\Command;

class AcEmailCampaigns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaign:ac {act?} {--p=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Tags From Active Campaign';

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
        EmailCampaignJob::dispatch($act, 'Active Campaign')->onQueue('alldata');
    }
}
