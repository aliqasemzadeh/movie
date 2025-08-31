@component('mail::message')
# {{ __('quickpanel.email_forgot_password_title') }}

{{ __('quickpanel.email_forgot_password_intro') }}

@component('mail::panel')
{{ __('quickpanel.email_forgot_password_your_code') }}: **{{ $code }}**
@endcomponent

{{ __('quickpanel.email_forgot_password_expires', ['minutes' => $ttlMinutes]) }}

@component('mail::button', ['url' => route('change-password')])
{{ __('quickpanel.email_forgot_password_button') }}
@endcomponent

{{ __('quickpanel.email_forgot_password_outro') }}

{{ config('app.name') }}
@endcomponent
