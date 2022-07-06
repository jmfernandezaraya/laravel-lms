@extends('branchadmin.layouts.app')

@section('content')
	@section('js')
		<script>
			$(document).ready(function () {
				$('#menu ul li a').click(function (ev) {
					$('#menu ul li').removeClass('selected');
					$(ev.currentTarget).parent('li').addClass('selected');
				});
				$("#myTags").tagit({
					fieldName: "video_url[]"
				});

				$("#myTags1").tagit({
					fieldName: "branch_name[]"
				});

				$("#myTags2").tagit({
					fieldName: "branch_name[]"
				});
			});
			var addschoolurl = "{{route('school.store')}}";
			var in_arabic =  "{{__('Admin/backend.in_arabic')}}";
			var in_english = "{{__('Admin/backend.in_english')}}";
		</script>
	@endsection
	<div class="col-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<center>
					<h4 class="card-title">{{__('Admin/backend.add_school')}}</h4>
					<change>{{__('Admin/backend.in_english')}}</change>
				</center>
				@include('branchcommon.include.alert')
				<div id="menu">
					<ul class="lang text-right current_page_itemm">
						<li class="current_page_item selected">
							<a class="" href="#" onclick="changeLanguage('english', 'arabic')"><img class="pr-2" src="{{asset('public/frontend/assets/img/eng.png')}}" alt="logo">{{__('Admin/backend.english')}}</a>
						</li>
						<li>
							<a href="#" onclick="changeLanguage('arabic', 'english')"; fillForm('form1', 'form2')" >
								<img class="pr-2" src="{{asset('public/frontend/assets/img/ar.png')}}" alt="logo">{{__('Admin/backend.arabic')}}
							</a>
						</li>
					</ul>
				</div>
				<div id="show_form"></div>
				<form id="form1" class="forms-sample" enctype="multipart/form-data" action="{{route('school.store')}}" method="post">
					{{csrf_field()}}
					<div class="form-group">
						<label for="exampleInputName1">{{__('Admin/backend.name')}}</label>
						<input name="name" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('Admin/backend.name')}}" value="{{old('name')}}">
					</div>
					@if($errors->has('name'))
						<div class="alert alert-danger">{{$errors->first('name')}}</div>
					@endif
					<div class="form-group">
						<label for="exampleInputEmail3">{{__('Admin/backend.email_address')}}</label>
						<input value="{{old('email')}}" name="email" type="text" class="form-control" id="exampleInputEmail3" placeholder="{{__('Admin/backend.email_address')}}">
					</div>
					@if($errors->has('email'))
						<div class="alert alert-danger">{{$errors->first('email')}}</div>
					@endif
					<div class="form-group">
						<label for="exampleSelectGender">{{__('Admin/backend.contact_number')}}</label>
						<input value="{{old('contact')}}" name="contact" class="form-control" id="exampleSelectGender" placeholder = "{{__('Admin/backend.contact_number')}}" type="text">
					</div>
					@if($errors->has('contact'))
						<div class="alert alert-danger">{{$errors->first('contact')}}</div>
					@endif
					<div class="form-group">
						<label for="exampleInputName1">{{__('Admin/backend.emergency_number')}}</label>
						<input name="emergency_number" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('Admin/backend.emergency_number')}}" value="{{old('emergency_number')}}">
					</div>
					@if($errors->has('emergency_number'))
						<div class="alert alert-danger">{{$errors->first('emergency_number')}}</div>
					@endif
					<div class="form-group">
						<label for="exampleInputName1">{{__('Admin/backend.branch_name')}}</label>
					</div>
					<ul id="myTags1"></ul>
					@if($errors->has('branch_name'))
						<div class="alert alert-danger">{{$errors->first('branch_name')}}</div>
					@endif
					<div class="form-group">
						<label for="exampleInputName1">{{__('Admin/backend.capacity')}}</label>
						<input name="capacity" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('Admin/backend.capacity')}}" value="{{old('capacity')}}">
					</div>
					@if($errors->has('capacity'))
						<div class="alert alert-danger">{{$errors->first('capacity')}}</div>
					@endif
					<div class="form-group">
						<label for="exampleInputName1">{{__('Admin/backend.facilities')}}</label>
						<textarea name="facilities" class="form-control" id="exampleTextarea1" rows="4">{{old('facilities')}}</textarea>
					</div>
					@if($errors->has('facilities'))
						<div class="alert alert-danger">{{$errors->first('facilities')}}</div>
					@endif
					<div class="form-group">
						<label for="exampleInputName1">{{__('Admin/backend.class_size')}}</label>
						<input name="class_size" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('Admin/backend.class_size')}}" value="{{old('class_size')}}">
					</div>
					@if($errors->has('class_size'))
						<div class="alert alert-danger">{{$errors->first('class_size')}}</div>
					@endif
					<div class="form-group">
						<label for="exampleInputName1">{{__('Admin/backend.year_opened')}}</label>
						<input name="opened" type="text" class="form-control" placeholder="{{__('Admin/backend.year_opened')}}" value="{{old('opened')}}">
					</div>
					@if($errors->has('opened'))
						<div class="alert alert-danger">{{$errors->first('opened')}}</div>
					@endif
					<div class="form-group">
						<label for="exampleInputName1">{{__('Admin/backend.about_the_school')}}</label>
						<textarea name="about" class="form-control" id="exampleTextarea1" rows="4">{{old('about')}}</textarea>
					</div>
					@if($errors->has('about'))
						<div class="alert alert-danger">{{$errors->first('about')}}</div>
					@endif
					<div class="form-group">
						<label for="exampleInputName1">{{__('Admin/backend.address')}}</label>
						<input name="address" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('Admin/backend.address_map_location')}}" value="{{old('address')}}">
					</div>
					@if($errors->has('address'))
						<div class="alert alert-danger">{{$errors->first('address')}}</div>
					@endif
					<div class="form-group">
						<label for="exampleInputName1">{{__('Admin/backend.city')}}</label>
						<input name="city" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('Admin/backend.city')}}" value="{{old('city')}}">
					</div>
					@if($errors->has('city'))
						<div class="alert alert-danger">{{$errors->first('city')}}</div>
					@endif
					<div class="form-group">
						<label for="exampleInputName1">{{__('Admin/backend.country')}}</label>
						<input name="country" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('Admin/backend.country')}}" value="{{old('country')}}">
					</div>
					@if($errors->has('country'))
						<div class="alert alert-danger">{{$errors->first('address')}}</div>
					@endif
					<input hidden name="en" value='1'>
					<div class="form-group">
						<label for="exampleInputName1">{{__('Admin/backend.accreditations_logos')}}</label>
						<input name="logos[]" multiple type="file" class="form-control" id="exampleInputName1" accept = "image/*" >
					</div>
					@if($errors->has('logos'))
						<div class="alert alert-danger">{{$errors->first('logos')}}</div>
					@endif
					<div class="form-group">
						<label for="exampleInputName1">{{__('Admin/backend.logo')}}</label>
						<input name="logo" type="file" class="form-control" id="exampleInputName1" accept = "image/*">
					</div>
					@if($errors->has('logo'))
						<div class="alert alert-danger">{{$errors->first('logo')}}</div>
					@endif
					<div class="form-group">
						<label for="exampleInputName1">{{__('Admin/backend.video')}}</label>
						<ul id="myTags">
						</ul>
					</div>
					@if($errors->has('video_url'))
						<div class="alert alert-danger">{{$errors->first('video_url')}}</div>
					@endif
					<div class="form-group">
						<label for="exampleInputName1">{{__('Admin/backend.photos')}}</label>
						<input name="multiple_photos[]" multiple type="file" class="form-control" id="exampleInputName1" accept = "image/*">
					</div>
					@if($errors->has('multiple_photos'))
						<div class="alert alert-danger">{{$errors->first('multiple_photos')}}</div>
					@endif
					<!-- onclick="submitForm('forms-sample', addschoolurl) -->
					<a class="btn btn-light" href="{{url()->previous()}}">{{__('Admin/backend.cancel')}}</a>
				</form>
				<form id="form2" class="forms-sample" enctype="multipart/form-data" action="{{route('school.store')}}" method="post">
					{{csrf_field()}}
					<div class="form-group">
						<label for="exampleInputName1">{{__('Admin/backend.name')}}</label>
						<input name="name" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('Admin/backend.name')}}" value="{{old('name')}}">
					</div>
					<input type="hidden" name="ar" value='1'>
					@if($errors->has('name'))
						<div class="alert alert-danger">{{$errors->first('name')}}</div>
					@endif
					<div class="form-group">
						<label for="exampleInputEmail3">{{__('Admin/backend.email_address')}}</label>
						<input value="{{old('email')}}" name="email" type="text" class="form-control" id="exampleInputEmail3" placeholder="{{__('Admin/backend.email_address')}}">
					</div>
					@if($errors->has('email'))
						<div class="alert alert-danger">{{$errors->first('email')}}</div>
					@endif
					<div class="form-group">
						<label for="exampleSelectGender">{{__('Admin/backend.contact_number')}}</label>
						<input value="{{old('contact')}}" name="contact" class="form-control" id="exampleSelectGender" placeholder = "{{__('Admin/backend.contact_number')}}" type="text">
					</div>
					@if($errors->has('contact'))
						<div class="alert alert-danger">{{$errors->first('contact')}}</div>
					@endif
					<div class="form-group">
						<label for="exampleInputName1">{{__('Admin/backend.emergency_number')}}</label>
						<input name="emergency_number" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('Admin/backend.emergency_number')}}" value="{{old('emergency_number')}}">
					</div>
					@if($errors->has('emergency_number'))
						<div class="alert alert-danger">{{$errors->first('emergency_number')}}</div>
					@endif
					<div class="form-group" >
						<label for="exampleInputName1">{{__('Admin/backend.branch_name')}}</label>
					</div>
					<ul id="myTags2">
					</ul>
					@if($errors->has('branch_name'))
						<div class="alert alert-danger">{{$errors->first('branch_name')}}</div>
					@endif
					<div class="form-group">
						<label for="exampleInputName1">{{__('Admin/backend.capacity')}}</label>
						<input name="capacity" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('Admin/backend.capacity')}}" value="{{old('capacity')}}">
					</div>
					@if($errors->has('capacity'))
						<div class="alert alert-danger">{{$errors->first('capacity')}}</div>
					@endif
					<div class="form-group">
						<label for="exampleInputName1">{{__('Admin/backend.facilities')}}</label>
						<textarea name="facilities" class="form-control" id="exampleTextarea1" rows="4">{{old('facilities')}}</textarea>
					</div>
					@if($errors->has('facilities'))
						<div class="alert alert-danger">{{$errors->first('facilities')}}</div>
					@endif
					<div class="form-group">
						<label for="exampleInputName1">{{__('Admin/backend.class_size')}}</label>
						<input name="class_size" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('Admin/backend.class_size')}}" value="{{old('class_size')}}">
					</div>
					@if($errors->has('class_size'))
					<div class="alert alert-danger">{{$errors->first('class_size')}}</div>
					@endif
					<div class="form-group">
						<label for="exampleInputName1">{{__('Admin/backend.year_opened')}}</label>
						<input name="opened" type="text" class="form-control" placeholder="{{__('Admin/backend.year_opened')}}" value="{{old('opened')}}">
					</div>
					@if($errors->has('opened'))
						<div class="alert alert-danger">{{$errors->first('opened')}}</div>
					@endif
					<div class="form-group">
						<label for="exampleInputName1">{{__('Admin/backend.about_the_school')}}</label>
						<textarea name="about" class="form-control" id="exampleTextarea1" rows="4">{{old('about')}}</textarea>
					</div>
					@if($errors->has('about'))
						<div class="alert alert-danger">{{$errors->first('about')}}</div>
					@endif
					<div class="form-group">
						<label for="exampleInputName1">{{__('Admin/backend.address')}}</label>
						<input name="address" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('Admin/backend.address_map_location')}}" value="{{old('address')}}">
					</div>
					@if($errors->has('address'))
						<div class="alert alert-danger">{{$errors->first('address')}}</div>
					@endif
					<div class="form-group">
						<label for="exampleInputName1">{{__('Admin/backend.enter_city')}}</label>
						<input name="city" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('Admin/backend.enter_city')}}" value="{{old('city')}}">
					</div>
					@if($errors->has('city'))
						<div class="alert alert-danger">{{$errors->first('city')}}</div>
					@endif
					<div class="form-group">
						<label for="exampleInputName1">{{__('Admin/backend.enter_country')}}</label>
						<input name="country" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('Admin/backend.enter_country')}}" value="{{old('country')}}">
					</div>
					@if($errors->has('country'))
						<div class="alert alert-danger">{{$errors->first('country')}}</div>
					@endif
					<div class="form-group">
						<ul id="myTags"></ul>
					</div>
					@if($errors->has('video_url'))
						<div class="alert alert-danger">{{$errors->first('video_url')}}</div>
					@endif
					<input hidden name="ar" value='1'>
					<!-- onclick="submitForm('forms-sample', addschoolurl) -->
					<button type="button" onclick="submitForm($(this).parents().find('#form2'))" class="btn btn-gradient-primary mr-2">{{__('Admin/backend.submit')}}</button>
					<a class="btn btn-light" href="{{url()->previous()}}">{{__('Admin/backend.cancel')}}</a>
				</form>
			</div>
		</div>
	</div>
@endsection