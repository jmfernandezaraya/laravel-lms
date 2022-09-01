<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Classes\StoreClass;

use App\Http\Controllers\Controller;

use App\Mail\EmailTemplate;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            'telephone' => 'required',
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
            'telephone.required' => __('Admin/backend.errors.telephone_required'),
            'email.required' => __('Admin/backend.errors.email_required'),
            'image.mimes' => __('Admin/backend.errors.image_must_be_in')
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $requested_save = $validator->validated();
        unset($requested_save['password']);
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
        \DB::transaction(function () use ($request, $requested_save, $image_name) {
            if ($image_name) {
                $user = User::create($requested_save + ['user_type' => 'super_admin', 'image' => $image_name, 'password' => \Hash::make($request->password), 'email_verified_at' => Carbon::now()->toDate()]);
            } else {
                $user = User::create($requested_save + ['user_type' => 'super_admin', 'password' => \Hash::make($request->password), 'email_verified_at' => Carbon::now()->toDate()]);
            }
            if (can_manage_user() || can_permission_user()) {
                $user->permission()->create([
                    'blog_manager' => $request->blog_permission == 'manager',
                    'blog_add' => ($request->blog_permission == 'subscriber' && $request->blog_add) ?? 0,
                    'blog_edit' => ($request->blog_permission == 'subscriber' && $request->blog_edit) ?? 0,
                    'blog_delete' => ($request->blog_permission == 'subscriber' && $request->blog_delete) ?? 0,
                    'coupon_manager' => $request->coupon_permission == 'manager',
                    'coupon_add' => ($request->coupon_permission == 'subscriber' && $request->coupon_add) ?? 0,
                    'coupon_edit' => ($request->coupon_permission == 'subscriber' && $request->coupon_edit) ?? 0,
                    'coupon_delete' => ($request->coupon_permission == 'subscriber' && $request->coupon_delete) ?? 0,
                    'course_manager' => $request->course_permission == 'manager',
                    'course_view' => ($request->course_permission == 'subscriber' && $request->course_view) ?? 0,
                    'course_add' => ($request->course_permission == 'subscriber' && $request->course_add) ?? 0,
                    'course_edit' => ($request->course_permission == 'subscriber' && $request->course_edit) ?? 0,
                    'course_display' => ($request->course_permission == 'subscriber' && $request->course_display) ?? 0,
                    'course_delete' => ($request->course_permission == 'subscriber' && $request->course_delete) ?? 0,
                    'course_application_manager' => $request->course_application_permission == 'manager',
                    'course_application_edit' => ($request->course_application_permission == 'subscriber' && $request->course_application_edit) ?? 0,
                    'course_application_chanage_status' => ($request->course_application_permission == 'subscriber' && $request->course_application_chanage_status) ?? 0,
                    'course_application_payment_refund' => ($request->course_application_permission == 'subscriber' && $request->course_application_payment_refund) ?? 0,
                    'course_application_contact_student' => ($request->course_application_permission == 'subscriber' && $request->course_application_contact_student) ?? 0,
                    'course_application_contact_school' => ($request->course_application_permission == 'subscriber' && $request->course_application_contact_school) ?? 0,
                    'currency_manager' => $request->currency_permission == 'manager',
                    'currency_add' => ($request->currency_permission == 'subscriber' && $request->currency_add) ?? 0,
                    'currency_edit' => ($request->currency_permission == 'subscriber' && $request->currency_edit) ?? 0,
                    'currency_delete' => ($request->currency_permission == 'subscriber' && $request->currency_delete) ?? 0,
                    'email_template_manager' => $request->email_template_permission == 'manager',
                    'email_template_add' => ($request->email_template_permission == 'subscriber' && $request->email_template_add) ?? 0,
                    'email_template_edit' => ($request->email_template_permission == 'subscriber' && $request->email_template_edit) ?? 0,
                    'email_template_delete' => ($request->email_template_permission == 'subscriber' && $request->email_template_delete) ?? 0,
                    'enquiry_manager' => $request->enquiry_permission == 'manager',
                    'enquiry_add' => ($request->enquiry_permission == 'subscriber' && $request->enquiry_add) ?? 0,
                    'enquiry_edit' => ($request->enquiry_permission == 'subscriber' && $request->enquiry_edit) ?? 0,
                    'enquiry_delete' => ($request->enquiry_permission == 'subscriber' && $request->enquiry_delete) ?? 0,
                    'form_builder_manager' => $request->form_builder_permission == 'manager',
                    'form_builder_add' => ($request->form_builder_permission == 'subscriber' && $request->form_builder_add) ?? 0,
                    'form_builder_edit' => ($request->form_builder_permission == 'subscriber' && $request->form_builder_edit) ?? 0,
                    'form_builder_delete' => ($request->form_builder_permission == 'subscriber' && $request->form_builder_delete) ?? 0,
                    'payment_manager' => $request->payment_permission == 'manager',
                    'payment_edit' => ($request->payment_permission == 'subscriber' && $request->payment_edit) ?? 0,
                    'payment_delete' => ($request->payment_permission == 'subscriber' && $request->payment_delete) ?? 0,
                    'review_manager' => $request->review_permission == 'manager',
                    'review_apply' => ($request->review_permission == 'subscriber' && $request->review_apply) ?? 0,
                    'review_edit' => ($request->review_permission == 'subscriber' && $request->review_edit) ?? 0,
                    'review_delete' => ($request->review_permission == 'subscriber' && $request->review_delete) ?? 0,
                    'review_approve' => ($request->review_permission == 'subscriber' && $request->review_approve) ?? 0,
                    'school_manager' => $request->school_permission == 'manager',
                    'school_add' => ($request->school_permission == 'subscriber' && $request->school_add) ?? 0,
                    'school_edit' => ($request->school_permission == 'subscriber' && $request->school_edit) ?? 0,
                    'school_delete' => ($request->school_permission == 'subscriber' && $request->school_delete) ?? 0,
                    'user_manager' => $request->user_permission == 'manager',
                    'user_add' => ($request->user_permission == 'subscriber' && $request->user_add) ?? 0,
                    'user_edit' => ($request->user_permission == 'subscriber' && $request->user_edit) ?? 0,
                    'user_delete' => ($request->user_permission == 'subscriber' && $request->user_delete) ?? 0,
                    'user_permission' => ($request->user_permission == 'subscriber' && $request->user_permissions) ?? 0,
                    'visa_application_manager' => $request->visa_application_permission == 'manager',
                    'visa_application_add' => ($request->visa_application_permission == 'subscriber' && $request->visa_application_add) ?? 0,
                    'visa_application_edit' => ($request->visa_application_permission == 'subscriber' && $request->visa_application_edit) ?? 0,
                    'visa_application_delete' => ($request->visa_application_permission == 'subscriber' && $request->visa_application_delete) ?? 0,
                ]);
            }

            $mail_data['user'] = $user;
            $mail_data['email'] = $request->email;
            $mail_data['password'] = $request->password;
            $mail_data['dashbaord_link'] = route('superadmin.dashboard');
            $mail_data['change_password_link'] = route('password.reset', ['token' => \Password::createToken($user)]) . '/?email=' . $user->email;
            sendEmail('super_admin_created', $user->email, (object)$mail_data, app()->getLocale());
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
            'telephone' => 'required',
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
            'telephone.required' => __('Admin/backend.errors.telephone_required'),
            'email.required' => __('Admin/backend.errors.email_required'),
            'image.mimes' => __('Admin/backend.errors.image_must_be_in'),
        ]);
        $password = $request->has('password') ? \Hash::make($request->password) : null;
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        
        $requested_save = $validator->validated();
        unset($requested_save['password']);
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
        if (can_manage_user() || can_permission_user()) {
            $user->permission()->updateOrCreate(['user_id' => $user->id], [
                'blog_manager' => $request->blog_permission == 'manager',
                'blog_add' => ($request->blog_permission == 'subscriber' && $request->blog_add) ?? 0,
                'blog_edit' => ($request->blog_permission == 'subscriber' && $request->blog_edit) ?? 0,
                'blog_delete' => ($request->blog_permission == 'subscriber' && $request->blog_delete) ?? 0,
                'coupon_manager' => $request->coupon_permission == 'manager',
                'coupon_add' => ($request->coupon_permission == 'subscriber' && $request->coupon_add) ?? 0,
                'coupon_edit' => ($request->coupon_permission == 'subscriber' && $request->coupon_edit) ?? 0,
                'coupon_delete' => ($request->coupon_permission == 'subscriber' && $request->coupon_delete) ?? 0,
                'course_manager' => $request->course_permission == 'manager',
                'course_view' => ($request->course_permission == 'subscriber' && $request->course_view) ?? 0,
                'course_add' => ($request->course_permission == 'subscriber' && $request->course_add) ?? 0,
                'course_edit' => ($request->course_permission == 'subscriber' && $request->course_edit) ?? 0,
                'course_display' => ($request->course_permission == 'subscriber' && $request->course_display) ?? 0,
                'course_delete' => ($request->course_permission == 'subscriber' && $request->course_delete) ?? 0,
                'course_application_manager' => $request->course_application_permission == 'manager',
                'course_application_edit' => ($request->course_application_permission == 'subscriber' && $request->course_application_edit) ?? 0,
                'course_application_chanage_status' => ($request->course_application_permission == 'subscriber' && $request->course_application_chanage_status) ?? 0,
                'course_application_payment_refund' => ($request->course_application_permission == 'subscriber' && $request->course_application_payment_refund) ?? 0,
                'course_application_contact_student' => ($request->course_application_permission == 'subscriber' && $request->course_application_contact_student) ?? 0,
                'course_application_contact_school' => ($request->course_application_permission == 'subscriber' && $request->course_application_contact_school) ?? 0,
                'currency_manager' => $request->currency_permission == 'manager',
                'currency_add' => ($request->currency_permission == 'subscriber' && $request->currency_add) ?? 0,
                'currency_edit' => ($request->currency_permission == 'subscriber' && $request->currency_edit) ?? 0,
                'currency_delete' => ($request->currency_permission == 'subscriber' && $request->currency_delete) ?? 0,
                'email_template_manager' => $request->email_template_permission == 'manager',
                'email_template_add' => ($request->email_template_permission == 'subscriber' && $request->email_template_add) ?? 0,
                'email_template_edit' => ($request->email_template_permission == 'subscriber' && $request->email_template_edit) ?? 0,
                'email_template_delete' => ($request->email_template_permission == 'subscriber' && $request->email_template_delete) ?? 0,
                'enquiry_manager' => $request->enquiry_permission == 'manager',
                'enquiry_add' => ($request->enquiry_permission == 'subscriber' && $request->enquiry_add) ?? 0,
                'enquiry_edit' => ($request->enquiry_permission == 'subscriber' && $request->enquiry_edit) ?? 0,
                'enquiry_delete' => ($request->enquiry_permission == 'subscriber' && $request->enquiry_delete) ?? 0,
                'form_builder_manager' => $request->form_builder_permission == 'manager',
                'form_builder_add' => ($request->form_builder_permission == 'subscriber' && $request->form_builder_add) ?? 0,
                'form_builder_edit' => ($request->form_builder_permission == 'subscriber' && $request->form_builder_edit) ?? 0,
                'form_builder_delete' => ($request->form_builder_permission == 'subscriber' && $request->form_builder_delete) ?? 0,
                'payment_manager' => $request->payment_permission == 'manager',
                'payment_edit' => ($request->payment_permission == 'subscriber' && $request->payment_edit) ?? 0,
                'payment_delete' => ($request->payment_permission == 'subscriber' && $request->payment_delete) ?? 0,
                'review_manager' => $request->review_permission == 'manager',
                'review_apply' => ($request->review_permission == 'subscriber' && $request->review_apply) ?? 0,
                'review_edit' => ($request->review_permission == 'subscriber' && $request->review_edit) ?? 0,
                'review_delete' => ($request->review_permission == 'subscriber' && $request->review_delete) ?? 0,
                'review_approve' => ($request->review_permission == 'subscriber' && $request->review_approve) ?? 0,
                'school_manager' => $request->school_permission == 'manager',
                'school_add' => ($request->school_permission == 'subscriber' && $request->school_add) ?? 0,
                'school_edit' => ($request->school_permission == 'subscriber' && $request->school_edit) ?? 0,
                'school_delete' => ($request->school_permission == 'subscriber' && $request->school_delete) ?? 0,
                'user_manager' => $request->user_permission == 'manager',
                'user_add' => ($request->user_permission == 'subscriber' && $request->user_add) ?? 0,
                'user_edit' => ($request->user_permission == 'subscriber' && $request->user_edit) ?? 0,
                'user_delete' => ($request->user_permission == 'subscriber' && $request->user_delete) ?? 0,
                'user_permission' => ($request->user_permission == 'subscriber' && $request->user_permissions) ?? 0,
                'visa_application_manager' => $request->visa_application_permission == 'manager',
                'visa_application_add' => ($request->visa_application_permission == 'subscriber' && $request->visa_application_add) ?? 0,
                'visa_application_edit' => ($request->visa_application_permission == 'subscriber' && $request->visa_application_edit) ?? 0,
                'visa_application_delete' => ($request->visa_application_permission == 'subscriber' && $request->visa_application_delete) ?? 0,
            ]);
        }
        
        $saved = __('Admin/backend.data_saved_successfully');
        return response()->json(['success' => 'success', 'data' => $saved]);
    }
}