<?php

namespace App\Listeners;

use App\Classes\CsvImportClass;
use App\Events\GeodataUpdated;
use App\Models\Coordinates;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use League\Csv\Exception;
use League\Csv\InvalidArgument;

class ImportGeoCoordinates implements ShouldQueue
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
        $csv->setFile('coordinates.csv');

        $records = $csv->getContent();

        $state = [
            '01' => 'Schleswig-Holstein',
            '02' => 'Hamburg',
            '03' => 'Niedersachsen',
            '04' => 'Bremen',
            '05' => 'Nordrhein-Westfalen',
            '06' => 'Hessen',
            '07' => 'Rheinland-Pfalz',
            '08' => 'Baden-Württemberg',
            '09' => 'Bayern',
            '10' => 'Saarland',
            '11' => 'Berlin',
            '12' => 'Brandenburg',
            '13' => 'Mecklenburg-Vorpommern',
            '14' => 'Sachsen',
            '15' => 'Sachsen-Anhalt',
            '16' => 'Thüringen',
        ];

        $data = [];
        foreach ($records as $record) {
            if ($record['lat']) { // only if we have coordinates
                $record['location'] = correctGeolocation($record['location']);

                $record['state'] = $state[$record['state']];

                // replace the comma with a dot in the coordinates
                $record['lat'] = str_replace(',', '.', $record['lat']);
                $record['lon'] = str_replace(',', '.', $record['lon']);

                $record['country_code'] = 'DE';

                $data[] = $record; // to our new array
            }
        }

        $array_chunk = array_chunk($data, 500); // chunk to 500 each, cause of mysql / mariadb limits
        $insert = [];

        Coordinates::truncate();

        foreach ($array_chunk as $chunk) {
            $insert[] = Coordinates::insert($chunk);
        }
    }
}
