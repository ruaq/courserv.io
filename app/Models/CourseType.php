<?php

/*
| Copyright 2023 courservio.de
|
| Licensed under the EUPL, Version 1.2 or – as soon they
| will be approved by the European Commission - subsequent
| versions of the EUPL (the "Licence");
| You may not use this work except in compliance with the
| Licence.
| You may obtain a copy of the Licence at:
|
| https://joinup.ec.europa.eu/software/page/eupl
|
| Unless required by applicable law or agreed to in
| writing, software distributed under the Licence is
| distributed on an "AS IS" basis,
| WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
| express or implied.
| See the Licence for the specific language governing
| permissions and limitations under the Licence.
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CourseType
 *
 * @property int $id
 * @property int|null $wsdl_id
 * @property int|null $cert_template_id
 * @property string $name
 * @property string $category
 * @property string $slug
 * @property string|null $iframe_url
 * @property int $units
 * @property int $units_per_day
 * @property int $breaks
 * @property int $seats
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CertTemplate|null $certTemplate
 *
 * @method static \Database\Factories\CourseTypeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseType query()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseType whereBreaks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseType whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseType whereCertTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseType whereIframeUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseType whereSeats($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseType whereUnits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseType whereUnitsPerDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseType whereWsdlId($value)
 * @mixin \Eloquent
 */
class CourseType extends Model
{
    use HasFactory;

    public function certTemplate(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CertTemplate::class);
    }

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
