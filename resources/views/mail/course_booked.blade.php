@component('mail::message')
{{__('Mail.dear')}} {{ $data->customer_name }},<br />
{{__('Mail.thank_you_choosing')}} <a href="{{$data->website_link}}">{{__('Mail.website_name')}}</a> {{__('Mail.to_helping_you')}}<br />
{{__('Mail.find_attached_quotation')}}<br />
<strong>{{__('Mail.your_customer_no')}}:</strong> {{ $data->customer_no }}<br />

{{__('Mail.thank_you')}}
@endcomponent