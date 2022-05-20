@extends('superadmin.layouts.app')
@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body table table-responsive">
                <div style="text-align: center;"><h1 class="card-title">@lang('SuperAdmin/backend.visa_form.visa_form_details')</h1></div>
                <a href="{{route('superadmin.add_visa_form')}}" type="button" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i>&nbsp;{{__('SuperAdmin/backend.add')}}</a>
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>

                        <th> @lang('SuperAdmin/backend.visa_form.form_id')</th>
                        <th> @lang('SuperAdmin/backend.visa_form.applied_from')</th>
                        <th> @lang('SuperAdmin/backend.visa_form.application_center')</th>
                        <th> @lang('SuperAdmin/backend.visa_form.nationality')</th>
                        <th> @lang('SuperAdmin/backend.visa_form.travel_to')</th>
                        <th> @lang('SuperAdmin/backend.visa_form.type_of_visa')</th>
                        <th> @lang('SuperAdmin/backend.visa_form.visa_information')</th>
                        <th> @lang('SuperAdmin/backend.visa_form.visa_fee')</th>
                        <th> @lang('SuperAdmin/backend.visa_form.insurance_fee')</th>
                        <th>{{__('SuperAdmin/backend.created_on')}}</th>
                        <th>{{__('SuperAdmin/backend.action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($visaforms as $visaform)

                        <tr>
                            <td>{{$loop->iteration}}</td>
                          <td>{{$visaform->id}}</td>
                            <td>{{$visaform->applyFrom->{'apply_from_' . get_language() } }}</td>
                            <td>{{$visaform->applicationCenter->{'application_center_' .get_language() } }}</td>

                            <td>{{$visaform->nationalityRelation->{'nationality_' .get_language() } }}</td>
                            <td>{{$visaform->whereToTravel->{'travel_' .get_language() } }}</td>
                            <td>{{$visaform->TypeOfVisa->{'visa_' .get_language()} }}</td>
                            <td>{!! $visaform->{'visa_information_'.get_language()} !!}</td>
                            <td>{{$visaform->visa_fee}}</td>
                            <td>{{$visaform->insurance_fee}}</td>
                            <td>{{$visaform->created_at->diffForHumans()}}</td>
                            <td>
                                <div class="btn-group">
                                    <a href  = "{{route('superadmin.visa_form_edit', $visaform->id)}}" class="btn btn-info btn-sm fa fa-pencil"></a>
                                    <form action="{{route('superadmin.delete_visa_forms', $visaform->id)}}" method="post">
                                        @csrf
                                        {{ method_field('delete') }}

                                        <button type="submit" onclick="return confirmDelete()" class="btn btn-danger btn-sm fa fa-trash"></button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>



@endsection
