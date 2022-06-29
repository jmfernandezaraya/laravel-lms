@extends('admin.layouts.app')

@section('title')
    {{__('Admin/backend.dashboard')}}
@endsection

@section('content')
    <div class="row mt-2 mb-5">
        <div class="col-md-12">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                    <i class="mdi mdi-home"></i>
                </span> {{__('Admin/backend.dashboard')}}
            </h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">
                    <img src="{{asset('assets/images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">{{__('Admin/backend.total_schools')}} <i class="mdi mdi-chart-line mdi-24px float-right"></i></h4>
                    @php $school = $school_count ; $school_admin= $super_admin_count; @endphp <h2 class="mb-5">{{$school}} </h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                    <img src="{{asset('assets/images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">{{__('Admin/backend.total_school_admins')}} <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i></h4>
                    <h2 class="mb-5">{{ $school_admin }}</h2>
                </div>
            </div>
        </div>
    </div>
@endsection