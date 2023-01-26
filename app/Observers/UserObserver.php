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

namespace App\Observers;

use App\Events\UserCreated;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        event(new UserCreated($user));
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

//    /**
//     * Handle the User "deleted" event.
//     *
//     * @param  \App\Models\User  $user
//     * @return void
//     */
//    public function deleted(User $user)
//    {
//        //
//    }
//
//    /**
//     * Handle the User "restored" event.
//     *
//     * @param  \App\Models\User  $user
//     * @return void
//     */
//    public function restored(User $user)
//    {
//        //
//    }
//
//    /**
//     * Handle the User "force deleted" event.
//     *
//     * @param  \App\Models\User  $user
//     * @return void
//     */
//    public function forceDeleted(User $user)
//    {
//        //
//    }
}
