<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UpdatedCourse
 *
 * @property int $id
 * @property int $course_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UpdatedCourse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UpdatedCourse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UpdatedCourse query()
 * @method static \Illuminate\Database\Eloquent\Builder|UpdatedCourse whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UpdatedCourse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UpdatedCourse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UpdatedCourse whereUpdatedAt($value)
 */
class UpdatedCourse extends Model
{
    use HasFactory;
}
