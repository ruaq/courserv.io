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

use App\Models\CourseType;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CourseTypePolicy
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
        return $user->isAbleTo('courseType.*');
    }

//    /**
//     * Determine whether the user can view the model.
//     *
//     * @param  \App\Models\User  $user
//     * @param  \App\Models\CourseType  $courseType
//     * @return \Illuminate\Auth\Access\Response|bool
//     */
//    public function view(User $user, CourseType $courseType)
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
        if ($user->isAbleTo('courseType.create')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CourseType  $courseType
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, CourseType $courseType)
    {
        if ($user->isAbleTo('courseType.update')) {
            return true;
        }

        return false;
    }

//    /**
//     * Determine whether the user can delete the model.
//     *
//     * @param  \App\Models\User  $user
//     * @param  \App\Models\CourseType  $courseType
//     * @return \Illuminate\Auth\Access\Response|bool
//     */
//    public function delete(User $user, CourseType $courseType)
//    {
//        //
//    }
//
//    /**
//     * Determine whether the user can restore the model.
//     *
//     * @param  \App\Models\User  $user
//     * @param  \App\Models\CourseType  $courseType
//     * @return \Illuminate\Auth\Access\Response|bool
//     */
//    public function restore(User $user, CourseType $courseType)
//    {
//        //
//    }
//
//    /**
//     * Determine whether the user can permanently delete the model.
//     *
//     * @param  \App\Models\User  $user
//     * @param  \App\Models\CourseType  $courseType
//     * @return \Illuminate\Auth\Access\Response|bool
//     */
//    public function forceDelete(User $user, CourseType $courseType)
//    {
//        //
//    }
}
