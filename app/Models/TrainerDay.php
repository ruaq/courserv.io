<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TrainerDay
 *
 * @property int $user_id
 * @property int $course_id
 * @property string|null $date
 * @property int $confirmed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TrainerDay newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TrainerDay newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TrainerDay query()
 * @method static \Illuminate\Database\Eloquent\Builder|TrainerDay whereConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainerDay whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainerDay whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainerDay whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainerDay whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainerDay whereUserId($value)

 * @property int $bookable
 * @property int $count
 * @method static \Illuminate\Database\Eloquent\Builder|TrainerDay whereBookable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainerDay whereCount($value)
 */
class TrainerDay extends Model
{
    use HasFactory;
}
