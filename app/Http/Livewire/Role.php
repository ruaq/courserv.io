<?php

namespace App\Http\Livewire;

use App\Models\Permission;
use App\Models\Role as RoleModel;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Innoge\LaravelPolicySoftCache\LaravelPolicySoftCache;
use Livewire\Component;

class Role extends Component
{
    use AuthorizesRequests;

    public bool $showEditModal = false;

    public Collection $roles;

    public Collection $permissions;

    public RoleModel $editing;

    public array $permIds = [];

    protected function rules(): array
    {
        return [
            'editing.name' => 'required|unique:roles,name,'.$this->editing->id,
            'editing.display_name' => 'required|unique:roles,display_name,'.$this->editing->id,
            'editing.description' => 'nullable',
        ];
    }

    public function mount()
    {
        if (! Auth::check()) {
            return $this->redirect(route('login'));
        }

        $this->editing = $this->makeBlankModel();
        $this->permissions = Permission::all();
    }

    /**
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', RoleModel::class);

        if ($this->editing->getKey()) {
            $this->editing = $this->makeBlankModel();
            $this->permIds = [];
        }
        $this->showEditModal = true;
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(RoleModel $role)
    {
        $this->authorize('update', $role);

        if ($this->editing->isNot($role)) {
            $this->editing = $role;

            $this->permIds = [];
            foreach ($this->editing->permissions->pluck('id') as $perm) {
                $this->permIds[] = (string) $perm;
            }
        }
        $this->showEditModal = true;
    }

    /**
     * @throws AuthorizationException
     * @throws BindingResolutionException
     */
    public function save()
    {
        $this->authorize('viewAny', RoleModel::class);

        $this->validate();

        $this->editing->save();
        $this->editing->syncPermissions($this->permIds);

        LaravelPolicySoftCache::flushCache();

        $this->showEditModal = false;
    }

    public function render()
    {
        $this->authorize('viewAny', RoleModel::class);

        $this->roles = RoleModel::all();

        return view('livewire.role')
            ->layout('layouts.app', [
                'metaTitle' => _i('Roles'),
                'active' => 'roles',
                'breadcrumb_back' => ['link' => route('roles'), 'text' => _i('Roles')],
                'breadcrumbs' => [['link' => route('roles'), 'text' => _i('Roles')]],
            ]);
    }

    protected function makeBlankModel(): RoleModel
    {
        return new RoleModel();
    }
}
