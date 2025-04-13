<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Models\EvaluationSectors;
use App\Models\FairDecisionSectors;
use App\Models\QuestionGroups;
use App\Models\Questionnaires;
use App\Models\WebsiteSettings;
use Illuminate\Console\Command;

class DevHelper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Dev:Helper';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for generating new Admin';

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

    }
}
