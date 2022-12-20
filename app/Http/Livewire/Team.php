<?php

namespace App\Http\Livewire;

use App\Models\Team as TeamModel;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Team extends Component
{
    use AuthorizesRequests;

    public bool $showEditModal = false;

    public Collection $teams;

    public TeamModel $editing;

    protected function rules(): array
    {
        return [
            'editing.name' => 'required|unique:teams,name,' . $this->editing->id,
            'editing.display_name' => 'required|unique:teams,display_name,' . $this->editing->id,
            'editing.description' => 'nullable',
        ];
    }

    public function mount()
    {
        if (! Auth::check()) {
            return $this->redirect(route('login'));
        }

        $this->editing = $this->makeBlankTeam();
    }

    /**
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', TeamModel::class);

        if ($this->editing->getKey()) {
            $this->editing = $this->makeBlankTeam();
        }
        $this->showEditModal = true;
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(TeamModel $team)
    {
        $this->authorize('update', $team);

        if ($this->editing->isNot($team)) {
            $this->editing = $team;
        }
        $this->showEditModal = true;
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
    public function save()
    {
        $this->authorize('update', $this->editing);

        $this->validate();
        $this->editing->save();
        $this->showEditModal = false;
    }

    /**
     * @throws AuthorizationException
     */
    public function render()
    {
        $this->authorize('viewAny', TeamModel::class);

        if (Auth::user()->isAbleTo('team.view')) {
            $this->teams = TeamModel::all();
        } else {
            $id = Auth::user()->teams()->pluck('id');

            $this->teams = TeamModel::whereIn('id', $id)->get();
        }

        return view('livewire.team')
            ->layout('layouts.app', [
                'metaTitle' => _i('Teams'),
                'active' => 'teams',
                'breadcrumb_back' => ['link' => route('teams'), 'text' => _i('Teams')],
                'breadcrumbs' => [['link' => route('teams'), 'text' => _i('Teams')]],
            ]);
    }

    protected function makeBlankTeam(): TeamModel
    {
        return new TeamModel();
    }

    protected function prepareForValidation($attributes): array
    {
        $attributes['editing']['name'] = Str::slug($this->editing->name, '-');

        return $attributes;
    }
}
