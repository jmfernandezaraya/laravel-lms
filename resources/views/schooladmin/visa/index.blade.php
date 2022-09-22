@extends('admin.layouts.app')
@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body table table-responsive">
                <div style="text-align: center;"><h1 class="card-title">@lang('Admin/backend.formbuilder.form_details')</h1></div>

                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th> @lang('Admin/backend.formbuilder.form_name')</th>
                            <th>{{__('Admin/backend.created_on')}}</th>
                            <th>{{__('Admin/backend.action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($forms as $form)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ucwords($form->form_name)}}</td>
                                <td>{{$form->created_at->diffForHumans()}}</td><td>
                                    <div class="btn-group">
                                        <a href="{{route('visa.edit', $form->id)}}" class="btn btn-info btn-sm fa fa-pencil"></a>
                                        <form action="{{route('visa.destroy', $form->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
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
