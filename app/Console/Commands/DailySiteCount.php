<?php

namespace App\Console\Commands;

use App\Http\Services\stat\DailyService;
use Illuminate\Console\Command;

class DailySiteCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:DailySiteCount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command DailySiteCount';

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
     * @return mixed
     */
    public function handle()
    {
//        DailyService::siteCount();
        DailyService::bookCount();
        DailyService::memberCount();
    }
}
