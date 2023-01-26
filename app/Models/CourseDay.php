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
 * App\Models\CourseDay
 *
 * @property int $id
 * @property int $course_id
 * @property string $date
 * @property string $startPlan
 * @property string|null $startReal
 * @property string $endPlan
 * @property string|null $endReal
 * @property int $unitsPlan
 * @property int $unitsReal
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TrainerDay[] $trainer
 * @property-read int|null $trainer_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CourseDay newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseDay newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseDay query()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseDay whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseDay whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseDay whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseDay whereEndPlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseDay whereEndReal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseDay whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseDay whereStartPlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseDay whereStartReal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseDay whereUnitsPlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseDay whereUnitsReal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseDay whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CourseDay extends Model
{
    use HasFactory;

    public function trainer(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TrainerDay::class, 'course_day_id');
    }

//    protected $casts = [
//        'startPlan' => 'datetime:Y-m-d H:i',
//        'endPlan' => 'datetime:Y-m-d H:i',
//    ];
}
