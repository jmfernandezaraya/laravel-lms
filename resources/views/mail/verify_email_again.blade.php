@component('mail::message')

    @lang('Frontend.email_verify_body_message')

    @component('mail::button', ['url' => $url])
        @lang('Frontend.verify_email')
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
