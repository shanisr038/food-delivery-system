<x-mail::message>
# Welcome to {{ $restaurant }}

You have been added as a staff member. Please click the button below to set your password and access the dashboard.

<x-mail::button :url="$setUrl">
Set Password
</x-mail::button>

If the link expires, you can request a new one here:
<x-mail::button :url="$requestNewUrl" color="success">
Request New Link
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>