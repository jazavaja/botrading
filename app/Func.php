<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Func
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\IndicatorModel[] $indicator
 * @property-read int|null $indicator_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Func newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Func newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Func query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Func whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Func whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Func whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Func whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Func extends Model
{
    //
    public function indicator(){
        return $this->hasMany('App\indicatorModel');
    }
    protected $table="func";
}
