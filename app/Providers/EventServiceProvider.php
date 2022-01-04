<?php

namespace App\Providers;

use App\Events\CourseCancelled;
use App\Events\CourseCreated;
use App\Events\CourseUpdated;
use App\Events\UserCreated;
use App\Events\UserForgotPassword;
use App\Listeners\CancelCourse;
use App\Listeners\RegisterCourse;
use App\Listeners\SendPasswordResetEmail;
use App\Listeners\SendWelcomeEmail;
use App\Listeners\UpdateCourse;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
//        Registered::class => [
//            SendEmailVerificationNotification::class,
//        ],

        UserForgotPassword::class => [
            SendPasswordResetEmail::class,
        ],

        UserCreated::class => [
            SendWelcomeEmail::class,
        ],

        CourseCreated::class => [
            RegisterCourse::class,
        ],

        CourseUpdated::class => [
            UpdateCourse::class,
        ],

        CourseCancelled::class => [
            CancelCourse::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
    }
}
