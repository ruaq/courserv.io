<?php

namespace App\Listeners;

use App\Events\CourseCreated;
use App\Models\Course;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class GenerateInternalNumber implements ShouldQueue
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
        $wait = false;

        if (Cache::has('generating-internal-course-number')) {
            $wait = true;
        }

        while ($wait) {
            sleep(1);
            if (! Cache::has('generating-internal-course-number')) {
                $wait = false;
            }
        }

        Cache::put('generating-internal-course-number', true, 5);

        $number = Course::whereYear(
            'start',
            $event->course->start->format('Y')
        )->whereNotIn(
            'internal_number',
            ['queued']
        )->orderByDesc('id')->first();

        if ($number) {
            $last_number = explode('-', $number->internal_number);
        } else {
            $last_number[1] = 0;
        }

        $new_number = $last_number[1] + 1;

        $event->course->internal_number = $event->course->start->format('Y') . '-' . $new_number;

        Cache::forget('generating-internal-course-number');

        $event->course->save();
    }
}
