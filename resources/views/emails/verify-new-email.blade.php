@component('mail::message')
# Verify your new email address

Hello {{ $username }},

You recently requested to change the email on your account. To confirm this change, please verify your new email address.

@component('mail::panel')
Your 6-digit verification code:

# **{{ $code }}**
@endcomponent

You can either enter the above code on the verification page, or simply click the button below:

@component('mail::button', ['url' => $link])
Verify Email
@endcomponent

This code and link will expire in 30 minutes. If you did not request this change, you can safely ignore this email.

Thanks,
{{ config('app.name') }}
@endcomponent
