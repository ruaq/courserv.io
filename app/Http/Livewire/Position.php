<?php

namespace App\Http\Livewire;

use App\Models\Position as PositionModel;
use App\Models\Team as TeamModel;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Position extends Component
{
    use AuthorizesRequests;

    public bool $showEditModal = false;

    public PositionModel $editing;

    public Collection $positions;

    protected function rules(): array
    {
        return [
            'editing.title' => 'required|unique:positions,title,'.$this->editing->id,
            'editing.leading' => 'sometimes',
            'editing.team_id' => 'required|int|nullable',
            'editing.description' => 'nullable',
        ];
    }

    public function mount()
    {
        if (! Auth::check()) {
            return $this->redirect(route('login'));
        }

        $this->editing = $this->makeBlankPosition();
    }

    /**
     * @throws ValidationException
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /**
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', PositionModel::class);

        if ($this->editing->getKey()) {
            $this->editing = $this->makeBlankPosition();
        }

        $this->showEditModal = true;
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(PositionModel $position)
    {
        $this->authorize('update', $position);

        if ($this->editing->isNot($position)) {
            $this->editing = $position;
        }

        if (is_null($this->editing->team_id)) {
            $this->editing->team_id = 0;
        }

        $this->showEditModal = true;
    }

    /**
     * @throws AuthorizationException
     */
    public function save()
    {
        $this->validate();

        if ($this->editing->team_id == 0) {
            $this->editing->team_id = null;
        }

        $this->authorize('save', $this->editing);

        $this->editing->save();
        $this->showEditModal = false;
    }

    public function render()
    {
        $team_ids = [];

        if (Auth::user()->isAbleTo('position.*')) {
            $this->positions = PositionModel::query()
                ->with('team')
                ->get();
        } else {
            $team_ids = authorizedTeams('position.*');

            $this->positions = PositionModel::whereIn('team_id', $team_ids)
                ->orWhere('team_id', null)
                ->get();
        }

        $teams = TeamModel::query()
            ->when(
                count($team_ids), // can't see all courses
                fn ($query, $user_teams) => $query->whereIn('id', $team_ids)
            )
            ->get();

        return view('livewire.position', [
            'teams' => $teams,
        ])
            ->layout('layouts.app', [
                'metaTitle' => _i('Positions'),
                'active' => 'positions',
                'breadcrumb_back' => ['link' => route('positions'), 'text' => _i('Positions')],
                'breadcrumbs' => [['link' => route('positions'), 'text' => _i('Positions')]],
            ]);
    }

    protected function makeBlankPosition(): PositionModel
    {
        return new PositionModel(['team_id' => 0]);
    }
}
