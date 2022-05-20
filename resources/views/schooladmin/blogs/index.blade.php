@extends('schooladmin.layouts.app')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
<div class="card">
<div class="card-body table table-responsive">
<div style="text-align: center;"><h1 class="card-title">@lang('SuperAdmin/backend.blog_details')</h1></div>
<a href="{{route('blogs.create')}}" type="button" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i>&nbsp;{{__('SuperAdmin/backend.add')}}</a>
<table class="table table-hover table-bordered">
<thead>
<tr>
<th>#</th>
<th> @lang('SuperAdmin/backend.blog_title')</th>
<th> @lang('SuperAdmin/backend.blog_image')</th>
<th> @lang('SuperAdmin/backend.blog_description')</th>
<th>{{__('SuperAdmin/backend.created_on')}}</th>
<th>{{__('SuperAdmin/backend.action')}}</th>
</tr>
</thead>
<tbody>
@foreach($blogs as $blog)

<tr>
<td>{{$loop->iteration   }}</td>
<td>{{ucwords($blog->{'title_' . get_language() } ) }}</td>
<td><img src = "{{asset($blog->image)}}" width = "300px" height = "300px"></td>
<td>{!! ucwords($blog->{'description_'. get_language()} )  !!}</td>
<td>
  {{$blog->created_at}}
</td>

<td>
<div class="btn-group">
<a href  = "{{route('blogs.edit', $blog->id)}}" class="btn btn-info btn-sm fa fa-pencil"></a>
    <form action = "{{route('blogs.destroy', $blog->id)}}" method="POST" >
        @csrf
        @method('DELETE')

<button type="submit"  onclick="return confirmDelete()" class="btn btn-danger btn-sm fa fa-trash"></button>
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
