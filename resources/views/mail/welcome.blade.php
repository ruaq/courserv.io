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
# {{ _i('Hello and Welcome') }}

{{ _i('A new account was created for you at %s.', config('app.name')) }}

{{ _i('To set a password click the link below. If you have further questions, please answer to this email.') }}

@component('mail::button', ['url' => $link])
{{ _i('Set a new password') }}
@endcomponent

{{ _i('The link is limited valid. If it\'s expired, go to [login](%s) and use the password forgot function', route('login')) }}

{{ _i('If you didn\'t requested this e-mail, please ignore and delete it.') }}

---
{{ _i('If the button doesn\'t work click or copy and paste the following link in your browser: ') }} [{{ $link }}]({{ $link }})
@endcomponent
