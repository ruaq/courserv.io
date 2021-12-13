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
