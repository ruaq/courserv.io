<?php

namespace App\Http\Livewire;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\User as UserModel;
use App\Models\Team;

class User extends Component
{
    use AuthorizesRequests;

    public bool $showEditModal = false;
    public Collection $users;
    public UserModel $editing;

    protected function rules(): array
    {
        return [
            'editing.name' => 'required',
            'editing.email' => 'required|email:rfc,spoof|unique:users,email,' . optional($this->editing)->id,
            'editing.active' => 'bool|nullable',
        ];
    }

    public function mount()
    {
        $this->editing = $this->makeBlankUser();
    }

    public function create()
    {
        $this->authorize('create', User::class);

        if ($this->editing->getKey()) {
            $this->editing = $this->makeBlankUser();
        }

        $this->showEditModal = true;
    }

    public function edit(UserModel $user)
    {
        $this->authorize('update', $user);

        if ($this->editing->isNot($user)) {
            $this->editing = $user;
        }
        $this->showEditModal = true;
    }

    public function active(UserModel $user)
    {
        $this->authorize('update', $user);

        $this->editing = $user;

        $this->editing->active ? $this->editing->active = 0 : $this->editing->active = 1;

        $this->validate();
        $this->editing->save();

    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->authorize('update', $this->editing);

        $this->validate();
        $this->editing->save();
        $this->showEditModal = false;
    }

    public function render()
    {
        $this->authorize('viewAny', User::class);

        if (Auth::user()->isAbleTo('user.view')) {
            $this->users = UserModel::all();
        } else {
            $user_teams = Auth::user()->teams()->pluck('id');

            $auth_teams = [];
            $user_ids = [];

            // get all authorized teams
            foreach ($user_teams as $team) {
                if (Auth::user()->isAbleTo('user.*', $team)) {
                     $auth_teams[] = $team;
                }
            }

            // TODO check if there is a more elegant way...?!

            // Find the team users
            $teams = Team::with('users')->find($auth_teams);

            // get their ids
            foreach ($teams as $team) {
                $user_ids = array_merge($user_ids, $team->users->pluck('id')->toArray());
            }

            // and get their data
            $this->users = UserModel::whereIn('id', $user_ids)->get();
        }

        return view('livewire.user')
            ->layout('layouts.app', [
                'metaTitle' => _i('User'),
                'active' => 'user',
            ]);
    }

    protected function makeBlankUser(): UserModel
    {
        return new UserModel([
            'active' => 1
        ]);
    }
}
