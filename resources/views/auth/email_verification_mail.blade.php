@component('mail::message')
Hello {{ $newemailvalidator->name }},

@component('mail::button', ['url' => route('verify_email', $newemailvalidator->token)])
Click here to verify your email address
@endcomponent

Or copy and paste the following link into your web browser to verify your email address:

@component('mail::button', ['url' => route('verify_email', $newemailvalidator->token)])
{{ route('verify_email', $newemailvalidator->token) }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
