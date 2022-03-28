@component('mail::message')
{{$data['subject']}}

{!! $data['message'] !!}

@component('mail::button', ['url' => url('/')])
Return to Home Page
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
