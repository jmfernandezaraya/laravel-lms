@extends('superadmin.layouts.app')
@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body table table-responsive">
                <div style="text-align: center;"><h1 class="card-title">@lang('SuperAdmin/backend.visa_application.application_details')</h1></div>

                <table class="table table-hover table-bordered">
                    <thead>

                    <tr>

                        <th>#</th>
                        <th>Name</th>
                        <th>Values</th>


                    </tr>

                    </thead>
                    <tbody>
                    @foreach($other_fields as $other_field)
                        @if($other_field->value != null)
                        <tr>

                            <td>{{$loop->iteration}}</td>

                            <?php
                            $exp = false;
                            if($other_field->value != null){
                            $exp = str_contains( $other_field->value, ".png") || str_contains( $other_field->value, ".jpeg") || str_contains( $other_field->value, ".jpg")

                                || str_contains( $other_field->value, ".pdf") || str_contains( $other_field->value, ".gif")  || str_contains( $other_field->value, ".bmp")? true : false;

                            }
                            ?>

                            <td>{{ucwords(str_replace("_", " ", $other_field->name))}}</td>
                            <td>{!!  $exp ?  "<a href=".asset('storage/app/visa_related_files/'. (string)$other_field->value)."> Click Here  </a>"  : $other_field->value !!}</td>

                        </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>



@endsection
