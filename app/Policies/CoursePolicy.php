<?php

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
     * @param User $user
     * @return Response|bool
     */
    public function viewAny(User $user)
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
     * @param User $user
     * @param Course $course
     * @return Response|bool
     */
    public function viewParticipants(User $user, Course $course)
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
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user)
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
     * @param User $user
     * @param Course $course
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
     * @param User $user
     * @param Course $course
     * @return Response|bool
     */
    public function save(User $user, Course $course): Response|bool
    {
        if ($user->can('create', $course) || $user->can('update', $course)) {
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
