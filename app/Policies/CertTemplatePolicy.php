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

use App\Models\CertTemplate;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CertTemplatePolicy
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
        if (! $user->isAbleTo('certTemplate.*')) {
            foreach ($user->teams()->pluck('id') as $team_id) {
                if ($user->isAbleTo('certTemplate.*', $team_id)) {
                    return true;
                }
            }

            return false;
        }

        return $user->isAbleTo('certTemplate.*');
    }

//    /**
//     * Determine whether the user can view the model.
//     *
//     * @param User $user
//     * @param CertTemplate $certTemplate
//     * @return Response|bool
//     */
//    public function view(User $user, CertTemplate $certTemplate)
//    {
//        //
//    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return Response|bool
     */
    public function create(User $user): Response|bool
    {
        if (! $user->isAbleTo('certTemplate.create')) {
            foreach ($user->teams()->pluck('id') as $team_id) {
                if ($user->isAbleTo('certTemplate.create', $team_id)) {
                    return true;
                }
            }

            return false;
        }

        return $user->isAbleTo('certTemplate.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  CertTemplate  $certTemplate
     * @return bool
     */
    public function update(User $user, CertTemplate $certTemplate): bool
    {
        if (! $user->isAbleTo('certTemplate.update')) {
            foreach ($user->teams()->pluck('id') as $course) {
                if ($user->isAbleTo('certTemplate.update', $course)) {
                    return true;
                }
            }

            return false;
        }

        return $user->isAbleTo('certTemplate.update');
    }

    /**
     * Determine whether the user can create or update a model.
     *
     * @param  User  $user
     * @param  CertTemplate  $certTemplate
     * @return bool
     */
    public function save(User $user, CertTemplate $certTemplate): bool
    {
        if ($user->can('create', $certTemplate) || $user->can('update', $certTemplate)) {
            return true;
        }

        return false;
    }

//    /**
//     * Determine whether the user can delete the model.
//     *
//     * @param User $user
//     * @param CertTemplate $certTemplate
//     * @return Response|bool
//     */
//    public function delete(User $user, CertTemplate $certTemplate)
//    {
//        //
//    }
//
//    /**
//     * Determine whether the user can restore the model.
//     *
//     * @param User $user
//     * @param CertTemplate $certTemplate
//     * @return Response|bool
//     */
//    public function restore(User $user, CertTemplate $certTemplate)
//    {
//        //
//    }
//
//    /**
//     * Determine whether the user can permanently delete the model.
//     *
//     * @param User $user
//     * @param CertTemplate $certTemplate
//     * @return Response|bool
//     */
//    public function forceDelete(User $user, CertTemplate $certTemplate)
//    {
//        //
//    }
}
