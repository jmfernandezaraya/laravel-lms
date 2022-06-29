<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Models\SuperAdmin\BranchSchools;
use App\Models\SuperAdmin\School;
use App\Models\SuperAdmin\UserSchool;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class BranchAdminController
 * @package App\Http\Controllers\SchoolAdmin
 */
class BranchAdminController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $schools = BranchSchools::with(['school', 'user'])->get();
        return view('schooladmin.branch_admin.index', compact('schools'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $schools = School::all()->unique('name')->values()->all();

        return view('schooladmin.branch_admin.add', compact('schools'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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

        $validator = \Validator::make($request->all(), $rules, [
            'first_name_en.required' => __('Admin/backend.errors.first_name_english'),
            'first_name_ar.required' => __('Admin/backend.errors.first_name_arabic'),
            'last_name_ar.required' => __('Admin/backend.errors.last_name_arabic'),
            'last_name_en.required' => __('Admin/backend.errors.last_name_english'),
            'image.required' => __('Admin/backend.errors.image_required'),
            'contact.required' => __('Admin/backend.errors.contact_required'),
            'email.required' => __('Admin/backend.errors.email_required'),
            'image.mimes' => __('Admin/backend.errors.image_must_be_in'),
            'school_id.required' => 'School Name is Required']);

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
            })
                ->encode('webp', 90)->save(public_path('images/user_images/' . $filename));
            $image_name = 'public/images/user_images/' . $filename;
        }
        $requested_save['country'] = $request->country;
        $requested_save['city'] = $request->city;
        $requested_save['branch'] = $request->branch;
        \DB::transaction(function () use ($request, $requested_save, $image_name) {
            $user = User::create($requested_save + ['user_type' => 'school_admin', 'image' => $image_name]);
            $user->userSchool()->create(['user_id' => $user->id, 'school_id' => $request->school_id]);
            $user->editCoursePermission()->create(['delete' => $request->can_delete_course ?? 0, 'add' => $request->can_add_course ?? 0, 'edit' => $request->can_edit_course ?? 0]);
        });

        $saved = __('Admin/backend.data_saved_successfully');
        return response()->json(['success' => 'success', 'data' => $saved]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}