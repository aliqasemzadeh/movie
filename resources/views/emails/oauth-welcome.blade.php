@component('mail::message')
# Welcome to {{ config('app.name') }}

Hi {{ $user->name }},

Your account has been successfully created using OAuth authentication. Here are your account details:

**Email:** {{ $user->email }}  
**Name:** {{ $user->name }}

## Your Default Password

For security purposes, we've generated a random password for your account:

**Password:** `{{ $password }}`

@component('mail::button', ['url' => route('login')])
Login to Your Account
@endcomponent

## Security Recommendations

1. **Change your password immediately** after your first login
2. **Enable two-factor authentication** for enhanced security
3. **Keep your password secure** and don't share it with anyone

If you have any questions or need assistance, please don't hesitate to contact our support team.

Thanks,<br>
{{ config('app.name') }} Team

---
*This is an automated message. Please do not reply to this email.*
@endcomponent

