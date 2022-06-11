@extends('frontend.layouts.app')

@section('title')
    {{__('Frontend.dashboard')}}
@endsection

@section('breadcrumbs')
    <h1>{{__('Frontend.your_account')}}</h1>
@endsection

@section('content')
    <div class="dashboard">
        <div class="container" data-aos="fade-up">
            <div class="row" data-aos="zoom-in" data-aos-delay="100">
                <div class="col-lg-12">
                    <h3>{{__('Frontend.your_account')}}</h3>
                </div>
            </div>
            <div class="row" data-aos="zoom-in" data-aos-delay="100">
                <div class="col-lg-4 col-md-4">
                    <div class="list-box">
                        <a href="{{ route('dashboard.login_password') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16" class="iconify iconify--bi">
                                <path fill="currentColor" d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM11 8a3 3 0 1 1-6 0a3 3 0 0 1 6 0zm2 5.755V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-.245S4 12 8 12s5 1.755 5 1.755z"></path>
                            </svg>
                            <span>{{__('Frontend.login_password')}}</span>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="list-box">
                        <a href="{{ route('dashboard.course_applications') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16" class="iconify iconify--bi">
                                <g fill="currentColor">
                                    <path d="M8.188 10H7V6.5h1.188a1.75 1.75 0 1 1 0 3.5z"></path>
                                    <path d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm5.5 1.5v2a1 1 0 0 0 1 1h2l-3-3zM7 5.5a1 1 0 0 0-1 1V13a.5.5 0 0 0 1 0v-2h1.188a2.75 2.75 0 0 0 0-5.5H7z"></path>
                                </g>
                            </svg>
                            <span>{{__('Frontend.course_application')}}</span>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="list-box">
                        <a href="{{ route('dashboard.reviews') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16" class="iconify iconify--bi">
                                <path fill="currentColor" d="M5.354 5.119L7.538.792A.516.516 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327l4.898.696A.537.537 0 0 1 16 6.32a.548.548 0 0 1-.17.445l-3.523 3.356l.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.52.52 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403a.58.58 0 0 1 .085-.302a.513.513 0 0 1 .37-.245l4.898-.696zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894l-.694-3.957a.565.565 0 0 1 .162-.505l2.907-2.77l-4.052-.576a.525.525 0 0 1-.393-.288L8.001 2.223L8 2.226v9.8z"></path>
                            </svg>
                            <span>{{__('Frontend.your_review')}}</span>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="list-box">
                        <a href="{{ route('dashboard.payments') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16" class="iconify iconify--bi">
                                <path fill="currentColor" d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM11 8a3 3 0 1 1-6 0a3 3 0 0 1 6 0zm2 5.755V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-.245S4 12 8 12s5 1.755 5 1.755z"></path>
                            </svg>
                            <span>{{__('Frontend.your_payments')}}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection