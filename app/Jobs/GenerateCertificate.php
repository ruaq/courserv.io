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

namespace App\Jobs;

use App\Classes\CertificateClass;
use App\Models\Course;
use App\Models\Participant;
use App\Models\Price;
use App\Models\User;
use Exception;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GenerateCertificate implements ShouldQueue
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private int $id;

    public int $tries = 5;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($participant)
    {
        $this->id = $participant;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Exception
     */
    public function handle(): void
    {
        $participant = Participant::whereId($this->id)
            ->where('cancelled', null)
            ->with('course')
            ->first();

        // skip cancelled participants
        if (! $participant) {
            $this->delete();

            return;
        }

        $course = Course::whereId($participant->course_id)
            ->with('trainer')
            ->with('type')
            ->first();

        $price = Price::whereId($participant->price_id)
            ->with('certTemplate')
            ->first();

        $cert = new CertificateClass();
        $cert->setCourse($course);

        if ($course->trainer[0]) {
            $trainer = User::whereId($course->trainer[0]->user_id)->first();
            $cert->setTrainer($trainer->name);
        } else {
            $cert->setTrainer(''); // set blank if no trainer was selected
        }

        if ($price->cert_template_id) {
            $cert->setCertTemplate($price->certTemplate->filename);
        } else {
            $cert->setCertTemplate($course->type->certTemplate->filename);
        }

        $cert->setFilename($this->batchId . '-' . $participant->id);
        $cert->replacePlaceholders($participant);
        $cert->generatePdf();

        // it sometimes generates a blank / corrupt file. catch it...
        $filecontent = Storage::get('certTmp/' . $this->batchId . '-' . $participant->id . '.pdf');
        if (! str_starts_with($filecontent, "%PDF-")) {
            throw new Exception('file corrupt');
        }
    }
}
