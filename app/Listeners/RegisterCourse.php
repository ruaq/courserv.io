<?php

namespace App\Listeners;

use App\Events\CourseCreated;
use App\Services\QsehService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RegisterCourse implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param CourseCreated $event
     * @return void
     */
    public function handle(CourseCreated $event)
    {
        if ($event->course->registration_number != 'queued' && $event->course->registration_number != 'failed') {
            $this->delete();
            return;
        }

        $qsehService = new QsehService();

        $response = $qsehService->connect($event->course, 'new');

        if ($response['success']) {
            $event->course->registration_number = $response['response'];
            $event->course->save();
        } else {
            $event->course->registration_number = 'failed';
            $event->course->save();
            $this->fail();
        }
    }
}
