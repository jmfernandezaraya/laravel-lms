@component('mail::message')
{{__('Mail.name')}}: {{ $name }}<br />
{{__('Mail.email')}}: {{ $email }}<br />
{{__('Mail.password')}}: {{ $password }}<br />
{{__('Mail.dashboard_link')}}: <a href="{{ $dashbaord_link }}">{{ $dashbaord_link }}</a><br />
@component('mail::button', ['url' => $go_page])
@lang('Mail.change_password')
@endcomponent

{{__('Mail.thank_you')}}
@endcomponent