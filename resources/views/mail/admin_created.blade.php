@component('mail::message')
{{__('Mail.name')}}: {{ $name }}<br />
{{__('Mail.email')}}: {{ $email }}<br />
{{__('Mail.password')}}: {{ $password }}<br />
{{__('Mail.dashboard_link')}}: {{ $dashbaord_link }}<br />
@component('mail::button', ['url' => $go_page])
@lang('Mail.go_dashboard')
@endcomponent

{{__('Mail.thank_you')}}
@endcomponent