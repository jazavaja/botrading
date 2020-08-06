<?php

namespace App\Console\Commands;

use App\Http\Controllers\Telegram;
use App\Jobs\SendAnalysis;
use App\Pair;
use Illuminate\Console\Command;

class TaskForAnalysis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'work:day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'analysis agian all coins for all strategy';

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
//        Telegram::removeAlert();
//        $pair = Pair::get();
//        foreach ($pair as $item)
//        {
//            SendAnalysis::dispatch($item,"1d","0");
//        }
        Telegram::sendTelegram('JAVAD-COMMAND');
        return 0;
    }
}
