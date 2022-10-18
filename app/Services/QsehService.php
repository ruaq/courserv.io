<?php

namespace App\Services;

use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Vyuldashev\XmlToArray\XmlToArray;

class QsehService
{
    private PendingRequest $client;

    public function __construct()
    {
        $this->client = $this->initClient();
    }

    private function initClient(): PendingRequest
    {
        return Http::withHeaders([
            'SOAPAction' => 'Ehaf3LehrgangService.wsdl',
        ])
            ->withOptions([
                'base_uri' => 'https://www.bg-qseh.de/login/perl/service.pl?LehrgangsService',
            ])
            ->accept('text/xml');
    }

    /**
     * @param Course $course
     * @param string $action
     * @return Collection
     */
    public function connect(Course $course, string $action = 'new'): Collection
    {
        if (! config('qseh.codeNumber') || ! config('qseh.password')) { // no service without credentials
            exit();
        }

        if (! $course->type->wsdl_id) { // abort if it isn't an QSEH course (anymore)
            exit();
        }

        // make sure we got the correct action and registration number
        if ($action == 'update') {
            $action = 'Update';
            $registration_number = $course->registration_number;
        } elseif ($action == 'cancel') {
            $action = 'Storno';
            $registration_number = $course->registration_number;
        } else {
            $action = 'Neu';
            $registration_number = '';
        }

        // possible error responses ... for working on later

//        array:1 [▼
//      "soapenv:Envelope" => array:1 [▼
//        "soapenv:Body" => array:1 [▼
//          "soapenv:Fault" => array:3 [▼
//            "faultcode" => "soapenv:Server"
//            "faultstring" => "unknown"
//            "detail" => null
//          ]
//        ]
//      ]
//    ]

        // 01.08.2023 liegt zu weit in der Zukunft. Es ist nur +1 Jahr zugelassen.
        // "01.08.2023 liegt zu weit in der Zukunft. Es ist nur +1 Jahr zugelassen.,
        // Für die Lehrgangsart: '3' haben Sie zu dem Zeitpunkt 01.08.2023 keine Berechtigung."
        // Das Startdatum eines Lehrgangs ist nicht änderbar
        // 30.12.2021 != 01.08.2022 wenn der Kurs in der Vergangenheit liegt
        // Der Lehrgang mit der ID: "88385/2021" ist schon Storniert, somit kann er nicht mehr gespeichert werden

        $time = $course->start->format('H:i') . ' Uhr - ' . $course->end->format('H:i') . ' Uhr';

        $this->generate(
            $action,
            $course->type->wsdl_id,
            $course->start,
            $time,
            $course->seminar_location,
            $course->street,
            $course->zipcode,
            $course->location,
            $registration_number
        );

//        $this->generate(
//            'Update',
//            '1',
//            '10.01.2022 08:00',
//            '08:00 Uhr - 15:30 Uhr',
//            'Testfirma',
//            'Teststr. 14',
//            '12345',
//            'Musterstadt',
//            '88385/2021'
//        );

        $response = $this->client->post('');

        $result = XmlToArray::convert($response);

        return collect([
            'response' => $result['soapenv:Envelope']
            ['soapenv:Body']
            ['ns2:ehaf3RequestHandlerResponse']
            ['return']
            ['ns1:beschreibung'],
            'success' => $result['soapenv:Envelope']
            ['soapenv:Body']
            ['ns2:ehaf3RequestHandlerResponse']
            ['return']
            ['ns1:code'],
        ]);
    }

    // function to use (later) for (server) error catching
//    private function isValidXml($content): bool
//    {
//        $content = trim($content);
//        if (empty($content)) {
//            return false;
//        }
//        //html go to hell!
//        if (stripos($content, '<!DOCTYPE html>') !== false) {
//            return false;
//        }
//
//        libxml_use_internal_errors(true);
//        simplexml_load_string($content);
//        $errors = libxml_get_errors();
//        libxml_clear_errors();
//
//        return empty($errors);
//    }

    private function generate(
        $action,
        $course_type,
        $start,
        $time,
        $seminar_location,
        $street,
        $zipcode,
        $location,
        $number = '',
        $comment = ''
    ) {
        // SOAP sucks... Let's fake the request

        $xml_request = '<?xml version="1.0" encoding="UTF-8"?>
            <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                    xmlns:ehaf="http://www.portsol19.de/Ehaf3LehrgangService/"
                    xmlns:xsd="http://www.vbg.de.uv_services.ehaf3.bibliothek/xsd">
                <soapenv:Header/>
                <soapenv:Body>
                    <ehaf:ehaf3RequestHandler>
                        <LehrgangsUebermittlung>
                            <xsd:absenderID>registerbot@courserv.io</xsd:absenderID>
                            <xsd:empfaengerID>ehaf</xsd:empfaengerID>
                            <xsd:sendungsID>1</xsd:sendungsID>
                            <xsd:serviceID>1</xsd:serviceID>
                            <xsd:zeitstempel>' . Carbon::now()->format('Y-m-d\TH:i:s') . '</xsd:zeitstempel>
                            <lehrgang>
                                <xsd:lehrgangsArt>' . $course_type . '</xsd:lehrgangsArt>
                                <xsd:startDatum>' . Carbon::parse($start)->format('Y-m-d\TH:i:s') . '</xsd:startDatum>
                                <xsd:zeitlicherVerlauf>' . $time . '</xsd:zeitlicherVerlauf>
                                <xsd:adresseFirma>' . str_replace('&', 'u.', $seminar_location) . '</xsd:adresseFirma>
                                <xsd:adresseOrt>' . $location . '</xsd:adresseOrt>
                                <xsd:adressePlz>' . $zipcode . '</xsd:adressePlz>
                                <xsd:adresseStrasse>' . $street . '</xsd:adresseStrasse>
                                <!--Optional:-->
                                <xsd:vermerk>' . $comment . '</xsd:vermerk>
                                <!--Optional:-->
                                <xsd:lehrId>' . $number . '</xsd:lehrId>
                            </lehrgang>
                            <Benutzer>' . config('qseh.codeNumber') . '</Benutzer>
                            <Kennwort>' . config('qseh.password') . '</Kennwort>
                            <Aktion>' . $action . '</Aktion>
                        </LehrgangsUebermittlung>
                    </ehaf:ehaf3RequestHandler>
                </soapenv:Body>
            </soapenv:Envelope>';

        $this->client->withBody($xml_request, 'text/xml');
    }
}
