<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Jobs\EmailInvalidJob;
use Illuminate\Console\Command;

class AcEmailInvalidAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emailinvalid:ac-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Today Leads From Active Campaign';

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
        EmailInvalidJob::dispatch(21426, 'Active Campaign', 'All');
    }
}
