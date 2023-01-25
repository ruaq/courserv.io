<?php

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
