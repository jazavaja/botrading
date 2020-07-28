<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Timeframe
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\IndicatorModel[] $indicator
 * @property-read int|null $indicator_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Timeframe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Timeframe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Timeframe query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Timeframe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Timeframe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Timeframe whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Timeframe whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Timeframe extends Model
{
    public function indicator(){
        return $this->hasMany('App\IndicatorModel');
    }
    protected $table="timeframe";
}
