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
