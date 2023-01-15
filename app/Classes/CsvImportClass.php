<?php

namespace App\Classes;

use Http;
use League\Csv\Exception;
use League\Csv\InvalidArgument;
use League\Csv\Reader;
use League\Csv\Statement;

class CsvImportClass
{
    protected string $url;
    protected string $file;

    public function __construct()
    {
        if (! ini_get("auto_detect_line_endings")) {
            ini_set("auto_detect_line_endings", '1');
        }
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function setFile($file): void
    {
        $this->file = $file;
    }

    /**
     * @throws InvalidArgument
     * @throws Exception
     */
    public function getContent(): \League\Csv\TabularDataReader
    {
        $content = Http::get($this->url . $this->file);

        //load the CSV document from a stream
        $csv = Reader::createFromString($content->body());
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);

        //build a statement
        $stmt = Statement::create()
            ->offset(0);
        //     ->limit(25);

        //query your records from the document
        return $stmt->process($csv);
    }
}
