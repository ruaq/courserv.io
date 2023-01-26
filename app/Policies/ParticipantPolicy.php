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

use App\Models\Participant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ParticipantPolicy
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
        if (! $user->isAbleTo('participant.*')) {
            foreach ($user->teams()->pluck('id') as $team_id) {
                if ($user->isAbleTo('participant.*', $team_id)) {
                    return true;
                }
            }

            return false;
        }

        return $user->isAbleTo('participant.*');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  Participant  $participant
     * @return Response|bool
     */
    public function view(User $user, Participant $participant): Response|bool
    {
        if (! $user->isAbleTo('participant.view', (string) $participant->team_id)) {
            return $user->isAbleTo('participant.view');
        }

        return $user->isAbleTo('participant.view', (string) $participant->team_id);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        if (! $user->isAbleTo('participant.create')) {
            foreach ($user->teams()->pluck('id') as $team_id) {
                if ($user->isAbleTo('participant.create', $team_id)) {
                    return true;
                }
            }

            return false;
        }

        return $user->isAbleTo('participant.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Participant  $participant
     * @return bool
     */
    public function update(User $user, Participant $participant): bool
    {
        // cache the course id for listing course participants... preventing n+1
        return cache()->remember("user-can-update-participant-{$user->id}-{$participant->course_id}", 60, function () use ($user, $participant) {
            if (! $user->isAbleTo('participant.update', (string) $participant->team_id)) {
                if (
                    in_array($user->id, $participant->course->trainer->pluck('user_id')->toArray()) // user is trainer
                    && $participant->course->start < Carbon::now()->addWeek()
                    && $participant->course->end > Carbon::now()->subWeek()
                ) {
                    return true;
                }

                return $user->isAbleTo('participant.update');
            }

            return $user->isAbleTo('participant.update', (string) $participant->team_id);
        });
    }

//    /**
//     * Determine whether the user can delete the model.
//     *
//     * @param User $user
//     * @param Participant $participant
//     * @return \Illuminate\Auth\Access\Response|bool
//     */
//    public function delete(User $user, Participant $participant)
//    {
//        //
//    }
//
//    /**
//     * Determine whether the user can restore the model.
//     *
//     * @param User $user
//     * @param Participant $participant
//     * @return \Illuminate\Auth\Access\Response|bool
//     */
//    public function restore(User $user, Participant $participant)
//    {
//        //
//    }
//
//    /**
//     * Determine whether the user can permanently delete the model.
//     *
//     * @param User $user
//     * @param Participant $participant
//     * @return \Illuminate\Auth\Access\Response|bool
//     */
//    public function forceDelete(User $user, Participant $participant)
//    {
//        //
//    }
}
