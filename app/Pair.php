<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Pair
 *
 * @property int $id
 * @property string|null $pair
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pair newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pair newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pair query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pair whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pair wherePair($value)
 * @mixin \Eloquent
 */
class Pair extends Model
{
    protected $table="pairs";
}
