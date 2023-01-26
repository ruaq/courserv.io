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

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
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
        if (! $user->isAbleTo('team.*')) {
            foreach ($user->teams()->pluck('id') as $team_id) {
                if ($user->isAbleTo('team.*', $team_id)) {
                    return true;
                }
            }

            return false;
        }

        return $user->isAbleTo('team.*');
    }

    /**
     * Determine whether the user can view every models.
     *
     * @param  User  $user
     * @return bool
     */
    public function viewEvery(User $user): bool
    {
        return $user->isAbleTo('team.view');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  Team  $team
     * @return \Illuminate\Auth\Access\Response|bool
     */
//    public function view(User $user, Team $team)
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
        return $user->isAbleTo('team.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Team  $team
     * @return bool
     */
    public function update(User $user, Team $team): bool
    {
        if ($user->isAbleTo('team.update') || $user->isAbleTo('team.update', $team)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Team  $team
     * @return \Illuminate\Auth\Access\Response|bool
     */
//    public function delete(User $user, Team $team)
//    {
//        //
//    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User  $user
     * @param  Team  $team
     * @return \Illuminate\Auth\Access\Response|bool
     */
//    public function restore(User $user, Team $team)
//    {
//        //
//    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User  $user
     * @param  Team  $team
     * @return \Illuminate\Auth\Access\Response|bool
     */
//    public function forceDelete(User $user, Team $team)
//    {
//        //
//    }
}
