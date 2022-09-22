@extends('branchadmin.layouts.app')
@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body table table-responsive">
                <div style="text-align: center;"><h1 class="card-title">@lang('Admin/backend.medical_details')</h1></div>

                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th> @lang('Admin/backend.medical_fees_per_week') </th>
                            <th> @lang('Admin/backend.medical_start_week') </th>
                            <th> @lang('Admin/backend.medical_end_week') </th>
                            <th> {{ucwords( __('Admin/backend.medical_insurance_note')) }} </th>
                            <th> @lang("Admin/backend.created_on") </th>
                            <th> @lang("Admin/backend.action") </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($medicals as  $medical)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$medical->medical_fees_per_week}}</td>
                                <td>{{$medical->medical_start_date}}</td>
                                <td>{{$medical->medical_end_date}}</td>
                                <td>{{$medical->{'medical_insurance_note_'.get_language() } }}</td>
                                <td>{{$medical->created_at->diffForHumans()}}</td>
                                <td>
                                    <div class="btn-group">
                                        <a type="button" data-toggle="modal" data-target="#edit_modal{{$medical->id}}" class="btn btn-sm btn-primary fa fa-pencil" onclick="tinymceInit();"> </a>
                                        @php $confirm = __('Admin/backend.are_you_sure_delete'); @endphp
                                        <a type="button" onclick="return confirm('<?= $confirm ?>')" href="{{route('superadmin.airport_delete', $medical->id)}}" class="btn btn-sm btn-danger fa fa-trash"> </a>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="edit_modal{{$medical->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel5" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel5">@lang('Admin/backend.update_medical_fees')</h5>
                                            <button type="button" id="close_this" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="post" action="{{route('superadmin.medical_update')}}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>@lang('Admin/backend.medical_insurance_note') @lang('Admin/backend.in_english')</label>
                                                    <input hidden name="id" value="{{$medical->id}}">
                                                    <textarea id="textarea_medical_insurance_note_en" name="medical_insurance_note_en" class="form-control">{{$medical->medical_insurance_note_en}}</textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label>@lang('Admin/backend.medical_insurance_note') @lang('Admin/backend.in_arabic')</label>
                                                    <textarea id="textarea_medical_insurance_note_ar" class="form-control">{{$medical->medical_insurance_note_ar}}</textarea>
                                                </div>

                                                <input hidden name="medical_insurance_note_ar" id="input_medical_insurance_note_ar" value="">
                                                <input hidden name="medical_insurance_note_en" value="" id="input_medical_insurance_note_en">
                                                
                                                <div class="form-group">
                                                    <label>@lang('Admin/backend.medical_fees_per_week')</label>
                                                    <input type="number" value="{{$medical->medical_fees_per_week}}" name="medical_fees_per_week" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label>@lang('Admin/backend.medical_start_week')</label>
                                                    <input type="number" name="medical_start_date" value="{{$medical->medical_start_date}}" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label>@lang('Admin/backend.medical_end_week')</label>
                                                    <input type="number" name="medical_end_date" value="{{$medical->medical_end_date}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Admin/backend.close') </button>
                                                <button onclick  ="getContent('textarea_medical_insurance_note_en', 'input_medical_insurance_note_en'); getContent('textarea_medical_insurance_note_ar', 'input_medical_insurance_note_ar') " type="submit" class="btn btn-primary">@lang('Admin/backend.update_changes')</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection