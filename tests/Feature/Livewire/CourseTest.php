<?php

use App\Http\Livewire\Course;
use App\Models\Team;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Livewire\Livewire;
use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->seed(PermissionSeeder::class);

    $this->team = Team::create([
        'name' => 'example-team',
        'display_name' => 'example team',
    ]);

    $this->team2 = Team::create([
        'name' => 'example-team-2',
        'display_name' => '2nd example team',
    ]);

    $this->teams = $this->team;

    $this->user = User::factory()->create();
    $this->user->teams()->attach($this->team);

    //  $this->user->attachRole('admin');

    actingAs($this->user);
});

it('can render the component', function () {
    $this->user->attachRole('admin');

    $component = Livewire::test(Course::class);

    $component->assertStatus(200);
});

it('has course page which needs to be logged in', function () {
    $this->user->attachRole('admin');

    $response = $this->get(route('course'));

    $response->assertStatus(200);

    $response->assertSeeLivewire('course');

    auth()->logout($this->user);
    $response = $this->get(route('course'));
    $response->assertRedirect(route('login'));
});

it('needs permission to create a course', function () {
    $this->user->attachPermission('course.view'); // avoid 'fingerprint' error

    Livewire::test('course')
        ->call('create')
        ->assertForbidden();

    $this->user->attachPermission('course.create');

    Livewire::test('course')
        ->call('create')
        ->assertSuccessful();

    $this->user->detachPermission('course.create');

    Livewire::test('course')
        ->call('create')
        ->assertForbidden();

    $this->user->attachPermission('course.create', $this->team);

    Livewire::test('course')
        ->call('create')
        ->assertSuccessful();
});

it('needs permission to update a course', function () {
    $this->user->attachPermission('course.view'); // avoid 'fingerprint' error

    Livewire::test('course')
        ->call('edit')
        ->assertForbidden();

    $this->user->attachPermission('course.update');

    Livewire::test('course')
        ->call('edit')
        ->assertSuccessful();
});

it('needs permission to save a new course or update it', function () {
    $this->user->attachPermission('course.view'); // avoid 'fingerprint' error

    Livewire::test('course')
        ->call('save')
        ->assertForbidden();

    $this->user->attachPermission('course.create');

    Livewire::test('course')
        ->call('save')
        ->assertSuccessful();

    $this->user->detachPermission('course.create');

    Livewire::test('course')
        ->call('save')
        ->assertForbidden();

    $this->user->attachPermission('course.update');

    Livewire::test('course')
        ->call('save')
        ->assertSuccessful();
});
