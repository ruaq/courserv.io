<?php

namespace App\Classes;

use App\Models\Course;
use App\Models\Participant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\Exception\CopyFileException;
use PhpOffice\PhpWord\Exception\CreateTemporaryFileException;
use PhpOffice\PhpWord\TemplateProcessor;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use setasign\Fpdi\PdfParser\Filter\FilterException;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;
use setasign\Fpdi\PdfReader\PdfReaderException;
use setasign\FpdiProtection\FpdiProtection;

class CertificateClass
{
    public Course $course;

    public User $user;

    public string|int $filename;

    public string $path;

    private array $files = [];

    public string $certTemplate;

    private string $trainer;

    private bool $encrypt = true;

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

    public function setEncryption(bool $encrypt): void
    {
        $this->encrypt = $encrypt;
    }

    /**
     * @throws CopyFileException
     * @throws CreateTemporaryFileException
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

    public function addFile($file): void
    {
        $this->files[] = $file;
    }

    private function deleteFiles(): void
    {
        foreach ($this->files as $file) {
            @unlink($file);
        }
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
     * @throws CrossReferenceException
     * @throws PdfReaderException
     * @throws PdfParserException
     * @throws PdfTypeException
     * @throws FilterException
     */
    public function concatPdfs(): void
    {
        $pdf = new ConcatPdf();

        if ($this->encrypt) {
            // let's encrypt the new .pdf file
            $pdf->setProtection(
                FpdiProtection::PERM_PRINT | FpdiProtection::PERM_DIGITAL_PRINT
            );
        }

        $pdf->setFiles($this->files);
        $pdf->concat();

        $pdf->Output(
            'F',
            $this->path.$this->filename.'.pdf'
        );

        $this->deleteFiles();
    }
}
