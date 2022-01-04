<?php

use App\Services\QsehService;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Vyuldashev\XmlToArray\XmlToArray;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// TODO better way to combine it?
Route::localized(function () {
    Route::group(
        [
            'middleware' => [ '\App\Http\Middleware\Localization' ]
        ], function()
    {
        Route::get('/', function () {
            return view('welcome');
        });

        Route::get('login', \App\Http\Livewire\Auth\Login::class)
            ->middleware('guest')
            ->name('login');

        Route::get('home', \App\Http\Livewire\Home::class)
            ->name('home');

        Route::get('teams', \App\Http\Livewire\Team::class)
            ->name('teams');

        Route::get('user', \App\Http\Livewire\User::class)
            ->name('user');

        Route::get('coursetype', \App\Http\Livewire\CourseType::class)
            ->name('coursetype');

        Route::get('course', \App\Http\Livewire\Course::class)
            ->name('course');

        Route::get('roles', \App\Http\Livewire\Role::class)
            ->name('roles');

        Route::get('password/reset/{hashedId}', \App\Http\Livewire\PasswordReset::class)
            ->middleware('signed')
            ->name('password.reset');
    });
});

Route::get('/email/verify', function () {
    return view('auth.verify-email'); // TODO correct message if still not confirmed email
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('qseh', \App\Http\Controllers\QsehController::class);

Route::get('test', function () {

    dd(Carbon::now()->format('Y-m-d\TH:i:s'));

    $test = new \App\Http\Clients\NewsClient();

    $xx = new \App\Services\NewsService($test);

   // $x = XmlToArray::convert($xx->test());

    print_r($xx->headlines());
    exit;

    $client = new Client([
        'base_uri' => 'https://www.bg-qseh.de/login/perl/service.pl?LehrgangsService',
        'headers' => [
            'SOAPAction' => 'Ehaf3LehrgangService.wsdl',
            'Content-Type' => 'text/xml',
            'Accept' => 'text/xml',
        ],
    ]);

    $xml = '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
        xmlns:ehaf="http://www.portsol19.de/Ehaf3LehrgangService/"
        xmlns:xsd="http://www.vbg.de.uv_services.ehaf3.bibliothek/xsd">
    <soapenv:Header/>
    <soapenv:Body>
        <ehaf:ehaf3RequestHandler>
            <LehrgangsUebermittlung>
                <xsd:absenderID>system@ausbilder.org</xsd:absenderID>
                <xsd:empfaengerID>ehaf</xsd:empfaengerID>
                <xsd:sendungsID>1</xsd:sendungsID>
                <xsd:serviceID>1</xsd:serviceID>
                <xsd:zeitstempel>2022-01-02T21:25:30</xsd:zeitstempel>
                <lehrgang>
                    <xsd:lehrgangsArt>1</xsd:lehrgangsArt>
                    <xsd:startDatum>2021-12-30T08:00:00</xsd:startDatum>
                    <xsd:zeitlicherVerlauf>08:00 Uhr - 16:30 Uhr</xsd:zeitlicherVerlauf>
                    <xsd:adresseFirma>Testfirma</xsd:adresseFirma>
                    <xsd:adresseOrt>Testort</xsd:adresseOrt>
                    <xsd:adressePlz>12345</xsd:adressePlz>
                    <xsd:adresseStrasse>Teststr. 15</xsd:adresseStrasse>
                    <!--Optional:-->
                    <xsd:vermerk>Test Storno</xsd:vermerk>
                    <!--Optional:-->
                    <xsd:lehrId>9637/2021</xsd:lehrId>
                </lehrgang>
                <Benutzer>8.0000</Benutzer>
                <Kennwort>100%glueck</Kennwort>
                <Aktion>Update</Aktion>
            </LehrgangsUebermittlung>
        </ehaf:ehaf3RequestHandler>
    </soapenv:Body>
</soapenv:Envelope>';

// Send a request to https://foo.com/api/test
    $response = $client->post('', ['body' => $xml]);
  //  $response = $client->get('');
    $body = (string) $response->getBody();

    return XmlToArray::convert($body);
});

Route::fallback(\CodeZero\LocalizedRoutes\Controller\FallbackController::class)
    ->middleware(\CodeZero\LocalizedRoutes\Middleware\SetLocale::class);
