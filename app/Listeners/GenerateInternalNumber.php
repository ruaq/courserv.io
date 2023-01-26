<?php

/*
| Copyright 2023 courservio.de
|
| Licensed under the EUPL, Version 1.2 or – as soon they
| will be approved by the European Commission - subsequent
| versions of the EUPL (the "Licence");
| You may not use this work except in compliance with the
| Licence.
| You may obtain a copy of the Licence at:
|
| https://joinup.ec.europa.eu/software/page/eupl
|
| Unless required by applicable law or agreed to in
| writing, software distributed under the Licence is
| distributed on an "AS IS" basis,
| WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
| express or implied.
| See the Licence for the specific language governing
| permissions and limitations under the Licence.
*/

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
     * @param  CourseCreated  $event
     * @return void
     */
    public function handle(CourseCreated $event): void
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

        $event->course->internal_number = $event->course->start->format('Y').'-'.$new_number;

        Cache::forget('generating-internal-course-number');

        $event->course->save();
    }
}
