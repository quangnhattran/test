@component('mail::message')
# Confirmation Email

Your account is not verified yet. Please click on below link to confirm your email address.

@component('mail::button', ['url' => url('/register/confirm?token='.$user->confirmation_token)])
Confirm Now
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
