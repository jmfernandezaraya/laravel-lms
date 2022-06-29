<?php

namespace App\Classes;

use Validator;
use Session;
use DB;
use Storage;

use App\Models\User;
use App\Models\SuperAdmin\School;

class StoreClass {
	private $image, $request, $type_of_request, $id;
	
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}
	
	public function setTypeOfRequest($type) {
		$this->type_of_request  = $type; 
		return $this;
	}
	
	public function setImage($image) {
		$this->image = $image;
		return $this;
	}
	
	public function setRequest($request) {
		$this->request = $request;
		return $this;
	}

	public function saveToModelSchoolAdmin() {
		try {
			//Starting If condition form the form english
			if($this->request->has('en')) {
				if(!isset($this->type_of_request)) {
					$rules=  [
						'email' => 'required|unique:users_en',
						'first_name' =>'required',
						'unique_id' => 'unique:users_en',
						'password' =>'required'
					];
				} else {
					$user_en = \DB::table("users_en")->whereUniqueId($this->id)->first();
					$rules=  [
						'email' => 'required|unique:users_en,' . 'id,' . $user_en->id,	
						'first_name' =>'required',
						'unique_id' => 'unique:users_en'. 'id,' . $user_en->id
					];
				}
				
				$input = $this->request->except('_token', 'en');
				$input['image'] = $this->image;
				$validator = Validator::make($this->request->all(), $rules);
				if ($validator->fails()) {
					return response()->json(['errors' => $validator->getMessageBag()->toArray(), 'success' => false]);
				}
				$school = new User;
				$school = $school->setTable('users_en');
				$school = isset($this->type_of_request) && $this->type_of_request == 'update' ? $school->whereUniqueId($this->id)->first() : $school;
				$input['password']= \Hash::make($input['password']);
				$lastname = isset($input['last_name'])? $input['last_name'] : '';
				$name = array($input['first_name'], $lastname);
				$name = implode(", ", $name);
				$input['name'] = $name;
				$input['unique_id'] = $this->my_unique_id();
				$input['user_type'] = 'school_admin';
				\Cache::put('db1', $school, $seconds = 10);
				\Cache::put('input1', $input, $seconds = 10);
				//Session::put('db1', $school);
				//Session::put('input1', $input);
				
				$data['success'] = true;
				$data['data'] =__('Admin/backend.data_saved_successfully');
				return response()->json($data);
			}
			
			//Starting If condition form the form arabic
			if ($this->request->has('ar')) {
				if (!isset($this->type_of_request)) {
					$rules=  [
						'first_name' =>'required',
						'unique_id' => 'unique:users_ar',
					];
				} else {
					$user_ar = \DB::table("users_ar")->whereUniqueId($this->id)->first();
					$rules=  [
						'email' => 'unique:users_ar,' . 'id,' . $user_ar->id,
						'first_name' =>'required',
					];
				}
				
				$validator = Validator::make($this->request->all(), $rules);
				if ($validator->fails()) {
					return response()->json(['errors' => $validator->getMessageBag()->toArray(), 'success' => false]);
				}
				$input = $this->request->except('_token', 'ar');
				$input['image'] = $this->image;
				$school = new User;
				$school = $school->setTable('users_ar');
				$school = isset($this->type_of_request) ? $school->whereUniqueId($this->id)->first() : $school;
				$input['password']= null;
				$lastname = isset($input['last_name'])? $input['last_name'] : '';
				$name = array($input['first_name'], $lastname);
				$name = implode(", ", $name);
				$input['name'] = $name;
				$input['user_type'] = 'school_admin';
				$input['unique_id'] =$this->my_unique_id();
				
				//Session::put('db2', $school);
				//Session::put('input2', $input);
				\Cache::put('db2', $school, $seconds = 10);
				\Cache::put('input2', $input, $seconds = 10);
				$save = $school->save_model(\Cache::get('db1'), \Cache::get('db2'), \Cache::get('input1'), \Cache::get('input2'));
				if($save){
					$this->my_unique_id(1);
					$data['success'] = true;
					$data['data'] = __('Admin/backend.data_saved_successfully');
					return response()->json($data);
				}
				$data['errors'] = 'Soime';
				return response()->json($data);
			}
		} catch(\Exception $e) {
			$data['catch_error'] = $e->getMessage();
			
			return response()->json($data);
		}
	}
	
	public function saveToModelSchool() {
		try {
			ini_set('max_execution_time', 999999999999);
			
			$unique_id =  isset($this->type_of_request) ? $this->id : $this->my_unique_id();
			if ($this->request->has('en')) {
				if(!isset($this->type_of_request))
				{
					$rules = [
						'email' => 'required|unique:schools_en',
						'name' => 'required',
						'address' => 'required',
						'contact' => 'required',
						'multiple_photos.*' => 'mimes:jpg,bmp,png,jpeg',
						'logo' => 'mimes:jpg,bmp,png,jpeg',
						'video.*' => 'mimes:mp4,asf,wmv,mpeg,3gp,avi,flv',
						'logos.*' => 'mimes:jpg,bmp,png,jpeg'
					];
					// return response()->json(['errors' => $this->request->all()]);
				}else{
					$school = \DB::table("schools_en")->whereUniqueId($this->id)->first();
					$rules = [
						'email' => 'required|unique:schools_en,' . 'id,' . $school->id,
						'name' => 'required',
						'address' => 'required',
						'contact' => 'required',
						'multiple_photos.*' => 'mimes:jpg,bmp,png,jpeg',
						'logo' => 'mimes:jpg,bmp,png,jpeg',
						'video.*' => 'mimes:mp4,asf,wmv,mpeg,3gp,avi,flv',
						'logos.*' => 'mimes:jpg,bmp,png,jpeg'
					];
				}

				$validator = Validator::make($this->request->all(), $rules);
				if ($validator->fails()) {
					return response()->json(['errors' => $validator->getMessageBag()->toArray(), 'success' => false]);
				}

				$input = $this->request->except('_token', 'en');
				$schools = new School;
				$schools = $schools->setTable('schools_en');
				$schools = isset($this->type_of_request) && $this->type_of_request == 'update' ? $schools->whereUniqueId($this->id)->first() : $schools;
				
				/* Saving Logo Here */
				if ($this->request->has('logo') && $this->request->logo != null) {
					if(isset($this->type_of_request)){
						Storage::delete('public/school_images/'. $schools->logo);
					}
					$image = Storage::disk('local')->put('public/school_images/', $this->request->logo);
					$image1 = explode('school_images//', $image);
					$logo1 = $image1[1];
					$input['logo'] = $logo1;
					Session::put('logo', $logo1);
				}
				
				/* Saving Logo Here */
				/* Saving Multiple Photos Here */
				$multiple_photos = [];
				if ($this->request->multiple_photos && $this->request->multiple_photos != null) {
					foreach ($this->request->multiple_photos as $multiple_photoss) {
						Storage::delete('public/school_images/'. $multiple_photoss);
						$imageee = Storage::disk('public')->put('school_images/', $multiple_photoss);
						$imageees = explode('school_images//', $imageee);
						$multiple_photos[] = $imageees[1];
						Session::put('multiple_photos', $multiple_photos);
					}
					$input['multiple_photos'] = $multiple_photos;
				}
				
				/* Saving Multiple Photos Here */
				if (isset($this->type_of_request) && $this->type_of_request == 'update' && $this->request->logos && $this->request->logos != null) {
					if(is_array($schools->logos)) {
						foreach($schools->logos as $videos){
							//Deleting previous videos if present to save the storage space
							Storage::delete('public/school_images/'. $videos);
						}
					}
				}
					
				/* Saving Multiple Logos Here */
				$logos = [];
				$input['unique_id'] = $unique_id;
				if ($this->request->logos && $this->request->logos != null) {
					foreach ($this->request->logos as $logoss) {
						$logo = Storage::disk('public')->put('school_images/', $logoss);
						$logo = explode('school_images//', $logo);
						$logos[] = $logo[1];
						Session::put('logos', $logos);
						
					}
					$input['logos'] = $logos;
				}

				\Cache::put('db1', $schools, $seconds = 10);
				\Cache::put('input1', $input, $seconds = 10);
									
				$data['success'] = true;
				$data['data'] = __('Admin/backend.data_saved_successfully');
				return response()->json($data);
			}

			if ($this->request->has('ar')) {
				if(!isset($this->type_of_request)) {
					$rules = [
						'email' => 'required|unique:schools_ar',
						'name' => 'required',
						'address' => 'required',
						'contact' => 'required'
					];
				} else {
					$school = \DB::table("schools_ar")->whereUniqueId($this->id)->first();
					$rules = [
						'email' => 'required|unique:schools_ar,' . 'id,' . $school->id,
						'name' => 'required',
						'address' => 'required',
						'contact' => 'required',
					];
				}
				
				$validator = Validator::make($this->request->all(), $rules);
				if ($validator->fails()) {
					return response()->json(['errors' => $validator->getMessageBag()->toArray(), 'success' => false]);
				}					
				
				$input = $this->request->except('_token', 'ar');
				$input['multiple_photos'] = Session::get('multiple_photos');
				$input['video'] = Session::get('video');
				$input['logos'] = Session::get('logos');
				$input['logo'] = Session::get('logo');
				$input['unique_id'] = $unique_id;

				$schools = new School;
				$schools = $schools->setTable('schools_ar');
				$schools = isset($this->type_of_request) && $this->type_of_request == 'update' ? $schools->whereUniqueId($this->id)->first() : $schools;
				\Cache::put('db2', $schools, $seconds = 10);
				\Cache::put('input2', $input, $seconds = 10);
				
				$save3 = $schools->save_model(\Cache::get('db1'), \Cache::get('db2'), \Cache::get('input1'), \Cache::get('input2'));
				if ($save3) {
					$this->my_unique_id(1);
				
					Session::forget('video');
					Session::forget('multiple_photos');
					Session::forget('logos');
					Session::forget('logo');
					
					$data['success'] = true;
					$data['data'] = __('Admin/backend.data_saved_successfully');
					
					return response()->json($data);	
				}
			}
		} catch (\Exception $e) {
			$data['catch_error'] = $e->getMessage();
			return response()->json($data);
		}
	}

	private function my_unique_id($forget=null) {
		if ($forget == null) {
			if (!Session::has('unique_id_time'))
			{
				Session::put('unique_id_time', time());
			}
			return Session::get('unique_id_time');
		} else {
			return Session::forget('unique_id_time');
		}
	}
}
?>