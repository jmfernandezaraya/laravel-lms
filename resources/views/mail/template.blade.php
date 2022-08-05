@component('mail::message')

@foreach ($contents as $content)
    @if ($content['type'] == 'message')
        {!! $content['message'] !!}
    @endif
    @if ($content['type'] == 'button')
        @component('mail::button', ['url' => $content['url']])
            {{ $content['message'] }}
        @endcomponent
    @endif
@endforeach

@endcomponent