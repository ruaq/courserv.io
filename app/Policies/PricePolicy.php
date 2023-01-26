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

use App\Models\Price;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PricePolicy
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
        if (! $user->isAbleTo('price.*')) {
            foreach ($user->teams()->pluck('id') as $team_id) {
                if ($user->isAbleTo('price.*', $team_id)) {
                    return true;
                }
            }

            return false;
        }

        return $user->isAbleTo('price.*');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        if (! $user->isAbleTo('price.create')) {
            foreach ($user->teams()->pluck('id') as $team_id) {
                if ($user->isAbleTo('price.create', $team_id)) {
                    return true;
                }
            }

            return false;
        }

        return $user->isAbleTo('price.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Price  $price
     * @return bool
     */
    public function update(User $user, Price $price): bool
    {
        if (! $user->isAbleTo('price.update')) {
            foreach ($user->teams()->pluck('id') as $price) {
                if ($user->isAbleTo('price.update', $price)) {
                    return true;
                }
            }

            return false;
        }

        return $user->isAbleTo('price.update');
    }

    /**
     * Determine whether the user can create or update a model.
     *
     * @param  User  $user
     * @param  Price  $price
     * @return bool
     */
    public function save(User $user, Price $price)
    {
        if ($user->can('create', $price) || $user->can('update', $price)) {
            return true;
        }

        return false;
    }
}
