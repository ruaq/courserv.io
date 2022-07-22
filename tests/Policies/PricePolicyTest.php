<?php

use App\Models\Price;
use App\Models\Team;
use App\Models\User;
use Database\Seeders\PermissionSeeder;

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

it('has anyView function', function () {
    $this->assertFalse($this->user->can('viewAny', Price::class));

    $this->user->attachPermission('price.create');
    $this->assertTrue($this->user->can('viewAny', Price::class));

    $this->user->detachPermission('price.create');
    $this->assertFalse($this->user->can('viewAny', Price::class));

    $this->user->attachPermission('price.create', $this->team);
    $this->assertTrue($this->user->can('viewAny', Price::class));

    $this->user->detachPermission('price.create', $this->team);
    $this->assertFalse($this->user->can('viewAny', Price::class));

    $this->user->attachPermission('price.update');
    $this->assertTrue($this->user->can('viewAny', Price::class));

    $this->user->detachPermission('price.update');
    $this->assertFalse($this->user->can('viewAny', Price::class));

    $this->user->attachPermission('price.update', $this->team);
    $this->assertTrue($this->user->can('viewAny', Price::class));
});

it('needs permission to create a new price', function () {
    $this->assertFalse($this->user->can('create', Price::class));

    $this->user->attachPermission('price.create');

    $this->assertTrue($this->user->can('create', Price::class));

    $this->user->detachPermission('price.create');
    $this->user->attachPermission('price.create', $this->team);

    $this->assertTrue($this->user->can('create', Price::class));
});

it('needs permission to edit a price', function () {
    $price = Price::factory()->create();

    $this->assertFalse($this->user->can('update', $price));

    $this->user->attachPermission('price.update');

    $this->assertTrue($this->user->can('update', $price));

    $this->user->detachPermission('price.update');
    $this->assertFalse($this->user->can('update', $price));

    $this->user->attachPermission('price.update', $this->team);

    $this->assertTrue($this->user->can('update', $price));
});
