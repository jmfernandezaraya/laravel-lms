@extends('frontend.layouts.app')

@section('title')
    {{__('Frontend.code_and_usage')}}
@endsection

@section('breadcrumbs')
    <div class="breadcrumb-head">
        <a href="{{route('frontend.dashboard')}}" class="breadcrumb-home">
            <i class="bx bxs-dashboard"></i>&nbsp;
        </a>
        <h1>{{__('Frontend.code_and_usage')}}</h1>
    </div>
@endsection

@section('content')
    <div class="dashboard table table-responsive p-2">
        <div class="container" data-aos="fade-up">
            <div class="row" data-aos="zoom-in" data-aos-delay="100">
                <div class="col-md-12">
                    <table class="table table-hover table-bordered table-filtered" width="100%">
                        <thead>
                            <tr>
                                <th>{{ __("Frontend.code") }}</th>
                                <th>{{ __("Frontend.discount") }}</th>
                                <th>{{ __("Frontend.start_date") }}</th>
                                <th>{{ __("Frontend.end_date") }}</th>
                                <th>{{ __("Frontend.type") }}</th>
                                <th>{{ __("Frontend.action") }}</th>
                                <th>{{ __("Frontend.created_on") }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($coupons as $coupon)
                                <tr>
                                    <td>{{ $coupon->code }}</td>
                                    <td>{{ $coupon->discount }}</td>
                                    <td>{{ \Carbon\Carbon::create($coupon->start_date)->format('Y-m-d') }}</td>
                                    <td>{{ \Carbon\Carbon::create($coupon->end_date)->format('Y-m-d') }}</td>
                                    <td>{{ $coupon->type == 'percent' ? __('Frontend.percentage') : __('Frontend.fixed_amount') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('frontend.dashboard.coupon.usage', $coupon->unique_id) }}" class="btn btn-info btn-sm fa fa-pie-chart"></a>
                                        </div>
                                    </td>
                                    <td>{{ $coupon->created_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('load', (event) => {
		    $('table').DataTable({ responsive: true });
		});
    </script>
@endsection