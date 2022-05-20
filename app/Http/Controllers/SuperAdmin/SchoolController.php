<?php

namespace App\Http\Controllers\SuperAdmin;

use Storage;
use Session;

use App\Http\Controllers\Controller;

use App\Classes\ImageSaverToStorage;

use App\Models\SuperAdmin\School;
use App\Models\UserCourseBookedDetails;

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
        $choose_fields = [
            'cities' => [],
            'countries' => []
        ];
        $schools = School::all();
        foreach($schools as $school) {
            if (is_null($school->city)) {
                if (!in_array('-', $choose_fields['cities'])) {
                    array_push($choose_fields['cities'], '-');
                }
            } else {
                if (is_array($school->city)) {
                    $choose_fields['cities'] = array_unique(array_merge($choose_fields['cities'], $school->city));
                } else {
                    if (!in_array($school->city, $choose_fields['cities'])) {
                        array_push($choose_fields['cities'], $school->city);
                    }
                }
            }
            if (is_null($school->country)) {
                if (!in_array('-', $choose_fields['countries'])) {
                    array_push($choose_fields['countries'], '-');
                }
            } else {
                if (is_array($school->country)) {
                    $choose_fields['countries'] = array_unique(array_merge($choose_fields['countries'], $school->country));
                } else {
                    if (!in_array($school->country, $choose_fields['countries'])) {
                        array_push($choose_fields['countries'], $school->country);
                    }
                }
            }
        }

        return view('superadmin.school.index', compact('schools', 'choose_fields'));
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
            $school = new School();

            if ($r->has("video_url")) {
                $input['video'] = $r->video_url;
            }

            $school->fill($save_to + $input)->save();

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
        $school = School::find($id);

        return view('superadmin.school.edit', compact('school'));
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

        $school = School::whereId($id)->first();
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

        $input['video'] = $r->video_url;
        $school->fill($save + $input)->save();

        $data['success'] = true;
        $data['data'] = __('SuperAdmin/backend.data_saved');
        return response($data);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clone($id)
    {
        $school = School::whereId($id)->first();

        $new_school = new School();
        $new_school->name = $school->name;
        $new_school->name_ar = $school->name_ar;
        $new_school->email = $school->email;
        $new_school->contact = $school->contact;
        $new_school->emergency_number = $school->emergency_number;
        $new_school->branch_name = $school->branch_name;
        $new_school->branch_name_ar = $school->branch_name_ar;
        $new_school->logo = $school->logo;
        $new_school->video = $school->video;
        $new_school->multiple_photos = $school->multiple_photos;
        $new_school->capacity = $school->capacity;
        $new_school->facilities = $school->facilities;
        $new_school->facilities_ar = $school->facilities_ar;
        $new_school->class_size = $school->class_size;
        $new_school->class_size_ar = $school->class_size_ar;
        $new_school->opened = $school->opened;
        $new_school->about = $school->about;
        $new_school->about_ar = $school->about_ar;
        $new_school->logos = $school->logos;
        $new_school->address = $school->address;
        $new_school->address_ar = $school->address_ar;
        $new_school->city = $school->city;
        $new_school->city_ar = $school->city_ar;
        $new_school->video_url = $school->video_url;
        $new_school->country = $school->country;
        $new_school->country_ar = $school->country_ar;
        $new_school->viewed_count = 0;
        $new_school->website_link = $school->website_link;
        $new_school->is_active = $school->is_active;
        $new_school->created_at = $school->created_at;
        $new_school->updated_at = null;
        $new_school->save();
        
        toastr()->success(__('SuperAdmin/backend.school_cloned_successfully'));
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function pause($id)
    {
        $db = \DB::transaction(function() use ($id) {
            $school = School::where('id', $id)->first();
            if ($school) {
                $school->is_active = false;
                $school->save();
                return true;
            }
        });
        if ($db) {
            toastr()->success(__('SuperAdmin/backend.school_paused_successfully'));
        }
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function play($id)
    {
        $db = \DB::transaction(function() use ($id) {
            $school = School::where('id', $id)->first();
            if ($school) {
                $school->is_active = true;
                $school->save();
                return true;
            }
        });
        if ($db) {
            toastr()->success(__('SuperAdmin/backend.school_played_successfully'));
        }
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bulk(Request $r)
    {
        $request_action = $r->action;
        $request_ids = $r->ids;
        if ($request_ids) {
            $school_ids = explode(",", $request_ids);
    
            foreach ($school_ids as $school_id) {
                if ($school_id) {
                    if ($request_action == "clone") {
                        $this->clone($school_id);
                    } else if ($request_action == "play") {
                        $this->play($school_id);
                    } else if ($request_action == "pause") {
                        $this->pause($school_id);
                    } else if ($request_action == "destroy") {
                        $this->destroy($school_id);
                    }
                }
            }
        }
        return back();
    }

    /**
     * @param $id
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $school_ids = UserCourseBookedDetails::pluck('school_id')->toArray();

        if (in_array($id, $school_ids)) {
            toastr()->error(__('SuperAdmin/backend.customer_registered_with_this_school'));
            return back();
        } else {
            $delete = School::find($id)->delete();

            if ($delete) {
                toastr()->success(__('SuperAdmin/backend.school_deleted_successfully'));
                return back();
            }
            return true;
        }
    }
}