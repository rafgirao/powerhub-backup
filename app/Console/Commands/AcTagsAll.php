<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Jobs\TagJob;
use Illuminate\Console\Command;

class AcTagsAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tags:ac-all';

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
        $acts = Account::All();
        foreach ($acts as $key => $act) {
            TagJob::dispatch($act->id, 'Active Campaign')->onQueue('alldata');
        }
    }
}
