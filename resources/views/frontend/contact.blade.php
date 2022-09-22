@extends('frontend.layouts.app')

@section('title')
    {{__('Frontend.contact_us')}}
@endsection

@section('content')
    <div class="breadcrumbs" data-aos="fade-in">
        <div class="container">
            <h2>{{__('Frontend.contact_us')}}</h2>
            <p>{{__('Frontend.contact_us_description')}}</p>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- ======= Contact Section ======= -->
    <section id="contact-form" class="contact mt-3">
        <div class="container" data-aos="fade-up">
            <form action="{{route('contact-us')}}" method="post" role="form" class="php-email-form">
                {{csrf_field()}}

                <div class="row">
                    <div class="col-lg-4">
                        <div class="info address">
                            <i class="icofont-google-map"></i>
                            <h4>{{__('Frontend.location')}}:</h4>
                            <p>{{ getSiteLocation() }}</p>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <input type="text" name="name" class="form-control" id="name" placeholder="{{__('Frontend.your_name')}}" data-rule="minlen:4" data-msg="{{__('Frontend.4_chars_enter')}}" />
                                <div class="validate"></div>
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="email" class="form-control" name="email" id="email" placeholder="{{__('Frontend.your_email')}}" data-rule="email" data-msg="{{__('Frontend.valid_email')}}" />
                                <div class="validate"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="info email">
                            <i class="icofont-envelope"></i>
                            <h4>{{__('Frontend.email')}}:</h4>
                            <p>{{ getSiteEmail() }}</p>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="form-row">
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" name="subject" id="subject" placeholder="{{__('Frontend.subject')}}" data-rule="minlen:4" data-msg="{{__('Frontend.8chars_subject')}}" />
                                <div class="validate"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="info phone">
                            <i class="icofont-phone"></i>
                            <h4>{{__('Frontend.phone')}}:</h4>
                            <p>{{ getSitePhone() }}</p>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="form-row">
                            <div class="col-md-12 form-group">
                                <textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="Please write something for us" placeholder="{{__('Frontend.message')}}"></textarea>
                                <div class="validate"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="loading">{{__('Frontend.loading')}}</div>
                    <div class="error-message"></div>
                    <div class="sent-message">{{__('Frontend.message_sent_thank_you')}}</div>
                </div>
                <div class="text-center">
                    <button type="submit">{{__('Frontend.send_message')}}</button>
                </div>
            </form>
        </div>
    </section>
@endsection