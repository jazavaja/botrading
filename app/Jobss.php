<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Jobss
 *
 * @property int $id
 * @property string $queue
 * @property string $payload
 * @property int $attempts
 * @property int|null $reserved_at
 * @property int $available_at
 * @property \Illuminate\Support\Carbon $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jobss newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jobss newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jobss query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jobss whereAttempts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jobss whereAvailableAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jobss whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jobss whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jobss wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jobss whereQueue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jobss whereReservedAt($value)
 * @mixin \Eloquent
 */
class Jobss extends Model
{
    protected $table="jobs";
}
