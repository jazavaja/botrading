<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ApiMarket
 *
 * @property int $id
 * @property string|null $api
 * @property string|null $timeframe
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApiMarket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApiMarket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApiMarket query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApiMarket whereApi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApiMarket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApiMarket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApiMarket whereTimeframe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApiMarket whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ApiMarket extends Model
{
    protected $table="api";
}
