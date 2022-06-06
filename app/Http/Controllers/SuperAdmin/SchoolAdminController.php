<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Classes\StoreClass;
use App\Http\Controllers\Controller;
use App\Models\SchoolAdmin;
use App\Models\SuperAdmin\School;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Image;
use Storage;

class SchoolAdminController extends Controller
{
    function index()
    {
        $schools = User::where('user_type', 'school_admin')->orWhere('user_type', 'branch_admin')->get();

        return view('superadmin.school_admin.index', compact('schools'));
    }

    function create()
    {
        $schools = School::all();
        $schools = $schools->unique('name')->values()->all();
        return view('superadmin.school_admin.add', compact('schools'));
    }

    function store(Request $request)
    {
        $rules = ['first_name_en' => 'required',
            'last_name_en' => 'required',
            'password' => 'required',
            'school_id' => 'required',
            'email' => 'required|unique:users',
            'contact' => 'required',
            'first_name_ar' => 'required',
            'last_name_ar' => 'required',
            'image' => 'mimes:jpg,jpeg,png,bmp',
        ];

        $validator = \Validator::make($request->all(), $rules, ['first_name_en.required' => __('SuperAdmin/backend.errors.first_name_english'),
            'first_name_ar.required' => __('SuperAdmin/backend.errors.first_name_arabic'),
            'last_name_ar.required' => __('SuperAdmin/backend.errors.last_name_arabic'),
            'last_name_en.required' => __('SuperAdmin/backend.errors.last_name_english'),
            'image.required' => __('SuperAdmin/backend.errors.image_required'),
            'contact.required' => __('SuperAdmin/backend.errors.contact_required'),
            'email.required' => __('SuperAdmin/backend.errors.email_required'),
            'image.mimes' => __('SuperAdmin/backend.errors.image_must_be_in'),
            'school_id.required' => 'School Name is Required']);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $requested_save = $validator->validated();
        $user_type = 'school_admin';
        if (!is_null($request->city) && !is_null($request->country) && !is_null($request->branch)) {
            $user_type = "branch_admin";
        }
        unset($requested_save['image']);
        $image_name = null;
        if ($request->has('image')) {
            $image = $request->file('image');

            $filename = time() . rand(00, 99) . \Str::random(10) . '.webp';
            Image::make($image)->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save(public_path('images/user_images/' . $filename));
            $image_name = 'public/images/user_images/' . $filename;
        }
        $requested_save['country'] = $request->country;
        $requested_save['city'] = $request->city;
        $requested_save['branch'] = $request->branch;
        \DB::transaction(function () use ($request, $requested_save, $image_name, $user_type) {
            $user = User::create($requested_save + ['user_type' => $user_type, 'image' => $image_name]);
            $user->userSchool()->create(['user_id' => $user->id, 'school_id' => $request->school_id]);
            $user->editCoursePermission()->create(['delete' => $request->can_delete_course ?? 0, 'add' => $request->can_add_course ?? 0, 'edit' => $request->can_edit_course ?? 0]);
        });

        $saved = __('SuperAdmin/backend.data_saved');
        return response()->json(['success' => 'success', 'data' => $saved]);
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
        $users = User::find($id);
        return view('superadmin.school_admin.edit', compact('users'));
    }

    function update(Request $request, $id)
    {
        $user = User::find($id);
        
        $rules = ['first_name_en' => 'required',
            'last_name_en' => 'required',
            'email' => 'required',
            'contact' => 'required',
            'first_name_ar' => 'required',
            'last_name_ar' => 'required',
            'image' => 'mimes:jpg,jpeg,png,bmp'
        ];

        $validator = \Validator::make($request->all(), $rules, ['first_name_en.required' => __('SuperAdmin/backend.errors.first_name_english'),
            'first_name_ar.required' => __('SuperAdmin/backend.errors.first_name_arabic'),
            'last_name_ar.required' => __('SuperAdmin/backend.errors.last_name_arabic'),
            'last_name_en.required' => __('SuperAdmin/backend.errors.last_name_english'),
            'image.required' => __('SuperAdmin/backend.errors.image_required'),
            'contact.required' => __('SuperAdmin/backend.errors.contact_required'),
            'email.required' => __('SuperAdmin/backend.errors.email_required'),
            'image.mimes' => __('SuperAdmin/backend.errors.image_must_be_in'),]);

        $password = $request->has('password') ? $request->password : null;
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        
        $requested_save = $validator->validated();
        unset($requested_save['image']);

        $image_name = null;
        if ($request->has('image')) {
            $image = $request->file('image');

            $filename = time() . rand(00, 99) . \Str::random(10) . '.webp';
            Image::make($image)->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save(public_path('images/user_images/' . $filename));
            $image_name = 'public/images/user_images/' . $filename;
        }
        $course['can_add_course'] = $request->can_add_course;
        $course['can_edit_course'] = $request->can_edit_course;
        $course['can_delete_course'] = $request->can_delete_course;

        if ($request->has('password')) {
            $user->fill($requested_save + ['user_type' => 'school_admin', 'image' => $image_name, 'password' => $password] + $course)->save();
        } else {
            $user->fill($requested_save + ['user_type' => 'school_admin', 'image' => $image_name] + $course)->save();
        }
        $saved = __('SuperAdmin/backend.data_saved');
        return response()->json(['success' => $saved]);
    }
}