<?php

namespace App\Http\Livewire;

use App\Models\Team;
use App\Models\User as UserModel;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Innoge\LaravelPolicySoftCache\LaravelPolicySoftCache;
use Livewire\Component;

class User extends Component
{
    use AuthorizesRequests;

    public bool $showEditModal = false;

    public Collection $users;

    public UserModel $editing;

    public Collection $teams;

    public Collection $roles;

    public array $teamIds = [];

    public array $roleIds = [];

    public array $teamRoleIds = [];

    // removed spoof from email validation (update issue) TODO check later
    protected function rules(): array
    {
        return [
            'editing.name' => 'required',
            'editing.email' => 'required|email:rfc|unique:users,email,'.$this->editing->id,
            'editing.active' => 'bool|nullable',
        ];
    }

    public function mount()
    {
        if (! Auth::check()) {
            return $this->redirect(route('login'));
        }

        $this->editing = $this->makeBlankUser();
        $this->teams = Team::all();
        $this->roles = \App\Models\Role::all();
    }

    /**
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', self::class);

        if ($this->editing->getKey()) {
            $this->editing = $this->makeBlankUser();
            $this->teamIds = [];
            $this->roleIds = [];
            $this->teamRoleIds = [];
        }

        $this->showEditModal = true;
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(UserModel $user)
    {
        $this->authorize('update', $user);

        if ($this->editing->isNot($user)) {
            $this->editing = $user;

            $this->teamIds = [];
            foreach ($this->editing->teams->pluck('id') as $team) {
                $this->teamIds[] = (string) $team;
            }

            $this->roleIds = [];
            $this->teamRoleIds = [];
            foreach ($this->editing->roles as $role) {
                if (isset($role->pivot->team_id)) { // it's a team specific role
                    $this->teamRoleIds[$role->pivot->team_id] = $role->id;
                } else { // global role
                    $this->roleIds[] = (string) $role->id;
                }
            }
        }
        $this->showEditModal = true;
    }

    /**
     * @throws AuthorizationException
     */
    public function active(UserModel $user)
    {
        $this->authorize('update', $user);

        $this->editing = $user;

        $this->editing->active ? $this->editing->active = 0 : $this->editing->active = 1;

        // prevent deactivating yourself...
        if ($this->editing->id === auth()->id()) {
            $this->editing->active = 1;
        }

        $this->validate();
        $this->editing->save();
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
     * @throws BindingResolutionException
     */
    public function save()
    {
        $this->authorize('update', $this->editing);

        $this->validate();
        $this->editing->save();

        $this->editing->teams()->sync($this->teamIds);
        $this->editing->syncRoles($this->roleIds);

        // remove roles if user isn’t member of the team anymore
        foreach ($this->teamRoleIds as $key => $value) {
            if (! in_array($key, $this->teamIds)) {
                $this->editing->syncRoles([], $key);
            }
        }

        // sync the roles for the teams
        foreach ($this->teamIds as $team) {
            if (! isset($this->teamRoleIds[$team]) || $this->teamRoleIds[$team] == '') {
                $this->teamRoleIds[$team] = []; // remove if no role is selected
            }
            $this->editing->syncRoles((array) $this->teamRoleIds[$team], $team);
        }

        LaravelPolicySoftCache::flushCache();

        $this->showEditModal = false;
    }

    /**
     * @throws AuthorizationException
     */
    public function render()
    {
        $this->authorize('viewAny', self::class);

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
                'breadcrumb_back' => ['link' => route('user'), 'text' => _i('User')],
                'breadcrumbs' => [['link' => route('user'), 'text' => _i('User')]],
            ]);
    }

    protected function makeBlankUser(): UserModel
    {
        return new UserModel([
            'active' => 1,
        ]);
    }
}
