<?php

namespace App\Console\Commands;

use App\Jobs\SheetJob;
use App\Models\Project;
use Illuminate\Console\Command;

class GoogleSheetsSales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sales:sheets {proj?} {--dp=20}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Sales Sheet';

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
     * @return void
     */
    public function handle()
    {
        if ($this->argument('proj')) {
            $project = Project::find($this->argument('proj'));
            $this->executeJob($project);
        } else {
            $projects = Project::All();
            foreach ($projects as $project) {
                $this->executeJob($project);
            }
        }
    }

    /**
     * @param $project
     * @return void
     */
    protected function executeJob($project)
    {
        SheetJob::dispatch($project, $this->option('dp'))->onQueue('alldata');
    }
}
