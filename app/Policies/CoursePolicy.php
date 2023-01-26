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

namespace App\Policies;

use App\Models\Course;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CoursePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        if (! $user->isAbleTo('course.*')) {
            foreach ($user->teams()->pluck('id') as $team_id) {
                if ($user->isAbleTo('course.*', $team_id)) {
                    return true;
                }
            }

            return false;
        }

        return $user->isAbleTo('course.*');
    }

    /**
     * Determine whether the user can view participants.
     *
     * @param  User  $user
     * @param  Course  $course
     * @return bool
     */
    public function viewParticipants(User $user, Course $course): bool
    {
        if (! $user->isAbleTo('participant.view', (string) $course->team_id)) {
            if (
                in_array($user->id, $course->trainer->pluck('user_id')->toArray()) // user is trainer
                && $course->start < Carbon::now()->addWeek()
                && $course->end > Carbon::now()->subWeek()
            ) {
                return true;
            }

            return $user->isAbleTo('participant.view');
        }

        return $user->isAbleTo('participant.view', (string) $course->team_id);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        if (! $user->isAbleTo('course.create')) {
            foreach ($user->teams()->pluck('id') as $team_id) {
                if ($user->isAbleTo('course.create', $team_id)) {
                    return true;
                }
            }

            return false;
        }

        return $user->isAbleTo('course.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Course  $course
     * @return Response|bool
     */
    public function update(User $user, Course $course): Response|bool
    {
        if ($course->team_id && $user->isAbleTo('course.update', (string) $course->team_id)) {
            return $user->isAbleTo('course.update', (string) $course->team_id);
        }

        return $user->isAbleTo('course.update');
    }

    /**
     * Determine whether the user can create or update a model.
     *
     * @param  User  $user
     * @param  Course  $course
     * @return Response|bool
     */
    public function save(User $user, Course $course): Response|bool
    {
        if ($course->exists) {
            if (
                $user->isAbleTo('course.update', $course->getOriginal('team_id'))
                && $user->isAbleTo('course.update', $course->getAttribute('team_id'))
                || $user->isAbleTo('course.update')
            ) {
                return true;
            }

            return false;
        }

        if (
            $user->isAbleTo('course.create')
            || $user->isAbleTo('course.create', (string) $course->team_id)
        ) {
            return true;
        }

        return false;
    }

//    /**
//     * Determine whether the user can delete the model.
//     *
//     * @param  \App\Models\User  $user
//     * @param  \App\Models\Course  $course
//     * @return \Illuminate\Auth\Access\Response|bool
//     */
//    public function delete(User $user, Course $course)
//    {
//        //
//    }
//
//    /**
//     * Determine whether the user can restore the model.
//     *
//     * @param  \App\Models\User  $user
//     * @param  \App\Models\Course  $course
//     * @return \Illuminate\Auth\Access\Response|bool
//     */
//    public function restore(User $user, Course $course)
//    {
//        //
//    }
//
//    /**
//     * Determine whether the user can permanently delete the model.
//     *
//     * @param  \App\Models\User  $user
//     * @param  \App\Models\Course  $course
//     * @return \Illuminate\Auth\Access\Response|bool
//     */
//    public function forceDelete(User $user, Course $course)
//    {
//        //
//    }
}
