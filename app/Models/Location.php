<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Location
 *
 * @property string $zipcode
 * @property string $location
 * @property string $state
 * @method static \Illuminate\Database\Eloquent\Builder|Location newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Location newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Location query()
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereZipcode($value)
 * @mixin \Eloquent
 */
class Location extends Model
{
    use HasFactory;
    use Search;

    protected array $searchable = [
        'zipcode',
        'location',
    ];
}
