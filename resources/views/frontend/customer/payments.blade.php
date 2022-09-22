@extends('frontend.layouts.app')

@section('title')
    {{__('Frontend.your_payments')}}
@endsection

@section('breadcrumbs')
    <div class="breadcrumb-head">
        <a href="{{route('frontend.dashboard')}}" class="breadcrumb-home">
            <i class="bx bxs-dashboard"></i>&nbsp;
        </a>
        <h1>{{__('Frontend.your_payments')}}</h1>
    </div>
@endsection

@section('content')
    <div class="dashboard table table-responsive p-2">
        <div class="container" data-aos="fade-up">
            <div class="row" data-aos="zoom-in" data-aos-delay="100">
                <table class="table table-hover table-bordered table-filtered" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __("Frontend.created_on") }}</th>
                            <th>{{ __("Frontend.cart_id") }}</th>
                            <th>{{ __("Frontend.order_id") }}</th>
                            <th>{{ __("Frontend.amount") }}</th>
                            <th>{{ __("Frontend.action") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($course_applications as $course_application)
                            @if($course_application->transaction)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $course_application->transaction->created_at }}</td>
                                    <td>{{ $course_application->transaction->cart_id }}</td>
                                    <td>{{ $course_application->transaction->order_id }}</td>
                                    <td>{{ $course_application->transaction->amount }}</td>

                                    <td>
                                        <div class="btn-group">
                                            <a href="{{route('frontend.dashboard.payment', $course_application->id)}}">
                                                <button type="button" class="btn btn-primary float-right px-3">
                                                    {{__('Frontend.review')}}
                                                </button>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('load', (event) => {
		    $('table').DataTable({ responsive: true });
		});
    </script>
@endsection