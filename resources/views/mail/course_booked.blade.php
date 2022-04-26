@component('mail::message')
{{__('Mail.course_booked.dear')}} {{ $data->customer_name }},
{{__('Mail.course_booked.thank_you_choosing')}} <a href="{{$data->website_link}}">{{__('Mail.course_booked.website_name')}}</a> {{__('Mail.course_booked.to_helping_you')}}
{{__('Mail.course_booked.find_attached_quotation')}}
{{__('Mail.course_booked.your_customer_no')}}: {{ $data->customer_no }}

{{__('Mail.course_booked.thank_you')}}
@endcomponent