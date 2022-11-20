<?php

namespace App\Listeners;

use App\Classes\CertificateClass;
use App\Events\CertificateRequested;
use App\Models\Course;
use App\Models\CourseType;
use App\Models\Price;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use setasign\Fpdi\PdfParser\Filter\FilterException;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;
use setasign\Fpdi\PdfReader\PdfReaderException;

class GenerateCertificate implements ShouldQueue
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
     * @param CertificateRequested $event
     * @return void
     * @throws CrossReferenceException
     * @throws FilterException
     * @throws PdfParserException
     * @throws PdfTypeException
     * @throws PdfReaderException
     */
    public function handle(CertificateRequested $event): void
    {
        $course = Course::whereId($event->course)
            ->with(
                ['participants' => fn ($query) =>
                $query->whereIn('id', $event->participants)
                    ->where('cancelled', 0),
                ]
            )
            ->with('prices')
            ->with('trainer')
            ->first();

        // if no participants found, abort
        if (! count($course->participants)) {
            $this->delete();

            return;
        }

        $courseType = CourseType::whereId($course->id)
            ->with('certTemplate')
            ->first();

        $templates = [];

        // if the courseType has a cert template, use it as fallback
        if ($courseType->cert_template_id) {
            $templates[0]['filename'] = $courseType->certTemplate->filename;
        }


        $prices = [];
        foreach ($course->prices as $price) {
            if ($price->cert_template_id) {
                $prices[] = $price->id;
            }
        }

        $price_certs = Price::whereIn('id', $prices)
            ->with('certTemplate')
            ->get();

        foreach ($price_certs as $price) {
            $templates[$price->id]['filename'] = $price->certTemplate->filename;
        }

        $cert = new CertificateClass();
        $cert->setCourse($course);
        $cert->setUser($event->user);

        if ($course->trainer[0]) {
            $trainer = User::whereId($course->trainer[0]->user_id)->first();
            $cert->setTrainer($trainer->name);
        } else {
            $cert->setTrainer(''); // set blank if no trainer was selected
        }

        foreach ($course->participants as $participant) {
            if (array_key_exists($participant->price_id, $templates)) {
                $templateFile = $templates[$participant->price_id]['filename'];
            } else {
                if (!isset($templates[0])) { // skip if no course type template is set
                    continue;
                }

                $templateFile = $templates[0]['filename'];
            }

            $cert->setCertTemplate($templateFile);
            $cert->setFilename($participant->id);
            $cert->replacePlaceholders($participant);
            $cert->generatePdf();
        }

        $cert->concatPdfs();
    }
}
