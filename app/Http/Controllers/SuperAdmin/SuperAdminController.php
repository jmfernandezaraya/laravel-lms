<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Classes\StoreClass;

use App\Http\Controllers\Controller;

use App\Models\User;

use Illuminate\Http\Request;

use DB;
use Image;
use Storage;

class SuperAdminController extends Controller
{
    function index()
    {
        $super_admins = User::where('user_type', 'super_admin')->get();

        return view('superadmin.super_admin.index', compact('super_admins'));
    }

    function create()
    {
        return view('superadmin.super_admin.add');
    }

    function store(Request $request)
    {
        $rules = [
            'first_name_en' => 'required',
            'last_name_en' => 'required',
            'password' => 'required',
            'email' => 'required|unique:users',
            'contact' => 'required',
            'first_name_ar' => 'required',
            'last_name_ar' => 'required',
            'image' => 'mimes:jpg,jpeg,png,bmp',
        ];

        $validator = \Validator::make($request->all(), $rules, [
            'first_name_en.required' => __('Admin/backend.errors.first_name_english'),
            'first_name_ar.required' => __('Admin/backend.errors.first_name_arabic'),
            'last_name_ar.required' => __('Admin/backend.errors.last_name_arabic'),
            'last_name_en.required' => __('Admin/backend.errors.last_name_english'),
            'image.required' => __('Admin/backend.errors.image_required'),
            'contact.required' => __('Admin/backend.errors.contact_required'),
            'email.required' => __('Admin/backend.errors.email_required'),
            'image.mimes' => __('Admin/backend.errors.image_must_be_in')]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $requested_save = $validator->validated();
        unset($requested_save['image']);
        unset($requested_save['blog_permission']);
        unset($requested_save['blog_add']);
        unset($requested_save['blog_edit']);
        unset($requested_save['school_permission']);
        unset($requested_save['school_add']);
        unset($requested_save['school_edit']);
        unset($requested_save['course_permission']);
        unset($requested_save['course_add']);
        unset($requested_save['course_edit']);
        unset($requested_save['course_display']);
        unset($requested_save['course_delete']);
        unset($requested_save['currency_permission']);
        unset($requested_save['currency_add']);
        unset($requested_save['currency_edit']);
        unset($requested_save['course_application_permission']);
        unset($requested_save['course_application_edit']);
        unset($requested_save['course_application_chanage_status']);
        unset($requested_save['course_application_payment_refund']);
        unset($requested_save['course_application_contact_student']);
        unset($requested_save['course_application_contact_school']);

        $image_name = null;
        if ($request->has('image')) {
            $image = $request->file('image');

            $filename = time() . rand(00, 99) . \Str::random(10) . '.webp';
            Image::make($image)->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save(public_path('images/user_images/' . $filename));
            $image_name = 'public/images/user_images/' . $filename;
        }
        \DB::transaction(function () use ($request, $requested_save, $image_name) {
            if ($image_name) {
                $user = User::create($requested_save + ['user_type' => 'super_admin', 'image' => $image_name, 'password' => \Hash::make($request->password)]);
            } else {
                $user = User::create($requested_save + ['user_type' => 'super_admin', 'password' => \Hash::make($request->password)]);
            }
            if (can('can_manage_user' || 'can_permission_user')) {
                $user->permission()->create([
                    'blog_manager' => $request->blog_permission == 'manager',
                    'blog_add' => ($request->blog_permission == 'subscriber' && $request->blog_add) ?? 0,
                    'blog_edit' => ($request->blog_permission == 'subscriber' && $request->blog_edit) ?? 0,
                    'school_manager' => $request->school_permission == 'manager',
                    'school_add' => ($request->school_permission == 'subscriber' && $request->school_add) ?? 0,
                    'school_edit' => ($request->school_permission == 'subscriber' && $request->school_edit) ?? 0,
                    'course_manager' => $request->course_permission == 'manager',
                    'course_add' => ($request->course_permission == 'subscriber' && $request->course_add) ?? 0,
                    'course_edit' => ($request->course_permission == 'subscriber' && $request->course_edit) ?? 0,
                    'course_display' => ($request->course_permission == 'subscriber' && $request->course_display) ?? 0,
                    'course_delete' => ($request->course_permission == 'subscriber' && $request->course_delete) ?? 0,
                    'currency_manager' => $request->currency_permission == 'manager',
                    'currency_add' => ($request->currency_permission == 'subscriber' && $request->currency_add) ?? 0,
                    'currency_edit' => ($request->currency_permission == 'subscriber' && $request->currency_edit) ?? 0,
                    'course_application_manager' => $request->course_application_permission == 'manager',
                    'course_application_edit' => ($request->course_application_permission == 'subscriber' && $request->course_application_edit) ?? 0,
                    'course_application_chanage_status' => ($request->course_application_permission == 'subscriber' && $request->course_application_chanage_status) ?? 0,
                    'course_application_payment_refund' => ($request->course_application_permission == 'subscriber' && $request->course_application_payment_refund) ?? 0,
                    'course_application_contact_student' => ($request->course_application_permission == 'subscriber' && $request->course_application_contact_student) ?? 0,
                    'course_application_contact_school' => ($request->course_application_permission == 'subscriber' && $request->course_application_contact_school) ?? 0,            
                    'user_manager' => $request->user_permission == 'manager',
                    'user_add' => ($request->user_permission == 'subscriber' && $request->user_add) ?? 0,
                    'user_edit' => ($request->user_permission == 'subscriber' && $request->user_edit) ?? 0,
                    'user_delete' => ($request->user_permission == 'subscriber' && $request->user_delete) ?? 0,
                    'user_permission' => ($request->user_permission == 'subscriber' && $request->user_permissions) ?? 0,
                ]);
            }
        });

        $saved = __('Admin/backend.data_saved_successfully');
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
            toastr()->success(__('Admin/backend.deleted_successfully'));
            return back();
        }
    }

    function edit($id)
    {
        $super_admin = User::with('permission')->find($id);
        return view('superadmin.super_admin.edit', compact('super_admin'));
    }

    function update(Request $request, $id)
    {
        $user = User::find($id);
        
        $rules = [
            'first_name_en' => 'required',
            'last_name_en' => 'required',
            'email' => 'required',
            'contact' => 'required',
            'first_name_ar' => 'required',
            'last_name_ar' => 'required',
            'image' => 'mimes:jpg,jpeg,png,bmp'
        ];

        $validator = \Validator::make($request->all(), $rules, [
            'first_name_en.required' => __('Admin/backend.errors.first_name_english'),
            'first_name_ar.required' => __('Admin/backend.errors.first_name_arabic'),
            'last_name_ar.required' => __('Admin/backend.errors.last_name_arabic'),
            'last_name_en.required' => __('Admin/backend.errors.last_name_english'),
            'image.required' => __('Admin/backend.errors.image_required'),
            'contact.required' => __('Admin/backend.errors.contact_required'),
            'email.required' => __('Admin/backend.errors.email_required'),
            'image.mimes' => __('Admin/backend.errors.image_must_be_in'),]);

        $password = $request->has('password') ? \Hash::make($request->password) : null;
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        
        $requested_save = $validator->validated();
        unset($requested_save['image']);
        unset($requested_save['blog_permission']);
        unset($requested_save['blog_add']);
        unset($requested_save['blog_edit']);
        unset($requested_save['school_permission']);
        unset($requested_save['school_add']);
        unset($requested_save['school_edit']);
        unset($requested_save['course_permission']);
        unset($requested_save['course_add']);
        unset($requested_save['course_edit']);
        unset($requested_save['course_display']);
        unset($requested_save['course_delete']);
        unset($requested_save['currency_permission']);
        unset($requested_save['currency_add']);
        unset($requested_save['currency_edit']);
        unset($requested_save['course_application_permission']);
        unset($requested_save['course_application_edit']);
        unset($requested_save['course_application_chanage_status']);
        unset($requested_save['course_application_payment_refund']);
        unset($requested_save['course_application_contact_student']);
        unset($requested_save['course_application_contact_school']);

        $image_name = null;
        if ($request->has('image')) {
            $image = $request->file('image');

            $filename = time() . rand(00, 99) . \Str::random(10) . '.webp';
            Image::make($image)->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save(public_path('images/user_images/' . $filename));
            $image_name = 'public/images/user_images/' . $filename;
        }

        if ($request->has('password')) {
            if ($image_name) {
                $user->fill($requested_save + ['user_type' => 'super_admin', 'image' => $image_name, 'password' => $password])->save();
            } else {
                $user->fill($requested_save + ['user_type' => 'super_admin', 'password' => $password])->save();
            }
        } else {
            if ($image_name) {
                $user->fill($requested_save + ['user_type' => 'super_admin', 'image' => $image_name])->save();
            } else {
                $user->fill($requested_save + ['user_type' => 'super_admin'])->save();
            }
        }
        if (can('can_manage_user' || 'can_permission_user')) {
            $user->permission()->updateOrCreate(['user_id' => $user->id], [
                'blog_manager' => $request->blog_permission == 'manager',
                'blog_add' => ($request->blog_permission == 'subscriber' && $request->blog_add) ?? 0,
                'blog_edit' => ($request->blog_permission == 'subscriber' && $request->blog_edit) ?? 0,
                'school_manager' => $request->school_permission == 'manager',
                'school_add' => ($request->school_permission == 'subscriber' && $request->school_add) ?? 0,
                'school_edit' => ($request->school_permission == 'subscriber' && $request->school_edit) ?? 0,
                'course_manager' => $request->course_permission == 'manager',
                'course_add' => ($request->course_permission == 'subscriber' && $request->course_add) ?? 0,
                'course_edit' => ($request->course_permission == 'subscriber' && $request->course_edit) ?? 0,
                'course_display' => ($request->course_permission == 'subscriber' && $request->course_display) ?? 0,
                'course_delete' => ($request->course_permission == 'subscriber' && $request->course_delete) ?? 0,
                'currency_manager' => $request->currency_permission == 'manager',
                'currency_add' => ($request->currency_permission == 'subscriber' && $request->currency_add) ?? 0,
                'currency_edit' => ($request->currency_permission == 'subscriber' && $request->currency_edit) ?? 0,
                'course_application_manager' => $request->course_application_permission == 'manager',
                'course_application_edit' => ($request->course_application_permission == 'subscriber' && $request->course_application_edit) ?? 0,
                'course_application_chanage_status' => ($request->course_application_permission == 'subscriber' && $request->course_application_chanage_status) ?? 0,
                'course_application_payment_refund' => ($request->course_application_permission == 'subscriber' && $request->course_application_payment_refund) ?? 0,
                'course_application_contact_student' => ($request->course_application_permission == 'subscriber' && $request->course_application_contact_student) ?? 0,
                'course_application_contact_school' => ($request->course_application_permission == 'subscriber' && $request->course_application_contact_school) ?? 0,            
                'user_manager' => $request->user_permission == 'manager',
                'user_add' => ($request->user_permission == 'subscriber' && $request->user_add) ?? 0,
                'user_edit' => ($request->user_permission == 'subscriber' && $request->user_edit) ?? 0,
                'user_delete' => ($request->user_permission == 'subscriber' && $request->user_delete) ?? 0,
                'user_permission' => ($request->user_permission == 'subscriber' && $request->user_permissions) ?? 0,
            ]);
        }
        
        $saved = __('Admin/backend.data_saved_successfully');
        return response()->json(['success' => $saved]);
    }
}