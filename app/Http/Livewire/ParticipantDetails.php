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

namespace App\Http\Livewire;

use App\Models\Participant;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

class ParticipantDetails extends Component
{
    use AuthorizesRequests;

    public string $participant;

    public Participant $part;

    public function mount()
    {
        if (! Auth::check()) {
            return $this->redirect(route('login'));
        }
    }

    public function pay()
    {
        $this->authorize('update', $this->part);

        $this->part->payed ? $this->part->payed = 0 : $this->part->payed = 1;

        $this->part->save();
    }

    public function render()
    {
        $participant = Participant::whereId(Hashids::decode($this->participant))
            ->with('course')
            ->first();

        $this->authorize('view', $participant);

        $this->part = $participant;

        return view('livewire.participant-details')
            ->layout('layouts.app', [
                'metaTitle' => _i('participants'),
                'active' => 'participants',
                'breadcrumb_back' => [
                    'link' => route(
                        'participant.course',
                        [
                            'course' => Hashids::encode($participant->course->id),
                        ]
                    ),
                    'text' => _i('participants'),
                ],
                'breadcrumbs' => [
                    [
                        'link' => route('course'),
                        'text' => _i('Courses'),
                    ],
                    [
                        'link' => route('course'),
                        'text' => $participant->course->internal_number,
                    ],
                    [
                        'link' => route(
                            'participant.course',
                            [
                                'course' => Hashids::encode($participant->course->id),
                            ]
                        ),
                        'text' => _i('participants'),
                    ],
                    [
                        'link' => route(
                            'participant.details',
                            [
                                'participant' => Hashids::encode($participant->id),
                            ]
                        ),
                        'text' => $participant->firstname.' '.$participant->lastname,
                    ],
                ],
            ]);
    }
}
