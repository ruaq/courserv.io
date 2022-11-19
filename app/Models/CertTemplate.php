<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CertTemplate
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $registration_required
 * @property string $extension
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Course[] $courses
 * @property-read int|null $courses_count
 * @method static \Illuminate\Database\Eloquent\Builder|CertTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CertTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CertTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|CertTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertTemplate whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertTemplate whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertTemplate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertTemplate whereRegistrationRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertTemplate whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CourseType[] $courseTypes
 * @property-read int|null $course_types_count
 * @property string $title
 * @property int $background
 * @property string $filename
 * @method static \Illuminate\Database\Eloquent\Builder|CertTemplate whereBackground($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertTemplate whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertTemplate whereTitle($value)
 */
class CertTemplate extends Model
{
    use HasFactory;

    public function courseTypes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(CourseType::class);
    }
}
