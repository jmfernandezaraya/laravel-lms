@component('mail::message')
{{$data->subject}}
{{$data->message}}

@component('mail::button', ['url' => url('/')])
@lang('Frontend.return_to_home_page')
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
