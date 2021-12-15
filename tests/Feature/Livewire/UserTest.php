<?php

use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->seed(PermissionSeeder::class);

    $this->team = Team::create([
        'name' => 'example-team',
        'display_name' => 'example team',
    ]);

    $this->user = User::factory()->create();
    $this->user->teams()->attach($this->team);

    actingAs($this->user);
});

it('has a user page', function () {
    $this->user->attachRole('admin');

    $response = $this->get(route('user'));

    $response->assertStatus(200);

    $response->assertSeeLivewire('user');
});

it('shows the team members only if authorized', function () {
    $response = $this->get(route('user'));
    $response->assertForbidden();

    $this->user->attachPermission('user.view');

    $response = $this->get(route('user'));

    $response->assertStatus(200);
    $response->assertSeeLivewire('user');
});

it('shows only team member', function () {
    $user = User::factory()->create([
        'name' => 'second user',
    ]);

    $user->teams()->attach($this->team);

    // Permission for team
    $this->user->attachPermission('user.view', $this->team);

    $response = $this->get(route('user'));

    $response->assertStatus(200);
    $response->assertSee($user->name);
    $response->assertSee($this->user->name);

    $user->teams()->detach($this->team);

    $response = $this->get(route('user'));

    $response->assertStatus(200);
    $response->assertDontSee($user->name);
    $response->assertSee($this->user->name);

    // global Permission
    $this->user->attachPermission('user.view');

    $response = $this->get(route('user'));

    $response->assertStatus(200);
    $response->assertSee($user->name);
    $response->assertSee($this->user->name);
});

it('needs authorization to create a user', function () {
    $this->user->attachRole('admin');

    $this->role = Role::find(1);
    $this->role->detachPermission('user.create');

    Livewire::test('user')
        ->call('create')
        ->assertForbidden();

    $this->role->attachPermission('user.create');

    Livewire::test('user')
        ->call('create')
        ->assertSuccessful();
});

it('needs authorization to update a user', function () {
    $this->user->attachRole('admin');

    $this->role = Role::find(1);
    $this->role->detachPermission('user.update');

    Livewire::test('user')
        ->call('edit')
        ->assertForbidden();

    $this->user->detachRole('admin');
    $this->user->attachRole('admin', $this->team);

    Livewire::test('user')
        ->call('edit')
        ->assertForbidden();

    $this->user->attachRole('admin');
    $this->role->attachPermission('user.update');

    Livewire::test('user')
        ->call('edit')
        ->assertSuccessful();

    $this->user->detachRole('admin');
    $this->user->attachRole('admin', $this->team);

    Livewire::test('user')
        ->call('edit')
        ->assertForbidden();
});
