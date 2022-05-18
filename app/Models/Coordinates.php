<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Coordinates
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Coordinates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coordinates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coordinates query()
 * @mixin \Eloquent
 * @property string $country_code
 * @property string $zipcode
 * @property string $location
 * @property string $state
 * @property string $lat
 * @property string $lon
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Coordinates whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coordinates whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coordinates whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coordinates whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coordinates whereLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coordinates whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coordinates whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coordinates whereZipcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coordinates test()
 * @property int $id
 * @method static \Illuminate\Database\Eloquent\Builder|Coordinates whereId($value)
 */
class Coordinates extends Model
{
    use HasFactory;
    use Search;

    protected array $searchable = [
        'zipcode',
        'location',
    ];

}
