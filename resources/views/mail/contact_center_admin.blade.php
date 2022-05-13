@component('mail::message')
{{__('Mail.subject')}} {{ $data->subject }},
{{__('Mail.message')}}: {{ $data->message }}

{{__('Mail.thanks')}},<br>
{{ config('app.name') }}
@endcomponent