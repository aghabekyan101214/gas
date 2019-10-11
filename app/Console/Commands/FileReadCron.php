<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\FileReadController;

class FileReadCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'file:cron';

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
     * @return mixed
     */
    public function handle($count = null)
    {
        if($count == 12) return;
        \Log::info("Cron is working fine! + $count");
        FileReadController::start();
        sleep(5);
        $count = $count == null ? 1 : $count + 1;
        $this->handle($count);
    }
}
