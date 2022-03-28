@extends('superadmin.layouts.app')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
<div class="card">
<div class="card-body table table-responsive">
<div style="text-align: center;"><h1 class="card-title">{{__('SuperAdmin/backend.school_details')}}</h1></div>
<a href = "{{route('superadmin.schools.create')}}" type="button" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i>&nbsp;{{__('SuperAdmin/backend.add')}}</a>
<table class="table table-hover table-bordered">
<thead>
<tr>
<th>#</th>
<th> {{__('SuperAdmin/backend.school_name')}}</th>
<th> {{__('SuperAdmin/backend.school_email_address')}}</th>
<th> {{__('SuperAdmin/backend.school_contact_number')}}</th>
<th> {{__('SuperAdmin/backend.school_branch_name')}}</th>
<th>{{__('SuperAdmin/backend.city')}}</th>
<th>{{__('SuperAdmin/backend.country')}}</th>
<th>{{__('SuperAdmin/backend.created_on')}}</th>
<th>{{__('SuperAdmin/backend.action')}}</th>
</tr>
</thead>
<tbody>
@foreach($schools as $school)

<tr>
<td>{{$loop->iteration}}</td>
<td>{{ucwords($school->name)}}</td>
<td>{{$school->email}}</td>
<td>{{$school->contact}}</td>
<td>
  {{is_array($school->branch_name) ?  implode(", ", $school->branch_name) : $school->branch_name}}
</td>
<td>{{ucwords($school->city)}}</td>
<td>{{ucwords($school->country)}}</td>
<td>{{$school->created_at->diffForHumans()}}</td>
<td>
<div class="btn-group">
<a href  = "{{route('superadmin.schools.edit', $school->id)}}" class="btn btn-info btn-sm fa fa-pencil"></a>
 <form action="{{route('superadmin.schools.destroy', $school->id)}}" method="post">
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
