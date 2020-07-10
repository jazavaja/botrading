<?php

namespace App\Jobs;

use App\Http\Controllers\StrategyController;
use App\Http\Controllers\Telegram;
use App\Pair;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Tests implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


//    protected $pair;

    public function __construct()
    {
//        $this->pair = $pair;
    }

    public function handle()
    {
        $tt=new Telegram();
        $tt->sendTelegram("javad");
    }
}
