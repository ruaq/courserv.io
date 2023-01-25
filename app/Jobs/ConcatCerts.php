<?php

namespace App\Jobs;

use App\Classes\CertificateClass;
use App\Models\Participant;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use setasign\Fpdi\PdfParser\Filter\FilterException;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;
use setasign\Fpdi\PdfReader\PdfReaderException;

class ConcatCerts implements ShouldQueue
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private array $files;
    private string $path;

    public int $tries = 5;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($files)
    {
        $this->files = $files;

        $this->path = Storage::path('/certTmp/');
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws CrossReferenceException
     * @throws FilterException
     * @throws PdfParserException
     * @throws PdfTypeException
     * @throws PdfReaderException
     */
    public function handle(): void
    {
        $filename_array = [];

        foreach ($this->files as $file) {
            $f = 'certTmp/' . $this->batchId . '-' . $file . '.pdf';
            if (! Storage::exists($f)) { // skip if file not exists (cancelled participant)
                continue;
            }

            $filename_array[] = $this->path . $this->batchId . '-' . $file . '.pdf';
        }

        $chunk = array_chunk($filename_array, 50);

        $i = 0;
        foreach ($chunk as $c) {
            $pdf_chunk = new CertificateClass();
            $pdf_chunk->setEncryption(false);

            foreach ($c as $x) {
                $pdf_chunk->addFile($x);
            }

            $pdf_chunk->setFilename($this->batchId . '-CHUNK-' . $i);
            $pdf_chunk->concatPdfs();
            $i++;
        }
        $i--;

        $pdf = new CertificateClass();

        for ($x = 0; $x <= $i; $x++) {
            $pdf->addFile($this->path.$this->batchId . '-CHUNK-' . $x . '.pdf');
        }

        $pdf->setEncryption(true);

        $pdf->setFilename($this->batchId);
        $pdf->concatPdfs();
    }
}
