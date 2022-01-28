<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Course
 *
 * @property int $id
 * @property int $course_type_id
 * @property int $team_id
 * @property string $internal_number
 * @property string|null $registration_number
 * @property int $registered
 * @property string $seminar_location
 * @property string $street
 * @property string $zipcode
 * @property string $location
 * @property \Carbon\Carbon $start
 * @property \Carbon\Carbon $end
 * @property int $responsible
 * @property string $seats
 * @property int $bookable
 * @property int|null $running
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Team $team
 * @property-read \App\Models\CourseType $type
 * @method static \Database\Factories\CourseFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Course newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Course newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Course query()
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereBookable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereCourseTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereInternalNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereRegistered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereResponsible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereRunning($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereSeats($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereSeminarLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereZipcode($value)
 * @mixin \Eloquent
 * @property string|null $cancelled
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereCancelled($value)
 * @property-read \App\Models\CourseDay|null $days
 * @property-read int|null $days_count
 */
class Course extends Model
{
    use HasFactory;

    protected $casts = [
        'start' => 'datetime:d.m.Y H:i',
        'end' => 'datetime:d.m.Y H:i',
    ];

    public function type()
    {
        return $this->belongsTo(CourseType::class, 'course_type_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function days()
    {
        return $this->hasMany(CourseDay::class, 'course_id');
    }
}
