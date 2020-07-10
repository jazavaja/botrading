<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function test(){
        $timeFrame="4h";
        $ta=array();
        $percent1h=[0.5,0.8,1];
        $percent4h=[2,4,6];
        if ($timeFrame=="1h"){
            $ta=$percent1h;
        }elseif ($timeFrame=="4h"){
            $ta=$percent4h;
        }
        echo "Target 1:.... $ta[0] .... profit ";
    }
}
