<?php

namespace App\Classes;

use App\Models\Course;
use App\Models\Participant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;
use setasign\FpdiProtection\FpdiProtection;
use Vinkla\Hashids\Facades\Hashids;

class CertificateClass
{
    public Course $course;

    public User $user;

    public string|int $filename;

    public string $path;

    private array $files = [];

    public string $certTemplate;

    private string $trainer;

    public function __construct()
    {
        $this->path = Storage::path('/certTmp/');
    }

    public function setCourse(Course $course): void
    {
        $this->course = $course;
    }

    public function setCertTemplate(string $certTemplate): void
    {
        $this->certTemplate = $certTemplate;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function setFilename(string|int $filename): void
    {
        $this->filename = $filename;
    }

    public function setTrainer(string $trainer): void
    {
        $this->trainer = $trainer;
    }

    /**
     * @throws \PhpOffice\PhpWord\Exception\CopyFileException
     * @throws \PhpOffice\PhpWord\Exception\CreateTemporaryFileException
     */
    public function replacePlaceholders(Participant $participant): void
    {
        // Used for generating a specific selected template (maybe for later use)
//        // Get the template data
//        $certData = CertTemplate::whereId($this->certTemplate)
//            ->with('courseTypes')
//            ->whereRelation('courseTypes', 'course_type_id', '=', $this->course->course_type_id)
//            ->first()
//            ->toArray();
//
//        if (! $certData) { // something went wrong / request manipulated
//            abort(403);
//        }
//
//        $templateProcessor = new TemplateProcessor(
//            Storage::path('/certTemplates/' . $certData['id'] . '.' . $certData['extension'])
//        );

//        dd($this->certTemplate);

        $templateProcessor = new TemplateProcessor(
            Storage::path('/certTemplates/'.$this->certTemplate)
        );

        $templateProcessor->setValues([
            'trainer' => $this->trainer,
            'firstname' => $participant->firstname,
            'lastname' => $participant->lastname,
            'date_of_birth' => Carbon::parse($participant->date_of_birth)->isoFormat('DD.MM.YYYY'),
            'course_start_date' => Carbon::parse($this->course->start)->isoFormat('DD.MM.YYYY'),
            'csd' => Carbon::parse($this->course->start)->isoFormat('DD.MM.YYYY'),
            'course_end_date' => Carbon::parse($this->course->end)->isoFormat('DD.MM.YYYY'),
            'ced' => Carbon::parse($this->course->end)->isoFormat('DD.MM.YYYY'),
            'course_start_time' => Carbon::parse($this->course->start)->isoFormat('HH:mm'),
            'cst' => Carbon::parse($this->course->start)->isoFormat('HH:mm'),
            'course_end_time' => Carbon::parse($this->course->end)->isoFormat('HH:mm'),
            'cet' => Carbon::parse($this->course->end)->isoFormat('HH:mm'),
            'internal_number' => $this->course->internal_number,
            'registration_number' => $this->course->registration_number,
        ]);

        $pathToSave = $this->path.$this->filename.'.docx';
        $templateProcessor->saveAs($pathToSave);
    }

    private function deleteTemplate(): void
    {
        Storage::delete('certTmp/'.$this->filename.'.docx');
    }

    private function addFile($file): void
    {
        $this->files[] = $file;
    }

    public function generatePdf(): void
    {
        $response = Http::attach(
            'data',
            file_get_contents($this->path.$this->filename.'.docx'),
            $this->filename.'.docx'
        )->post(config('convert.server').'/cool/convert-to/pdf');

        Storage::put('certTmp/'.$this->filename.'.pdf', $response->body());

        $this->addFile($this->path.$this->filename.'.pdf');
        $this->deleteTemplate();
    }

    /**
     * @throws \setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException
     * @throws \setasign\Fpdi\PdfReader\PdfReaderException
     * @throws \setasign\Fpdi\PdfParser\PdfParserException
     * @throws \setasign\Fpdi\PdfParser\Type\PdfTypeException
     * @throws \setasign\Fpdi\PdfParser\Filter\FilterException
     */
    public function concatPdfs(): void
    {
        $pdf = new ConcatPdf();

        // let's encrypt the new .pdf file
        $pdf->setProtection(
            FpdiProtection::PERM_PRINT | FpdiProtection::PERM_DIGITAL_PRINT
        );

        $pdf->setFiles($this->files);
        $pdf->concat();

        $pdf->Output(
            'F',
            $this->path.Hashids::encode($this->user->id).'-'.Hashids::encode($this->course->id).'.pdf'
        );
    }
}
