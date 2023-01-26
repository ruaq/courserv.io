{{--
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
--}}

@component('mail::message')
# {{ _i('Booking confirmation') }}

{{ _i('Hello %s', $participant->firstname) }},

{{ _i('Your booking for our course *%s* was successful. Below you will receive more information about your booking.', $course->type->name) }}

**{{ _i('Course details') }}**

{{ \Carbon\Carbon::parse($course->start)->isoFormat('dd. DD.MM.YYYY') }} {{ \Carbon\Carbon::parse($course->start)->isoFormat('HH:mm') }} - {{ \Carbon\Carbon::parse($course->end)->isoFormat('HH:mm') }}

{{ $course->seminar_location }}\
{{ $course->street }}\
{{ $course->zipcode }} {{ $course->location }}

**{{ _i('price') }}**\
{{ \App\Models\Price::SIGN[$participant->currency] }} {{ $participant->price_gross }}

*{{ __('payments.' . $participant->payment . '.title')  }}*\
{{ __('payments.' . $participant->payment . '.description') }}

@if(config('booking.revocation') && !$participant->company && $course->start < $participant->created_at->addDays(14))
\
{{ _i('You have expressly stated the following prior to the conclusion of the contract:') }} *{{ _i('I agree that you start the execution of the contract before the expiry of the revocation period of 14 days and in this respect I waive the [right of revocation](%s) to which I am entitled.', config('booking.revocation')) }}*
@endif

{{ _i('If you have any questions, just reply to this email.') }}

{{--@component('mail::button', ['url' => ''])--}}
{{--Button Text--}}
{{--@endcomponent--}}

{{ _i('Kind Regards,') }}\
{{ config('app.name') }} Team
@endcomponent
