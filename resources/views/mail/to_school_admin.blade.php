@component('mail::message')
{{__('Mail.dear')}} {{ $data->name }},<br />
<strong>{{__('Mail.subject')}}:</strong> {{ $data->subject }}<br />
<strong>{{__('Mail.message')}}:</strong> {!! $data->message !!}<br />

{{__('Mail.thank_you')}},<br />
<a href="{{$data->website_link}}">{{ config('app.name') }}</a>
@endcomponent