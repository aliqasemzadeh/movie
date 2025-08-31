@component('mail::message')
# {{ __('quickpanel.email_password_changed_title') }}

{{ __('quickpanel.email_password_changed_intro') }}

{{ __('quickpanel.email_password_changed_security_tip') }}

{{ config('app.name') }}
@endcomponent
