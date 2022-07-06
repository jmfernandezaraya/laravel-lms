@extends('admin.layouts.app')

@section('title')
    {{__('Admin/backend.school_names')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('Admin/backend.school_names')}}</h1>
                </div>

                @include('common.include.alert')
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="card">
            <div class="card-body table table-responsive">
                <form id="schoolNameForm" class="forms-sample" enctype="multipart/form-data" action="{{ auth('superadmin')->check() ? route('superadmin.school.name.update') : route('schooladmin.school.name.update') }}" method="post">
                    {{csrf_field()}}

                    <script>
                        window.addEventListener('load', function() {
                            school_name_clone = {{$school_names && $school_names->count() ? $school_names->count() - 1 : 0}};
                        }, false );
                    </script>

                    <input hidden id="school_name_increment" name="school_name_increment" value="{{ $school_names && $school_names->count() ? $school_names->count() - 1 : 0 }}">
                    
                    <div class="row mt-3">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>{{__('Admin/backend.name')}} {{__('Admin/backend.in_english')}}</h4>
                                </div>
                                <div class="col-md-6">
                                    <h4>{{__('Admin/backend.name')}} {{__('Admin/backend.in_arabic')}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    @forelse ($school_names as $school_name)
                        <div id="school_name_clone{{$loop->iteration - 1}}" class="school-name-clone clone">
                            <input type="hidden" value="{{ $school_name->id }}" type="text" id="school_name_id{{ $loop->iteration - 1 }}" name="school_name_id[]">
                            <div class="row mt-2">
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input value="{{$school_name->name}}" class="form-control" type="text" name="name[]" placeholder="{{__('Admin/backend.name')}}">
                                        </div>
                                        <div class="col-md-6">
                                            <input value="{{$school_name->name_ar}}" class="form-control" type="text" name="name_ar[]" placeholder="{{__('Admin/backend.name')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <i class="fa fa-plus-circle" aria-hidden="true" onclick="addSchoolNameForm($(this))"></i>
                                    <i class="fa fa-minus" aria-hidden="true" onclick="deleteSchoolNameForm($(this))"></i>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div id="school_name_clone0" class="school-name-clone clone">
                            <div class="row mt-2">
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" name="name[]" placeholder="{{__('Admin/backend.name')}}">
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" name="name_ar[]" placeholder="{{__('Admin/backend.name')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <i class="fa fa-plus-circle" aria-hidden="true" onclick="addSchoolNameForm($(this))"></i>
                                    <i class="fa fa-minus" aria-hidden="true" onclick="deleteSchoolNameForm($(this))"></i>
                                </div>
                            </div>
                        </div>
                    @endforelse

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button type="button" onclick="submitForm($(this).parents().find('#schoolNameForm'))" class="btn btn-gradient-primary mr-2">{{__('Admin/backend.submit')}}</button>
                            <a class="btn btn-light" href="{{ url()->previous()}}">{{__('Admin/backend.cancel') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection