@component('mail::message')
# {{$subject}}

{{$message}}

@component('mail::button', ['url' => url('/')])
Redirect To Home Page
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
