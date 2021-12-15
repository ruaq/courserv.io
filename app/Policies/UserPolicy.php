<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
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
        if (! $user->isAbleTo('user.*')) {
            foreach ($user->teams()->pluck('id') as $team_id) {
                if ($user->isAbleTo('user.*', $team_id)) {
                    return true;
                }
            }

            return false;
        }

        return $user->isAbleTo('user.*');
    }

//    /**
//     * Determine whether the user can view the model.
//     *
//     * @param  \App\Models\User  $user
//     * @param  \App\Models\User  $model
//     * @return \Illuminate\Auth\Access\Response|bool
//     */
//    public function view(User $user, User $model)
//    {
//        //
//    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user)
    {
        if ($user->isAbleTo('user.create')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param User $model
     * @return Response|bool
     */
    public function update(User $user, User $model)
    {
        if ($user->isAbleTo('user.update')) {
            return true;
        }

        foreach ($model->teams as $team) {
            if ($user->isAbleTo('user.update', $team)) {
                return true;
            }
        }

        return false;
    }

//    /**
//     * Determine whether the user can delete the model.
//     *
//     * @param  \App\Models\User  $user
//     * @param  \App\Models\User  $model
//     * @return \Illuminate\Auth\Access\Response|bool
//     */
//    public function delete(User $user, User $model)
//    {
//        //
//    }
//
//    /**
//     * Determine whether the user can restore the model.
//     *
//     * @param  \App\Models\User  $user
//     * @param  \App\Models\User  $model
//     * @return \Illuminate\Auth\Access\Response|bool
//     */
//    public function restore(User $user, User $model)
//    {
//        //
//    }
//
//    /**
//     * Determine whether the user can permanently delete the model.
//     *
//     * @param  \App\Models\User  $user
//     * @param  \App\Models\User  $model
//     * @return \Illuminate\Auth\Access\Response|bool
//     */
//    public function forceDelete(User $user, User $model)
//    {
//        //
//    }
}
