<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\IndicatorModel
 *
 * @property int $id
 * @property string $name
 * @property string $setting
 * @property int $timeFrame
 * @property string $backtrack
 * @property string $exchange
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|IndicatorModel newModelQuery()
 * @method static Builder|IndicatorModel newQuery()
 * @method static Builder|IndicatorModel query()
 * @method static Builder|IndicatorModel whereBacktrack($value)
 * @method static Builder|IndicatorModel whereCreatedAt($value)
 * @method static Builder|IndicatorModel whereDescription($value)
 * @method static Builder|IndicatorModel whereExchange($value)
 * @method static Builder|IndicatorModel whereId($value)
 * @method static Builder|IndicatorModel whereName($value)
 * @method static Builder|IndicatorModel whereSetting($value)
 * @method static Builder|IndicatorModel whereTimeFrame($value)
 * @method static Builder|IndicatorModel whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Func $nama
 * @property-read \App\Timeframe $timeframe
 */
class IndicatorModel extends Model
{
    protected $table="indicator";

    protected $casts=[
        'setting'=>'array'
    ];
    public function name(){
        return $this->belongsTo('App\func','name');
    }
    public function timeframe(){
        return $this->belongsTo('App\Timeframe','timeFrame');
    }
    public function nama(){
        return $this->belongsTo('App\func');
    }
}
