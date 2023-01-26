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

use App\Events\CourseRegisterRequired;
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
     * @param  CourseRegisterRequired  $event
     * @return void
     */
    public function handle(CourseRegisterRequired $event)
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
