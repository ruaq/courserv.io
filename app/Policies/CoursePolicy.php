<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
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

//    /**
//     * Determine whether the user can view the model.
//     *
//     * @param  \App\Models\User  $user
//     * @param  \App\Models\Course  $course
//     * @return \Illuminate\Auth\Access\Response|bool
//     */
//    public function view(User $user, Course $course)
//    {
//        //
//    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
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
     * @param  \App\Models\User  $user
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Course $course)
    {
        if (! $user->isAbleTo('course.update')) {
            foreach ($user->teams()->pluck('id') as $course) {
                if ($user->isAbleTo('course.update', $course)) {
                    return true;
                }
            }
            return false;
        }

        return $user->isAbleTo('course.update');
    }

    /**
     * Determine whether the user can create or update a model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Course $course
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function save(User $user, Course $course)
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
