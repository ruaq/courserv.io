<?php

use App\Models\CourseType;
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

it('needs permission to create a new Course type', function () {
    $this->assertFalse($this->user->can('create', CourseType::class));

    $this->user->attachPermission('courseType.create');

    $this->assertTrue($this->user->can('create', CourseType::class));
});

it('needs permission to edit a Course type', function () {
    $courseType = CourseType::factory()->create();

    $this->assertFalse($this->user->can('update', $courseType));

    $this->user->attachPermission('courseType.update');

    $this->assertTrue($this->user->can('update', $courseType));
});

it('has anyView function', function () {
    $this->assertFalse($this->user->can('viewAny', CourseType::class));

    $this->user->attachPermission('courseType.create');

    $this->assertTrue($this->user->can('viewAny', CourseType::class));

    $this->user->detachPermission('courseType.create');

    $this->assertFalse($this->user->can('viewAny', CourseType::class));

    $this->user->attachPermission('courseType.update');

    $this->assertTrue($this->user->can('viewAny', CourseType::class));
});
