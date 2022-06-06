@extends('superadmin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
						<h1 class="card-title">{{__('SuperAdmin/backend.add_school')}}</h1>
                    <change>
                        <div class="english">
                            {{__('SuperAdmin/backend.in_english')}}
                        </div>
                        <div class="arabic">
                            {{__('SuperAdmin/backend.in_arabic')}}
                        </div>
                    </change>
				</div>

				<div id="menu">
					<ul class="lang text-right current_page_itemm">
						<li class="current_page_item selected">
							<a class="" href="#" onclick="changeLanguage('english', 'arabic')">
								<img class="pr-2" src="{{asset('public/frontend/assets/img/eng.png')}}" alt="logo">{{__('SuperAdmin/backend.english')}}
							</a>
						</li>
						<li>
							<a href="#" onclick="changeLanguage('arabic', 'english')"; fillForm('form1', 'form2')">
								<img class="pr-2" src="{{asset('public/frontend/assets/img/ar.png')}}" alt="logo">{{__('SuperAdmin/backend.arabic')}}
							</a>
						</li>
					</ul>
				</div>

				@include('superadmin.include.alert')
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="card">
            <div class="card-body">
				<form id="form1" class="forms-sample" enctype="multipart/form-data" action="{{route('superadmin.school.store')}}" method="post">
					{{csrf_field()}}

					<div class="row">
						<div class="form-group col-md-12">
							<label for="name">{{__('SuperAdmin/backend.name')}}</label>
							<input name="name" type="text" class="form-control" id="name" placeholder="{{__('SuperAdmin/backend.name')}}" value="{{old('name')}}">
						</div>
					</div>
					@if($errors->has('name'))
						<div class="alert alert-danger">{{$errors->first('name')}}</div>
					@endif

					<div class="row">
						<div class="form-group col-md-12">
							<label for="email">{{__('SuperAdmin/backend.email_address')}}</label>
							<input value="{{old('email')}}" name="email" type="text" class="form-control" id="email" placeholder="{{__('SuperAdmin/backend.email_address')}}">
						</div>
					</div>
					@if($errors->has('email'))
						<div class="alert alert-danger">{{$errors->first('email')}}</div>
					@endif

					<div class="row">
						<div class="form-group col-md-12">
							<label for="contact">{{__('SuperAdmin/backend.contact_number')}}</label>
							<input value="{{old('contact')}}" name="contact" class="form-control" id="contact" placeholder = "{{__('SuperAdmin/backend.contact_number')}}" type="text">
						</div>
					</div>
					@if($errors->has('contact'))
						<div class="alert alert-danger">{{$errors->first('contact')}}</div>
					@endif

					<div class="row">
						<div class="form-group col-md-12">
							<label for="emergency_number">{{__('SuperAdmin/backend.emergency_number')}}</label>
							<input name="emergency_number" type="text" class="form-control" id="emergency_number" placeholder="{{__('SuperAdmin/backend.emergency_number')}}" value="{{old('emergency_number')}}">
						</div>
					</div>
					@if($errors->has('emergency_number'))
						<div class="alert alert-danger">{{$errors->first('emergency_number')}}</div>
					@endif

					<div class="row">
						<div class="form-group col-md-12">
							<label for="branch_name">{{__('SuperAdmin/backend.branch_name')}}</label>
							<input name="branch_name" type="text" class="form-control" id="branch_name" placeholder="{{__('SuperAdmin/backend.branch_name')}}" value="{{old('branch_name')}}">
						</div>
					</div>
					@if($errors->has('branch_name'))
						<div class="alert alert-danger">{{$errors->first('branch_name')}}</div>
					@endif

					<div class="row">
						<div class="form-group col-md-12">
							<label for="capacity">{{__('SuperAdmin/backend.capacity')}}</label>
							<input name="capacity" type="text" class="form-control" id="capacity" placeholder="{{__('SuperAdmin/backend.capacity')}}" value="{{old('capacity')}}">
						</div>
					</div>
					@if($errors->has('capacity'))
						<div class="alert alert-danger">{{$errors->first('capacity')}}</div>
					@endif

					<div class="row">
						<div class="form-group col-md-12">
							<label for="facilities">{{__('SuperAdmin/backend.facilities')}}</label>
							<textarea name="facilities" class="form-control" id="facilities" rows="4">{{old('facilities')}}</textarea>
						</div>
					</div>
					@if($errors->has('facilities'))
						<div class="alert alert-danger">{{$errors->first('facilities')}}</div>
					@endif

					<div class="row">
						<div class="form-group col-md-12">
							<label for="class_size">{{__('SuperAdmin/backend.class_size')}}</label>
							<input name="class_size" type="text" class="form-control" id="class_size" placeholder="{{__('SuperAdmin/backend.class_size')}}" value="{{old('class_size')}}">
						</div>
					</div>
					@if($errors->has('class_size'))
					<div class="alert alert-danger">{{$errors->first('class_size')}}</div>
					@endif

					<div class="row">
						<div class="form-group col-md-12">
							<label for="opened">{{__('SuperAdmin/backend.year_opened')}}</label>
							<input name="opened" type="text" class="form-control" placeholder="{{__('SuperAdmin/backend.year_opened')}}" value="{{old('opened')}}">
						</div>
					</div>
					@if($errors->has('opened'))
						<div class="alert alert-danger">{{$errors->first('opened')}}</div>
					@endif

					<div class="row">
						<div class="form-group col-md-12">
							<label for="about">{{__('SuperAdmin/backend.about_the_school')}}</label>
							<textarea name="about" class="form-control" id="about" rows="4">{{old('about')}}</textarea>
						</div>
					</div>
					@if($errors->has('about'))
						<div class="alert alert-danger">{{$errors->first('about')}}</div>
					@endif

					<div class="row">
						<div class="form-group col-md-12">
							<label for="address">{{__('SuperAdmin/backend.address')}}</label>
							<input name="address" type="text" class="form-control" id="address" placeholder="{{__('SuperAdmin/backend.address_map_location')}}" value="{{old('address')}}">
						</div>
					</div>
					@if($errors->has('address'))
						<div class="alert alert-danger">{{$errors->first('address')}}</div>
					@endif

					<div class="row">
						<div class="form-group col-md-12">
							<label for="city">{{__('SuperAdmin/backend.city')}}</label>
							<input name="city" type="text" class="form-control" id="city" placeholder="{{__('SuperAdmin/backend.city')}}" value="{{old('city')}}">
						</div>
					</div>
					@if($errors->has('city'))
					<div class="alert alert-danger">{{$errors->first('city')}}</div>
					@endif

					<div class="row">
						<div class="form-group col-md-12">
							<label for="country">{{__('SuperAdmin/backend.country')}}</label>
							<input name="country" type="text" class="form-control" id="country" placeholder="{{__('SuperAdmin/backend.country')}}" value="{{old('country')}}">
						</div>
					</div>
					@if($errors->has('country'))
						<div class="alert alert-danger">{{$errors->first('address')}}</div>
					@endif

					<input hidden name="en" value='1'>

					<div class="row">
						<div class="form-group col-md-12">
							<label for="logos">{{__('SuperAdmin/backend.accreditations_logos')}}</label>
							<input name="logos[]" multiple type="file" class="form-control" id="logos" accept = "image/*">
						</div>
					</div>
					@if($errors->has('logos'))
						<div class="alert alert-danger">{{$errors->first('logos')}}</div>
					@endif

					<div class="row">
						<div class="form-group col-md-12">
							<label for="logo">{{__('SuperAdmin/backend.logo')}}</label>
							<input name="logo" type="file" class="form-control" id="file" accept = "image/*">
						</div>
					</div>
					@if($errors->has('logo'))
						<div class="alert alert-danger">{{$errors->first('logo')}}</div>
					@endif

					<div class="row">
						<div class="form-group col-md-12">
							<label for="video">{{__('SuperAdmin/backend.video')}}</label>
							<ul id="video"></ul>
						</div>
					</div>
					@if($errors->has('video_url'))
						<div class="alert alert-danger">{{$errors->first('video_url')}}</div>
					@endif

					<div class="row">
						<div class="form-group col-md-12">
							<label for="multiple_photos">{{__('SuperAdmin/backend.photos')}}</label>
							<input name="multiple_photos[]" multiple type="file" class="form-control" id="multiple_photos" accept = "image/*">
						</div>
					</div>

					@if($errors->has('multiple_photos'))
						<div class="alert alert-danger">{{$errors->first('multiple_photos')}}</div>
					@endif

					<a class="btn btn-light" href="{{url()->previous()}}">{{__('SuperAdmin/backend.cancel')}}</a>
				</form>

				<form id="form2" class="forms-sample" enctype="multipart/form-data" action="{{route('superadmin.school.store')}}" method="post">
					{{csrf_field()}}
					<div class="row">
						<div class="form-group col-md-12">
							<label for="name">{{__('SuperAdmin/backend.name')}}</label>
							<input name="name" type="text" class="form-control" id="name" placeholder="{{__('SuperAdmin/backend.name')}}" value="{{old('name')}}">
						</div>
					</div>
					@if($errors->has('name'))
						<div class="alert alert-danger">{{$errors->first('name')}}</div>
					@endif

					<input type="hidden" name="ar" value='1'>

					<div class="row">
						<div class="form-group col-md-12">
							<label for="email">{{__('SuperAdmin/backend.email_address')}}</label>
							<input value="{{old('email')}}" name="email" type="text" class="form-control" id="email" placeholder="{{__('SuperAdmin/backend.email_address')}}">
						</div>
					</div>
					@if($errors->has('email'))
						<div class="alert alert-danger">{{$errors->first('email')}}</div>
					@endif
					
					<div class="row">
						<div class="form-group col-md-12">
							<label for="contact">{{__('SuperAdmin/backend.contact_number')}}</label>
							<input value="{{old('contact')}}" name="contact" class="form-control" id="contact" placeholder = "{{__('SuperAdmin/backend.contact_number')}}" type="text">
						</div>
					</div>
					@if($errors->has('contact'))
						<div class="alert alert-danger">{{$errors->first('contact')}}</div>
					@endif

					<div class="row">
						<div class="form-group col-md-12">
							<label for="emergency_number">{{__('SuperAdmin/backend.emergency_number')}}</label>
							<input name="emergency_number" type="text" class="form-control" id="emergency_number" placeholder="{{__('SuperAdmin/backend.emergency_number')}}" value="{{old('emergency_number')}}">
						</div>
					</div>
					@if($errors->has('emergency_number'))
						<div class="alert alert-danger">{{$errors->first('emergency_number')}}</div>
					@endif

					<div class="row">
						<div class="form-group col-md-12">
							<label for="branch_name">{{__('SuperAdmin/backend.branch_name')}}</label>
							<input name="branch_name" type="text" class="form-control" id="branch_name" placeholder="{{__('SuperAdmin/backend.branch_name')}}" value="{{old('branch_name')}}">
						</div>
					</div>
					@if($errors->has('branch_name'))
						<div class="alert alert-danger">{{$errors->first('branch_name')}}</div>
					@endif

					<div class="row">
						<div class="form-group col-md-12">
							<label for="capacity">{{__('SuperAdmin/backend.capacity')}}</label>
							<input name="capacity" type="text" class="form-control" id="capacity" placeholder="{{__('SuperAdmin/backend.capacity')}}" value="{{old('capacity')}}">
						</div>
					</div>
					@if($errors->has('capacity'))
						<div class="alert alert-danger">{{$errors->first('capacity')}}</div>
					@endif

					<div class="row">
						<div class="form-group col-md-12">
							<label for="facilities">{{__('SuperAdmin/backend.facilities')}}</label>
							<textarea name="facilities" class="form-control" id="facilities" rows="4">{{old('facilities')}}</textarea>
						</div>
					</div>
					@if($errors->has('facilities'))
						<div class="alert alert-danger">{{$errors->first('facilities')}}</div>
					@endif

					<div class="row">
						<div class="form-group col-md-12">
							<label for="class_size">{{__('SuperAdmin/backend.class_size')}}</label>
							<input name="class_size" type="text" class="form-control" id="class_size" placeholder="{{__('SuperAdmin/backend.class_size')}}" value="{{old('class_size')}}">
						</div>
					</div>
					@if($errors->has('class_size'))
						<div class="alert alert-danger">{{$errors->first('class_size')}}</div>
					@endif

					<div class="row">
						<div class="form-group col-md-12">
							<label for="opened">{{__('SuperAdmin/backend.year_opened')}}</label>
							<input name="opened" type="text" class="form-control" placeholder="{{__('SuperAdmin/backend.year_opened')}}" value="{{old('opened')}}">
						</div>
					</div>
					@if($errors->has('opened'))
						<div class="alert alert-danger">{{$errors->first('opened')}}</div>
					@endif

					<div class="row">
						<div class="form-group col-md-12">
							<label for="about">{{__('SuperAdmin/backend.about_the_school')}}</label>
							<textarea name="about" class="form-control" id="about" rows="4">{{old('about')}}</textarea>
						</div>
					</div>
					@if($errors->has('about'))
						<div class="alert alert-danger">{{$errors->first('about')}}</div>
					@endif

					<div class="row">
						<div class="form-group col-md-12">
							<label for="address">{{__('SuperAdmin/backend.address')}}</label>
							<input name="address" type="text" class="form-control" id="address" placeholder="{{__('SuperAdmin/backend.address_map_location')}}" value="{{old('address')}}">
						</div>
					</div>
					@if($errors->has('address'))
						<div class="alert alert-danger">{{$errors->first('address')}}</div>
					@endif

					<div class="row">
						<div class="form-group col-md-12">
							<label for="city">{{__('SuperAdmin/backend.enter_city')}}</label>
							<input name="city" type="text" class="form-control" id="city" placeholder="{{__('SuperAdmin/backend.enter_city')}}" value="{{old('city')}}">
						</div>
					</div>
					@if($errors->has('city'))
						<div class="alert alert-danger">{{$errors->first('city')}}</div>
					@endif

					<div class="row">
						<div class="form-group col-md-12">
							<label for="country">{{__('SuperAdmin/backend.enter_country')}}</label>
							<input name="country" type="text" class="form-control" id="country" placeholder="{{__('SuperAdmin/backend.enter_country')}}" value="{{old('country')}}">
						</div>
					</div>
					@if($errors->has('country'))
						<div class="alert alert-danger">{{$errors->first('country')}}</div>
					@endif
					<div class="row">
						<div class="form-group col-md-12">
							<ul id="myTags"></ul>
						</div>
					</div>
					@if($errors->has('video_url'))
						<div class="alert alert-danger">{{$errors->first('video_url')}}</div>
					@endif

					<input hidden name="ar" value='1'>

					<button type="button" onclick="submitForm(addschoolurl)" class="btn btn-gradient-primary mr-2">{{__('SuperAdmin/backend.submit')}}</button>
					<a class="btn btn-light" href="{{url()->previous()}}">{{__('SuperAdmin/backend.cancel')}}</a>
				</form>
			</div>
		</div>
	</div>
@endsection