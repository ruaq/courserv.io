<?php

use App\Models\Course;
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

it('needs permission to create a new course', function () {
    $this->assertFalse($this->user->can('create', Course::class));

    $this->user->attachPermission('course.create');

    $this->assertTrue($this->user->can('create', Course::class));

    $this->user->detachPermission('course.create');
    $this->user->attachPermission('course.create', $this->team);

    $this->assertTrue($this->user->can('create', Course::class));
});

it('needs permission to edit a course', function () {
    $course = Course::factory()->create();

    $this->assertFalse($this->user->can('update', $course));

    $this->user->attachPermission('course.update');

    $this->assertTrue($this->user->can('update', $course));

    $this->user->detachPermission('course.update');
    $this->user->attachPermission('course.update', $this->team);

    $this->assertTrue($this->user->can('update', $course));
});

it('has anyView function', function () {
    $this->assertFalse($this->user->can('viewAny', Course::class));

    $this->user->attachPermission('course.create');

    $this->assertTrue($this->user->can('viewAny', Course::class));

    $this->user->detachPermission('course.create');
    $this->user->attachPermission('course.create', $this->team);

    $this->assertTrue($this->user->can('viewAny', Course::class));

    $this->user->detachPermission('course.create', $this->team);

    $this->assertFalse($this->user->can('viewAny', Course::class));

    $this->user->attachPermission('course.update');

    $this->assertTrue($this->user->can('viewAny', Course::class));

    $this->user->detachPermission('course.update');
    $this->user->attachPermission('course.update', $this->team);

    $this->assertTrue($this->user->can('viewAny', Course::class));
});
