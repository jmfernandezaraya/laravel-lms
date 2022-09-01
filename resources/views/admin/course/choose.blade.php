@extends('admin.layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{ $title }}</h1>
                </div>

                @include('common.include.alert')
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="card">
            <div class="card-body table table-responsive">
                <form id="courseChooseForm" class="forms-sample" enctype="multipart/form-data" action="{{ route('superadmin.course.choose.update') }}" method="post">
                    {{csrf_field()}}

                    <script>
                        window.addEventListener('load', function() {
                            course_choose_clone = {{$course_chooses && $course_chooses->count() ? $course_chooses->count() - 1 : 0}};
                        }, false );
                    </script>

                    <input hidden id="course_choose_increment" name="course_choose_increment" value="{{ $course_chooses && $course_chooses->count() ? $course_chooses->count() - 1 : 0 }}">
                    <input hidden id="course_choose_type" name="course_choose_type" value="{{ $type }}">
                    
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

                    @forelse ($course_chooses as $course_choose)
                        <div id="course_choose_clone{{$loop->iteration - 1}}" class="course-choose-clone clone">
                            <input type="hidden" value="{{ $course_choose->unique_id }}" type="text" id="choose_id{{ $loop->iteration - 1 }}" name="choose_id[]">
                            <div class="row mt-2">
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input value="{{$course_choose->name}}" class="form-control" type="text" name="name[]" placeholder="{{__('Admin/backend.name')}}">
                                        </div>
                                        <div class="col-md-6">
                                            <input value="{{$course_choose->name_ar}}" class="form-control" type="text" name="name_ar[]" placeholder="{{__('Admin/backend.name')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <i class="fa fa-plus-circle" aria-hidden="true" onclick="addCourseChooseForm($(this))"></i>
                                    <i class="fa fa-minus {{$course_choose->can_delete ? '' : 'hide'}}" aria-hidden="true" onclick="deleteCourseChooseForm($(this))"></i>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div id="course_choose_clone0" class="course-choose-clone clone">
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
                                    <i class="fa fa-plus-circle" aria-hidden="true" onclick="addCourseChooseForm($(this))"></i>
                                    <i class="fa fa-minus" aria-hidden="true" onclick="deleteCourseChooseForm($(this))"></i>
                                </div>
                            </div>
                        </div>
                    @endforelse

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button type="button" onclick="submitForm($(this).parents().find('#courseChooseForm'))" class="btn btn-gradient-primary mr-2">{{__('Admin/backend.submit')}}</button>
                            <a class="btn btn-light" href="{{ url()->previous()}}">{{__('Admin/backend.cancel') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection