<?php

namespace App\Listeners;

use App\Classes\CsvImportClass;
use App\Events\GeodataUpdated;
use App\Models\Location;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use League\Csv\Exception;
use League\Csv\InvalidArgument;

class ImportGeoLocations implements ShouldQueue
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
     * @param GeodataUpdated $event
     * @return void
     * @throws Exception
     * @throws InvalidArgument
     */
    public function handle(GeodataUpdated $event): void
    {
        $csv = new CsvImportClass();
        $csv->setUrl(config('geodata.url'));
        $csv->setFile('locations.csv');

        $records = $csv->getContent();

        $data = [];

        //query your records from the document
        foreach ($records as $record) {
            $record['location'] = correctGeolocation($record['location']);

            $data[] = $record; // to our new array
        }

        $array_chunk = array_chunk($data, 500); // chunk to 500 each, cause of mysql / mariadb limits
        $insert = [];

        Location::truncate();

        foreach ($array_chunk as $chunk) {
            $insert[] = Location::insert($chunk);
        }
    }
}
