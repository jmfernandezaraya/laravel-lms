@component('mail::message')
<center><b>{{$data->subject}}</b></center>


<p>{!! $data->message !!}</p>
@component('mail::button', ['url' => url('/')])
    Return To Home Page
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
