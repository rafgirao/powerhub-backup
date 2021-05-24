<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Jobs\ProductJob;
use Illuminate\Console\Command;

class HotmartProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:hotmart-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Products From Hotmart';

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
            ProductJob::dispatch($act->id, 'Hotmart');
        }
    }
}
