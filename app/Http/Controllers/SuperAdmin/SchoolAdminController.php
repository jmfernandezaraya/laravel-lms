<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Classes\StoreClass;

use App\Http\Controllers\Controller;

use App\Models\City;
use App\Models\Country;
use App\Models\SchoolAdmin;
use App\Models\User;
use App\Models\SuperAdmin\School;
use App\Models\SuperAdmin\UserSchool;

use Illuminate\Http\Request;

use DB;
use Image;
use Storage;

class SchoolAdminController extends Controller
{
    function index()
    {
        $school_admins = User::where('user_type', 'school_admin')->orWhere('user_type', 'branch_admin')->get();

        return view('superadmin.school_admin.index', compact('school_admins'));
    }

    function create()
    {
        $schools = School::where('is_active', true)->get();
        $choose_branches = [];
        $choose_schools = [];
        foreach ($schools as $school) {
            if (app()->getLocale() == 'en') {
                if ($school->branch_name) {
                    $choose_branches[] = $school->branch_name;
                }
                if ($school->name && $school->name->name) {
                    $choose_schools[] = $school->name->name;
                }
            } else {
                if ($school->branch_name_ar) {
                    $choose_branches[] = $school->branch_name_ar;
                }
                if ($school->name && $school->name->name_ar) {
                    $choose_schools[] = $school->name->name_ar;
                }
            }
        }
        $choose_schools = array_unique($choose_schools);

        return view('superadmin.school_admin.add', compact('choose_schools', 'choose_branches'));
    }

    function store(Request $request)
    {
        $rules = [
            'first_name_en' => 'required',
            'first_name_ar' => 'required',
            'last_name_en' => 'required',
            'last_name_ar' => 'required',
            'password' => 'required',
            'school_name' => 'required',
            'email' => 'required|unique:users',
            'contact' => 'required',
            'image' => 'mimes:jpg,jpeg,png,bmp',
            'country' => 'sometimes',
            'city' => 'sometimes',
        ];

        $validator = \Validator::make($request->all(), $rules, [
            'first_name_en.required' => __('SuperAdmin/backend.errors.first_name_english'),
            'first_name_ar.required' => __('SuperAdmin/backend.errors.first_name_arabic'),
            'last_name_ar.required' => __('SuperAdmin/backend.errors.last_name_arabic'),
            'last_name_en.required' => __('SuperAdmin/backend.errors.last_name_english'),
            'password.required' => __('SuperAdmin/backend.errors.password_required'),
            'image.required' => __('SuperAdmin/backend.errors.image_required'),
            'contact.required' => __('SuperAdmin/backend.errors.contact_required'),
            'email.required' => __('SuperAdmin/backend.errors.email_required'),
            'image.mimes' => __('SuperAdmin/backend.errors.image_must_be_in'),
            'school_name.required' => 'School Name is Required']);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $requested_save = $validator->validated();
        unset($requested_save['image']);
        unset($requested_save['school_name']);
        unset($requested_save['can_delete_course']);
        unset($requested_save['can_add_course']);
        unset($requested_save['can_edit_course']);

        $user_type = 'school_admin';
        if (!is_null($request->city) && !is_null($request->country) && !is_null($request->branch)) {
            $user_type = "branch_admin";
        }
        $image_name = null;
        if ($request->has('image')) {
            $image = $request->file('image');

            $filename = time() . rand(00, 99) . \Str::random(10) . '.webp';
            Image::make($image)->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save(public_path('images/user_images/' . $filename));
            $image_name = 'public/images/user_images/' . $filename;
        }
        
        $language = app()->getLocale();
        $school_ids = School::where('is_active', true)->whereHas('name', function($query) use ($request, $language)
            { $language ? $query->where('name', $request->school_name) : $query->where('name_ar', $request->school_name); })->pluck('id')->toArray();
        $requested_save['school'] = $school_ids;
        if ($language == 'en') {
            $requested_save['branch'] = $request->branch ?? [];
            $requested_save['branch_ar'] = School::whereIn('branch_name', $request->branch ?? [])->pluck('branch_name_ar')->toArray();
        } else {
            $requested_save['branch_ar'] = $request->branch ?? [];
            $requested_save['branch'] = School::whereIn('branch_name_ar', $request->branch ?? [])->pluck('branch_name')->toArray();
        }
        \DB::transaction(function () use ($request, $requested_save, $image_name, $user_type) {
            $user = User::create($requested_save + ['user_type' => $user_type, 'image' => $image_name, 'password' => \Hash::make($request->password)]);
            if (auth('superadmin')->user()->permission['user_manager'] || auth('superadmin')->user()->permission['user_permission']) {
                $user->editCoursePermission()->create([
                    'delete' => $request->can_delete_course ?? 0,
                    'add' => $request->can_add_course ?? 0,
                    'edit' => $request->can_edit_course ?? 0]
                );
            }
            if ($user->school && is_array($user->school)) {
                foreach ($user->school as $user_school_id) {
                    $user_school = UserSchool::where('user_id', $user->id)->where('school_id', $user_school_id)->first();
                    if (!$user_school) {
                        $new_user_school = new UserSchool;
                        $new_user_school->user_id = $user->id;
                        $new_user_school->school_id = $user_school_id;
                        $new_user_school->save();
                    }
                }
            }
            $user_schools = UserSchool::where('user_id', $user->id)->get();
            foreach ($user_schools as $user_school) {
                if (!in_array($user_school->id, is_array($user->school) ? $user->school : [])) {
                    $user_school->delete();
                }
            }
        });

        $saved = __('SuperAdmin/backend.data_saved_successfully');
        return response()->json(['success' => true, 'data' => $saved]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    function destroy($id)
    {
        $deleted = User::find($id);
        if (file_exists($deleted->image)) {
            unlink($deleted->image);
        }

        $deleted = $deleted->delete();
        if ($deleted) {
            toastr()->success('Deleted Successfully');
            return back();
        }
    }

    function edit($id)
    {
        $school_admin = User::find($id);
        
        $schools = School::where('is_active', true)->get();
        $choose_schools = [];
        foreach ($schools as $school) {
            $school_country_ids[] = $school->country_id;
            $school_city_ids[] = $school->city_id;
            if (app()->getLocale() == 'en') {
                if ($school->name && $school->name->name) {
                    $choose_schools[] = $school->name->name;
                }
            } else {
                if ($school->name && $school->name->name_ar) {
                    $choose_schools[] = $school->name->name_ar;
                }
            }
        }
        $choose_schools = array_unique($choose_schools);
        $school_country_ids = [];
        $school_city_ids = [];
        $choose_branches = [];
        $school_name = '';
        $schools = School::where('is_active', true)->whereIn('id', $school_admin->school ?? [])->get();
        foreach ($schools as $school) {
            $school_country_ids[] = $school->country_id;
            $school_city_ids[] = $school->city_id;
            if (app()->getLocale() == 'en') {
                if ($school->name && $school->name->name) {
                    $school_name = $school->name->name;
                }
                if ($school->branch_name) {
                    $choose_branches[] = $school->branch_name;
                }
            } else {
                if ($school->name && $school->name->name) {
                    $school_name = $school->name->name;
                }
                if ($school->branch_name_ar) {
                    $choose_branches[] = $school->branch_name_ar;
                }
            }
        }
        $choose_countries = Country::whereIn('id', $school_country_ids)->orderBy('id', 'asc')->get();
        $choose_cities = City::whereIn('id', $school_city_ids)->orderBy('id', 'asc')->get();

        return view('superadmin.school_admin.edit', compact('school_admin', 'choose_schools', 'school_name', 'choose_countries', 'choose_cities', 'choose_branches'));
    }

    function update(Request $request, $id)
    {
        $user = User::find($id);
        
        $rules = [
            'first_name_en' => 'required',
            'first_name_ar' => 'required',
            'last_name_en' => 'required',
            'last_name_ar' => 'required',
            'email' => 'required',
            'contact' => 'required',
            'image' => 'mimes:jpg,jpeg,png,bmp',
            'school_name' => 'required',
            'country' => 'sometimes',
            'city' => 'sometimes',
        ];

        $validator = \Validator::make($request->all(), $rules, [
            'first_name_en.required' => __('SuperAdmin/backend.errors.first_name_english'),
            'first_name_ar.required' => __('SuperAdmin/backend.errors.first_name_arabic'),
            'last_name_ar.required' => __('SuperAdmin/backend.errors.last_name_arabic'),
            'last_name_en.required' => __('SuperAdmin/backend.errors.last_name_english'),
            'image.required' => __('SuperAdmin/backend.errors.image_required'),
            'contact.required' => __('SuperAdmin/backend.errors.contact_required'),
            'email.required' => __('SuperAdmin/backend.errors.email_required'),
            'image.mimes' => __('SuperAdmin/backend.errors.image_must_be_in'),
            'school_name.required' => 'School Name is Required']);

        $password = $request->has('password') ? \Hash::make($request->password) : null;
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        
        $requested_save = $validator->validated();
        unset($requested_save['image']);
        unset($requested_save['school_name']);
        unset($requested_save['can_delete_course']);
        unset($requested_save['can_add_course']);
        unset($requested_save['can_edit_course']);

        $image_name = null;
        if ($request->has('image')) {
            $image = $request->file('image');

            $filename = time() . rand(00, 99) . \Str::random(10) . '.webp';
            Image::make($image)->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save(public_path('images/user_images/' . $filename));
            $image_name = 'public/images/user_images/' . $filename;
        }

        $language = app()->getLocale();
        $school_ids = School::where('is_active', true)->whereHas('name', function($query) use ($request, $language)
            { $language ? $query->where('name', $request->school_name) : $query->where('name_ar', $request->school_name); })->pluck('id')->toArray();
        $requested_save['school'] = $school_ids;
        if ($language == 'en') {
            $requested_save['branch'] = $request->branch ?? [];
            $requested_save['branch_ar'] = School::whereIn('branch_name', $request->branch ?? [])->pluck('branch_name_ar')->toArray();
        } else {
            $requested_save['branch_ar'] = $request->branch ?? [];
            $requested_save['branch'] = School::whereIn('branch_name_ar', $request->branch ?? [])->pluck('branch_name')->toArray();
        }

        $course['can_add_course'] = $request->can_add_course ?? false;
        $course['can_edit_course'] = $request->can_edit_course ?? false;
        $course['can_delete_course'] = $request->can_delete_course ?? false;

        if ($request->has('password')) {
            $user->fill($requested_save + ['user_type' => 'school_admin', 'image' => $image_name, 'password' => $password])->save();
        } else {
            $user->fill($requested_save + ['user_type' => 'school_admin', 'image' => $image_name])->save();
        }
        if (auth('superadmin')->user()->permission['user_manager'] || auth('superadmin')->user()->permission['user_permission']) {
            $user->editCoursePermission()->updateOrCreate(['user_id' => $user->id], [
                'delete' => $request->can_delete_course ?? 0,
                'add' => $request->can_add_course ?? 0,
                'edit' => $request->can_edit_course ?? 0]
            );
        }
        if ($user->school && is_array($user->school)) {
            foreach ($user->school as $user_school_id) {
                $user_school = UserSchool::where('user_id', $user->id)->where('school_id', $user_school_id)->first();
                if (!$user_school) {
                    $new_user_school = new UserSchool;
                    $new_user_school->user_id = $user->id;
                    $new_user_school->school_id = $user_school_id;
                    $new_user_school->save();
                }
            }
        }
        $user_schools = UserSchool::where('user_id', $user->id)->get();
        foreach ($user_schools as $user_school) {
            if (!in_array($user_school->school_id, is_array($user->school) ? $user->school : [])) {
                $user_school->delete();
            }
        }
        $saved = __('SuperAdmin/backend.data_saved_successfully');
        return response()->json(['success' => true, 'data' => $saved]);
    }
}