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

    public function __construct($pair)
    {
        $this->pair = $pair;
    }

    public function handle()
    {
        $pair = $this->pair["pair"];
        $type = $this->pair["type"];
        $strategy=new StrategyController();
        $tt=new Telegram();
        if ($type == "Margin")
        {
            $strategy->strategyTeamtextMarginCoin($pair,"1h");
            $strategy->strategyTeamtextMarginCoin($pair,"4h");
            $strategy->strategyTeamtextMarginCoin($pair,"1d");
        }
    }
}
