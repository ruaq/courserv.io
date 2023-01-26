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

namespace App\Classes;

use Http;
use League\Csv\Exception;
use League\Csv\InvalidArgument;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\TabularDataReader;

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
    public function getContent(): TabularDataReader
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
