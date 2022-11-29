<?php

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

        $this->authorize('viewAny', $participant);

        $this->part = $participant;

        return view('livewire.participant-details')
            ->layout('layouts.app', [
                'metaTitle' => _i('participants'),
                'active' => 'participants',
            ]);
    }
}
