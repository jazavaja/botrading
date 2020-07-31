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

class SendAnalysis implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $pair;
    protected $time;
    protected $strategy;

    public function __construct($pair, $time, $strategy)
    {
        $this->strategy = $strategy;
        $this->pair = $pair;
        $this->time = $time;
    }

    public function handle()
    {
        $pair = $this->pair["pair"];
        $type = $this->pair["type"];
        $strategy = new StrategyController();
        $tt = new Telegram();
        if ($this->strategy=="0" && $type="spot"){
            $strategy->strategyFarshad($pair,$this->time);
        }
    }
}
