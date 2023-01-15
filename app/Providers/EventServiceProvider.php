<?php

namespace App\Providers;

use App\Events\CertificateRequested;
use App\Events\CourseBooked;
use App\Events\CourseCancelled;
use App\Events\CourseCreated;
use App\Events\CourseRegisterRequired;
use App\Events\GeodataUpdated;
use App\Events\QsehCourseUpdated;
use App\Events\UserCreated;
use App\Events\UserForgotPassword;
use App\Listeners\CancelCourse;
use App\Listeners\GenerateCertificate;
use App\Listeners\GenerateInternalNumber;
use App\Listeners\ImportGeoCoordinates;
use App\Listeners\ImportGeoLocations;
use App\Listeners\RegisterCourse;
use App\Listeners\SendParticipantBookingConfirmation;
use App\Listeners\SendPasswordResetEmail;
use App\Listeners\SendWelcomeEmail;
use App\Listeners\UpdateQsehCourse;
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
            GenerateInternalNumber::class,
        ],

        CourseRegisterRequired::class => [
            RegisterCourse::class,
        ],

        QsehCourseUpdated::class => [
            UpdateQsehCourse::class,
        ],

        CourseCancelled::class => [
            CancelCourse::class,
        ],

        CourseBooked::class => [
            SendParticipantBookingConfirmation::class,
        ],

        CertificateRequested::class => [
            GenerateCertificate::class,
        ],

        GeodataUpdated::class => [
            ImportGeoCoordinates::class,
            ImportGeoLocations::class,
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
