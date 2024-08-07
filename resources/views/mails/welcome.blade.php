@component('mail::message')
# Welcome to Our Platform, {{ $user->name }}

Your account has been successfully created. Below are your login details:

- **Username:** {{ $user->email }}
- **Password:** {{ $password }}

@component('mail::button', ['url' => url('/')])
Login Now
@endcomponent

Please make sure to change your password after your first login.

Thanks,<br>
{{ config('app.name') }}
@endcomponent

