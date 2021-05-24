<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Jobs\LeadJob;
use Illuminate\Console\Command;

class HotmartLeads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leads:hotmart-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Leads From Hotmart';

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
        foreach ($acts as $key => $act) {
            LeadJob::dispatch($act->id, 'Hotmart', 'All');
        }
    }
}
