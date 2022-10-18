<?php

namespace App\Listeners;

use App\Events\QsehCourseUpdated;
use App\Services\QsehService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateQsehCourse implements ShouldQueue
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
     * @param QsehCourseUpdated $event
     * @return void
     */
    public function handle(QsehCourseUpdated $event)
    {
        if (
            ! $event->course->registration_number
            || $event->course->registration_number == 'queued'
            || $event->course->registration_number == 'failed'
        ) {
            $this->delete();

            return;
        }

        $qsehService = new QsehService();

        $response = $qsehService->connect($event->course, 'update');

        if (! $response['success'] || $response['response'] != $event->course->registration_number) {
            $this->fail();
        }
    }
}
