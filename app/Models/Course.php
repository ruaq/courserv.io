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
 * App\Models\Course
 *
 * @property int $id
 * @property int $course_type_id
 * @property int|null $team_id
 * @property string|null $internal_number
 * @property string|null $registration_number
 * @property string $seminar_location
 * @property string $street
 * @property string $zipcode
 * @property string $location
 * @property \Carbon\Carbon $start
 * @property \Carbon\Carbon $end
 * @property mixed|null $cancelled
 * @property int $seats
 * @property int|null $public_bookable
 * @property string|null $bag
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CourseDay[] $days
 * @property-read int|null $days_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Participant[] $participants
 * @property-read int|null $participants_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Price[] $prices
 * @property-read int|null $prices_count
 * @property-read \App\Models\Team|null $team
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TrainerDay[] $trainer
 * @property-read int|null $trainer_count
 * @property-read \App\Models\CourseType $type
 *
 * @method static \Database\Factories\CourseFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Course newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Course newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Course query()
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereBag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereCancelled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereCourseTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereInternalNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course wherePublicBookable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereSeats($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereSeminarLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereZipcode($value)
 * @mixin \Eloquent
 */
class Course extends Model
{
    use HasFactory;

    protected $casts = [
        'start' => 'datetime:d.m.Y H:i',
        'end' => 'datetime:d.m.Y H:i',
    ];

    public function type(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CourseType::class, 'course_type_id');
    }

    public function team(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function prices(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Price::class);
    }

    public function participants(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Participant::class);
    }

    public function days(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CourseDay::class, 'course_id');
    }

    public function trainer(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TrainerDay::class, 'course_id');
    }

//    static public function getFreeSeats(Course $course): int
//    {
//        $participants = Participant::whereCourseId( $course->id)->where('cancelled', '=', 0)->count();
//
//        return intval($course->seats) - $participants;
//    }
//
//    static public function getFreePercent(Course $course): int
//    {
//        $participants = Participant::whereCourseId( $course->id)->where('cancelled', '=', 0)->count();
//        $freeSeats = intval($course->seats) - $participants;
//
//        return $freeSeats / intval($course->seats) * 100;
//    }
}
