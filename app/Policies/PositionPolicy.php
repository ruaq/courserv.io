<?php

namespace App\Policies;

use App\Models\Position;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PositionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return Response|bool
     */
    public function viewAny(User $user): Response|bool
    {
        if (! $user->isAbleTo('position.*')) {
            foreach ($user->teams()->pluck('id') as $team_id) {
                if ($user->isAbleTo('position.*', $team_id)) {
                    return true;
                }
            }

            return false;
        }

        return $user->isAbleTo('position.*');
    }

//    /**
//     * Determine whether the user can view the model.
//     *
//     * @param User $user
//     * @param Position $position
//     * @return Response|bool
//     */
//    public function view(User $user, Position $position)
//    {
//        //
//    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        if (! $user->isAbleTo('position.create')) {
            foreach ($user->teams()->pluck('id') as $team_id) {
                if ($user->isAbleTo('position.create', $team_id)) {
                    return true;
                }
            }

            return false;
        }

        return $user->isAbleTo('position.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Position  $position
     * @return Response|bool
     */
    public function update(User $user, Position $position): Response|bool
    {
        if ($position->team_id && $user->isAbleTo('position.update', (string) $position->team_id)) {
            return $user->isAbleTo('position.update', (string) $position->team_id);
        }

        return $user->isAbleTo('position.update');
    }

    /**
     * Determine whether the user can create or update a model.
     *
     * @param  User  $user
     * @param  Position  $position
     * @return Response|bool
     */
    public function save(User $user, Position $position): Response|bool
    {
        if ($position->exists) {
            if (
                $user->isAbleTo('position.update', $position->getOriginal('team_id'))
                && $user->isAbleTo('position.update', $position->getAttribute('team_id'))
                || $user->isAbleTo('position.update')
            ) {
                return true;
            }

            return false;
        }

        if (
            $user->isAbleTo('position.create')
            || $user->isAbleTo('position.create', (string) $position->team_id)
        ) {
            return true;
        }

        return false;
    }

//    /**
//     * Determine whether the user can delete the model.
//     *
//     * @param User $user
//     * @param Position $position
//     * @return Response|bool
//     */
//    public function delete(User $user, Position $position)
//    {
//        //
//    }

//    /**
//     * Determine whether the user can restore the model.
//     *
//     * @param User $user
//     * @param Position $position
//     * @return Response|bool
//     */
//    public function restore(User $user, Position $position)
//    {
//        //
//    }

//    /**
//     * Determine whether the user can permanently delete the model.
//     *
//     * @param User $user
//     * @param Position $position
//     * @return Response|bool
//     */
//    public function forceDelete(User $user, Position $position)
//    {
//        //
//    }
}
