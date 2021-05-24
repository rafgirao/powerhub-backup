<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Jobs\SaleJob;
use Illuminate\Console\Command;

class HotmartSalesToday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sales:hotmart-today';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Today Sales From Hotmart';

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
            SaleJob::dispatch($act->id, 'Hotmart', 'Today');
        }
    }
}
