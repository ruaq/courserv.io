<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TrainerDay
 *
 * @property int $course_id
 * @property int|null $user_id
 * @property int|null $course_day_id
 * @property int|null $position
 * @property int $order
 * @property string|null $option
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TrainerDay newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TrainerDay newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TrainerDay query()
 * @method static \Illuminate\Database\Eloquent\Builder|TrainerDay whereCourseDayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainerDay whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainerDay whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainerDay whereOption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainerDay whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainerDay wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainerDay whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainerDay whereUserId($value)
 * @mixin \Eloquent
 */
class TrainerDay extends Model
{
    use HasFactory;
}
