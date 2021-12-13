@component('mail::message')
# Password Reset

{{ _i('We got your request to reset your password. Click the Button to reset it.') }}

@component('mail::button', ['url' => $link])
{{ _i('reset password') }}
@endcomponent

{{ _i('The link is valid for only %s minutes.', $minutes) }}

{{ _i('If you didn\'t requested this e-mail, please ignore and delete it.') }}

---
{{ _i('If the button doesn\'t work click or copy and paste the following link in your browser: ') }} [{{ $link }}]({{ $link }})
@endcomponent
