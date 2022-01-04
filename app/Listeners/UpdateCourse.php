<?php

namespace App\Listeners;

use App\Events\CourseUpdated;
use App\Services\QsehService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateCourse implements ShouldQueue
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
     * @param CourseUpdated $event
     * @return void
     */
    public function handle(CourseUpdated $event)
    {
        if (!$event->course->registration_number || $event->course->registration_number == 'queued' || $event->course->registration_number == 'failed') {
            $this->delete();
            return;
        }

        $qsehService = new QsehService();

        $response = $qsehService->connect($event->course, 'update');

        if (!$response['success'] || $response['response'] != $event->course->registration_number) {
            $this->fail();
        }
    }
}
