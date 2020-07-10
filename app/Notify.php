<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Notify
 *
 * @property int $id
 * @property string $pair
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property int $timeNotify
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Notify newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Notify newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Notify query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Notify whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Notify whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Notify wherePair($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Notify whereTimeNotify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Notify whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Notify extends Model
{
    protected $table="alerts";
}
