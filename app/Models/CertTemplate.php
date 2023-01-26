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
 * App\Models\CertTemplate
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property int $background
 * @property int $registration_required
 * @property string $filename
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CourseType[] $courseTypes
 * @property-read int|null $course_types_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CertTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CertTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CertTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|CertTemplate whereBackground($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertTemplate whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertTemplate whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertTemplate whereRegistrationRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertTemplate whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertTemplate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CertTemplate extends Model
{
    use HasFactory;

    public function courseTypes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(CourseType::class);
    }
}
