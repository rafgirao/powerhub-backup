<?php

namespace App\Console\Commands;

use App\Jobs\TagJob;
use App\Models\ProjectDet;
use Illuminate\Console\Command;

class AcTagsProjects extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tags:ac-projects';

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
     * @return int
     */
    public function handle()
    {
        ProjectDet::where('key_type','App\Tag')->get();
    }
}
