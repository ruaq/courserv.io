<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CourseType
 *
 * @property int $id
 * @property int|null $wsdl_id
 * @property string $name
 * @property string $slug
 * @property string $group
 * @property string|null $units
 * @property string|null $units_per_day
 * @property string|null $breaks
 * @property string|null $seats
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CourseType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseType query()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseType whereBreaks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseType whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseType whereSeats($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseType whereUnits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseType whereUnitsPerDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseType whereWsdlId($value)

 * @property string $category
 * @method static \Database\Factories\CourseTypeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseType whereCategory($value)
 */
class CourseType extends Model
{
    use HasFactory;

    protected $attributes = [
        'units' => 9,
        'units_per_day' => 9,
        'breaks' => 45,
        'seats' => 20,
    ];

    public const WSDL = [
        1 => 'EH-Ausbildung',
        2 => 'EH-Fortbildung',
        8 => 'EH Bildungseinrichtungen',
        3 => 'BS Grundlehrgang',
        4 => 'BS Aufbaulehrgang',
        5 => 'BS Fortbildung',
        6 => 'EH Lehrkräfteausbildung',
        7 => 'EH Lehrkräftefortbildung',
        //        9 => 'EH Bildungseinrichtungen Fortbildung',
    ];

    public const WSDL_DATA = [
        0 => ['units' => '0', 'units_per_day' => '0', 'breaks' => '0', 'seats' => '0'],
        1 => ['units' => 9, 'units_per_day' => 9, 'breaks' => 45, 'seats' => 20],
        2 => ['units' => 9, 'units_per_day' => 9, 'breaks' => 45, 'seats' => 20],
        3 => ['units' => 63, 'units_per_day' => 9, 'breaks' => 45, 'seats' => 20],
        4 => ['units' => 32, 'units_per_day' => 9, 'breaks' => 45, 'seats' => 20],
        5 => ['units' => 16, 'units_per_day' => 9, 'breaks' => 45, 'seats' => 20],
        6 => ['units' => 56, 'units_per_day' => 9, 'breaks' => 45, 'seats' => 20],
        7 => ['units' => 16, 'units_per_day' => 9, 'breaks' => 45, 'seats' => 20],
        8 => ['units' => 9, 'units_per_day' => 9, 'breaks' => 45, 'seats' => 20],
    ];
}
