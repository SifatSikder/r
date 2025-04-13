<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Models\EvaluationSectors;
use App\Models\FairDecisionSectors;
use App\Models\QuestionGroups;
use App\Models\Questionnaires;
use App\Models\WebsiteSettings;
use App\Models\Workshops;
use Illuminate\Console\Command;

class GenerateWorkshops extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Generate:Workshops';

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
        Workshops::where('uid', '>', 0)->delete();

        $workShops = array(
            ['uid' => 1, 'title' => 'Safety and Operational Assurance Evaluation of AI Systems', 'date' => date('2023-11-23'), 'venue' => 'Teesside University', 'code' => 'MOT4AI23T'],
            ['uid' => 3, 'title' => 'Risk of AI in Education and Businesses', 'date' => date('2023-12-04'), 'venue' => 'Cambodia', 'code' => 'MOT4AI4C'],
            ['uid' => 2, 'title' => 'Safety and Operational Assurance of AI Systems', 'date' => date('2023-12-09'), 'venue' => 'Malaysia', 'code' => 'M9MOT4AI'],
        );
        Workshops::insert($workShops);

    }
}
