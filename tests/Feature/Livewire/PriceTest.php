<?php

use App\Http\Livewire\Price;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->seed(PermissionSeeder::class);

//    $this->team = Team::create([
//        'name' => 'example-team',
//        'display_name' => 'example team',
//    ]);
//
//    $this->teams = $this->team;

    $this->user = User::factory()->create();
//    $this->user->teams()->attach($this->team);
//    $this->user->attachRole('admin');

    actingAs($this->user);
});

it('can render the component', function () {
    $this->user->attachRole('admin');

    $component = Livewire::test(Price::class);

    $component->assertStatus(200);
});

it('has price page which needs to be logged in and authorized', function () {
    $response = $this->get(route('prices'));
    $response->assertForbidden();

    $this->user->attachPermission('price.create');

    $response = $this->get(route('prices'));
    $response->assertStatus(200);
    $response->assertSeeLivewire('price');

    $this->user->detachPermission('price.create');
    $this->user->attachPermission('price.update');

    $response = $this->get(route('prices'));
    $response->assertStatus(200);
    $response->assertSeeLivewire('price');

    auth()->logout($this->user);
    $response = $this->get(route('roles'));
    $response->assertRedirect(route('login'));
});

it('shows price menu only to authorized users', function () {
    $this->get(route('home'))->assertDontSee(_i('Prices'));

    $this->user->attachPermission('price.create');

    $this->get(route('home'))->assertSee(_i('Prices'));
});

it('needs authorization to create a price', function () {
    $this->user->attachPermission('price.create');

    Livewire::test('price')
        ->call('create')
        ->assertSuccessful();

    $this->user->detachPermission('price.create');
    $this->user->attachPermission('price.update'); // 'placeholder' to avoid fingerprint error

    Livewire::test('price')
        ->call('create')
        ->assertForbidden();
});
