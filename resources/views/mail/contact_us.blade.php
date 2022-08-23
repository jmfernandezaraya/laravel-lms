@component('mail::message')
    {{$subject}}
    {{$message}}
<br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent