<?php

namespace App\Listeners;

use App\Events\CourseCancelled;
use App\Services\QsehService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CancelCourse implements ShouldQueue
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
     * @param  CourseCancelled  $event
     * @return void
     */
    public function handle(CourseCancelled $event)
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

        $response = $qsehService->connect($event->course, 'cancel');

        if (! $response['success'] || $response['response'] != $event->course->registration_number) {
            $this->fail();
        }
    }
}
