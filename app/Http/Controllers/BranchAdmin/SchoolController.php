<?php

namespace App\Http\Controllers\BranchAdmin;

use App\Http\Requests\SuperAdmin\AddSchoolRequest;
use DB;
use Storage;
use Validator;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuperAdmin\School;

class SchoolController extends Controller
{
    //
    public function __construct()
    {
        ini_set('post_max_size', 99999);
        ini_set('max_execution_time', 99999);
        ini_set('upload_max_filesize', 99999);
        ini_set('max_file_uploads', 444);
    }

    public function index()
    {
        $schools = School::all();

        return view('branchadmin.school.index', compact('schools'));
    }

    public function create()
    {
        return view('branchadmin.school.add');
    }

    function store(AddSchoolRequest $r)
    {
        $save_to = $r->validated();

        unset($save_to['multiple_photos']);
        unset($save_to['logos']);
        unset($save_to['logo']);

        ini_set('max_execution_time', 400000);
        ini_set('post_max_size', 5000000);
        $input = $r->except('en');
        if ($r->has('multiple_photos')) {
            foreach ($r->multiple_photos as $multiple_photoss) {
                Storage::delete('public/school_images/' . $multiple_photoss);
                $imageee = Storage::disk('public')->put('school_images/', $multiple_photoss);
                $imageees = explode('school_images//', $imageee);
                $multiple_photos[] = $imageees[1];
                Session::put('multiple_photos', $multiple_photos);
            }
            $input['multiple_photos'] = $multiple_photos;
        }

        if ($r->has('logos')) {
            foreach ($r->logos as $logoss) {
                $logo = Storage::disk('public')->put('school_images/', $logoss);
                $logo = explode('school_images//', $logo);
                $logos[] = $logo[1];
            }

            $input['logos'] = $logos;
        }

        if ($r->has('logo')) {
            $logoe = Storage::disk('public')->put('school_images/', $r->logo);
            $logoe = explode('school_images//', $logoe);
            $logose = $logoe[1];
            $input['logo'] = $logose;
        }
        $schools = new School();
        $schools->fill($save_to + $input)->save();
        $data['success'] = true;
        $data['data'] = "Data Saved";

        return response()->json($data);
    }

    function edit($id)
    {
        //DB::table('schools_en')->whereUniqueId($id)->first();
        $schools = School::find($id);

        return view('branchadmin.school.edit', compact('schools'));
    }

    function update(AddSchoolRequest $r, $id)
    {
        ini_set('max_execution_time', 400000);
        ini_set('post_max_size', 5000000);

        $schools = School::whereId($id)->first();
        $input = $r->except('en');
        if ($r->has('multiple_photos')) {
            foreach ($r->multiple_photos as $multiple_photoss) {
                Storage::disk('public')->delete('school_images/' . $multiple_photoss);
                $imageee = Storage::disk('public')->put('school_images/', $multiple_photoss);
                $imageees = explode('school_images//', $imageee);
                $multiple_photos[] = $imageees[1];
            }
            $input['multiple_photos'] = $multiple_photos;
        }

        if ($r->has('logos')) {
            foreach ($r->logos as $logoss) {
                Storage::disk('public')->delete('school_images/', $logoss);
                $logo = Storage::disk('public')->put('school_images/', $logoss);

                $logo = explode('school_images//', $logo);
                $logos[] = $logo[1];
            }

            $input['logos'] = $logos;
        }

        if ($r->has('logo')) {
            Storage::disk('public')->delete('school_images/',  $r->logo);
            $logoe = Storage::disk('public')->put('school_images/', $r->logo);

            $logoe = explode('school_images//', $logoe);
            $logose = $logoe[1];

            $input['logo'] = $logose;
        }

        $schools->fill($r->validated() + $input)->save();


        $data['success'] = true;
        $data['data'] = __('SuperAdmin/backend.data_saved');

        return response($data);
    }

    function destroy($id)
    {
        $school = DB::table('schools')->where('id',$id)->first();

        if (!empty($school->logo)) {
            Storage::delete('public/school_images/' . $school->logo);
        }
        if (!empty($school->video)) {
            if (is_array($school->video)) {
                foreach ($school->video as $videos) {
                    Storage::delete('public/video/' . $videos);
                }
            } else {
                Storage::delete('public/video/' . $school->video);
            }
        }

        if (!empty($school_get->logos)) {
            foreach ($school_get->logos as $videos) {
                Storage::delete('public/school_images/' . $videos);
            }
        }

        if (!empty($school_get->multiple_photos)) {
            foreach ($school_get->multiple_photos as $videos) {
                Storage::delete('public/school_images/' . $videos);
            }
        }

        $delete = DB::table('schools')->whereId($id)->delete();

        if ($delete) {
            toastr()->success(__('SuperAdmin/backend.data_deleted'));
            return back();
        }
    }
}