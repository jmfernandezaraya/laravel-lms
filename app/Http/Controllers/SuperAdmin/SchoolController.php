<?php

namespace App\Http\Controllers\SuperAdmin;

use Storage;
use Session;

use App\Http\Controllers\Controller;
use App\Classes\ImageSaverToStorage;
use App\Models\SuperAdmin\School;
use App\Http\Requests\SuperAdmin\AddSchoolRequest;

/**
 * Class SchoolController
 * @package App\Http\Controllers\SuperAdmin
 */
class SchoolController extends Controller
{
    /**
     * SchoolController constructor.
     */
    private $storeImage;

    public function __construct()
    {
        ini_set('post_max_size', 99999);
        ini_set('max_execution_time', 99999);
        ini_set('upload_max_filesize', 99999);
        ini_set('max_file_uploads', 444);

        $this->storeImage = new ImageSaverToStorage();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $schools = School::all();

        return view('superadmin.school.index', compact('schools'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('superadmin.school.add');
    }

    /**
     * @param AddSchoolRequest $r
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AddSchoolRequest $r)
    {
        try {
            $save_to = $r->validated();

            unset($save_to['multiple_photos']);
            unset($save_to['logos']);
            unset($save_to['logo']);

            ini_set('max_execution_time', 400000);
            ini_set('post_max_size', 5000000);
            $input = $r->except('en');
            if ($r->has('multiple_photos')) {
                foreach ($r->multiple_photos as $multiple_photoss) {
                    $this->storeImage->setPath('school_images');
                    $this->storeImage->setImage($multiple_photoss);

                    $multiple_photos[] = $this->storeImage->saveImage();
                }
                $input['multiple_photos'] = $multiple_photos;
            }

            if ($r->has('logos')) {
                $logos = [];
                foreach ($r->logos as $logoss) {
                    $this->storeImage->setPath('school_images');
                    $this->storeImage->setImage($logoss);

                    $logos[] = $this->storeImage->saveImage();
                }

                $input['logos'] = $logos;
            }

            if ($r->has('logo')) {
                $this->storeImage->setPath('school_images');
                $this->storeImage->setImage($r->logo);

                $input['logo'] = $this->storeImage->saveImage();
            }
            if ($r->has('website_link')) {
                $input['website_link'] = $r->website_link;
            }
            $schools = new School();

            if ($r->has("video_url")) {
                $input['school_video'] = $r->video_url;
            }

            $schools->fill($save_to + $input)->save();

            $data['success'] = true;
            $data['data'] = "Data Saved";
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['catch_error'] = $e->getMessage();
            $data['line_code'] = $e->getCode();
        }

        return response()->json($data);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        //DB::table('schools_en')->whereUniqueId($id)->first();
        $schools = School::find($id);

        return view('superadmin.school.edit', compact('schools'));
    }

    /**
     * @param AddSchoolRequest $r
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(AddSchoolRequest $r, $id)
    {
        ini_set('max_execution_time', 400000);
        ini_set('post_max_size', 5000000);

        $schools = School::whereId($id)->first();
        $input = $r->except('en');

        if ($r->has('multiple_photos')) {
            foreach ($r->multiple_photos as $multiple_photoss) {
                $this->storeImage->setImage($multiple_photoss);
                $this->storeImage->setPath('school_images');
                $multiple_photos[] = $this->storeImage->saveImage();
            }
            $input['multiple_photos'] = $multiple_photos;
        }

        if ($r->has('logos')) {
            foreach ($r->file('logos') as $logoss) {
                $this->storeImage->setImage($logoss);
                $this->storeImage->setPath('school_images');

                $logos[] = $this->storeImage->saveImage();
            }
            if ($r->has('website_link')) {
                $input['webiste_link '] = $r->webiste_link;
            }
            $input['logos'] = $logos;
        }

        if ($r->has('logo')) {
            $logose = $r->file('logo');
            $this->storeImage->setPath('school_images');
            $this->storeImage->setImage($logose);

            $logose = $this->storeImage->saveImage();
            $input['logo'] = $logose;
        }
        $save = $r->validated();
        unset($save['logo']);
        unset($save['logos']);
        unset($save['multiple_photos']);
        unset($save['video_url']);

        $input['school_video'] = $r->video_url;
        $schools->fill($save + $input)->save();

        $data['success'] = true;
        $data['data'] = __('SuperAdmin/backend.data_saved');
        return response($data);
    }

    /**
     * @param $id
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $delete = School::find($id)->delete();

        if ($delete) {
            toastr()->success(__('SuperAdmin/backend.data_deleted'));
            return back();
        }
        return true;
    }
}