<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Func extends Model
{
    //
    public function indicator(){
        return $this->hasMany('App\indicatorModel');
    }
    protected $table="func";
}
