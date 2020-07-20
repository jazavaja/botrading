<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timeframe extends Model
{
    public function indicator(){
        return $this->hasMany('App\IndicatorModel');
    }
    protected $table="timeframe";
}
