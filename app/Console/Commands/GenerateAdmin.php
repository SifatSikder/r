<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;

class GenerateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Generate:Admin';

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
        $admin = array(
            'name' => 'System Administrator',
            'email' => 'secure.admin@mot4ai.com',
            'admin_type' => 1,
            'password' => bcrypt('12345678'),
        );
        Admin::create($admin);
        print_r(PHP_EOL.PHP_EOL);
        print_r("Admin Email : ".$admin['email'].PHP_EOL);
        print_r("Admin password : 12345678".PHP_EOL.PHP_EOL);
    }
}
