<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use App\Models\SuperAdmin\CourseAccommodation;
use App\Models\SuperAdmin\CourseAirport;
use App\Models\SuperAdmin\Course;
use App\Models\SuperAdmin\CourseAccommodationUnderAge;
use App\Models\SuperAdmin\CourseMedicalFee;
use App\Models\SuperAdmin\CourseProgram;
use App\Models\SuperAdmin\CourseProgramUnderAgeFee;
use App\Services\AssignCoursePermissionToUserService;

use Illuminate\Http\Request;

class CourseDetailsController extends Controller
{
    public function courseProgramDetails($course_unique_id)
    {
        $course_programs = CourseProgram::whereCourseUniqueId($course_unique_id)->get();

        return view("superadmin.courses.course_details.program", compact('course_programs'));
    }

    public function accomodationDetails($course_unique_id)
    {
        $accomodations = CourseAccommodation::whereCourseUniqueId($course_unique_id)->get();
        return view("superadmin.courses.course_details.accommodation", compact('accomodations'));
    }

    /*
    * function for getting accomodation under age
    *
    * @param course_program_id
    *
    * @return view
    *
    * */
    public function accomodationUderageDetails($accomadation_id)
    {
        $underages = CourseAccommodationUnderAge::where('accom_id', $accomadation_id)->get();

        return view('superadmin.courses.course_details.accommodation_under_age', compact('underages'));
    }

    public function airportDetails($course_unique_id)
    {
        $airports = CourseAirport::whereCourseUniqueId($course_unique_id)->get();
        return view("superadmin.courses.course_details.airport", compact('airports'));
    }

    /*
     * function for getting
     *
     * program under age
     *
     * @param course_program_id
     *
     * @return view
     *
     * */
    public function courseProgramUnderAgeDetails($program_id)
    {
        $programs = CourseProgramUnderAgeFee::where('course_program_id', $program_id)->get();
        return view('superadmin.courses.course_details.program_under_age', compact('programs'));
    }

    public function medicalDetails($id)
    {
        $medicals = CourseMedicalFee::where('course_unique_id', $id)->get();

        return view('superadmin.courses.course_details.medical_details', compact('medicals'));
    }

    /*
     * function for editing courseprogram
     *
     * @param Request $request
     *
     * @return back()
     *
     * */
    public function courseProgramEdit(Request $request)
    {
        $to_be_updated = CourseProgramUnderAgeFee::find($request->id);
        $to_be_updated->under_age = $request->under_age;

        $to_be_updated->under_age_fee_per_week = $request->under_age_fee_per_week;
        $to_be_updated->save();
        toastr(__('SuperAdmin/backend.data_updated'), 'success');
        return back();
    }

    /*
     * function to give access to schooladmin
     *
     * @param $id
     *
     * @return back
     *
     * */
    public function giveAccessToSchoolAdminCourseProgramUnderAge($id)
    {
        $to_be_updated = CourseProgramUnderAgeFee::find($id);
        $access = $to_be_updated->can_edit_by_school_admin == 1 ? 0 : 1;
        $to_be_updated->can_edit_by_school_admin = $access;
        $to_be_updated->save();
        toastr(__('SuperAdmin/backend.data_updated'), 'success');
        return back();
    }

    /*
     * function for deleting airport
     *
     * @param $id
     *
     * @return back with success message
     *
     *
     * */
    public function airportDelete($id)
    {
        CourseAirport::where('unique_id', $id)->delete();

        toastr()->success(__('SuperAdmin/backend.data_removed_successfully'));
        return back();
    }

    /*
    * function for delete course program
    *
    * @param $id
    *
    * @return back with success message
    *
    * */
    public function courseProgramDelete($id)
    {
        CourseProgram::where('unique_id', $id)->delete();
        toastr()->success(__('SuperAdmin/backend.data_removed_successfully'));
        return back();
    }

    /*
    * function for course update
    *
    * @param Request $request
    *
    * @return back with success message
    *
    * */
    public function courseUpdate(Request $request)
    {
        Course::where('unique_id', $request->id)->update([
            "language" => $request->language,
            "program_type" => $request->program_type,
            "study_mode" => $request->study_mode,
            "school_id" => $request->school_id,
            "branch" => $request->branch,
            "currency" => $request->currency,
            "program_name" => $request->program_name,
            "program_level" => $request->program_level,
            "lessons_per_week" => $request->lessons_per_week,
            "hours_per_week" => $request->hours_per_week,
            "study_time" => $request->study_time,
            "every_day" => $request->every_day,
            "about_program" => $request->about_program,
            "about_program_ar" => $request->about_program_ar
        ]);
        toastr()->success(__('SuperAdmin/backend.data_removed_successfully'));
        return back();
    }

    /*
    * function for accomodation update
    *
    * @param Request $request
    *
    * @return back with success message
    *
    * */
    public function accomodationUpdate(Request $request)
    {
        $array = [
            "type" => $request->type,
            "room_type" => $request->room_type,
            "meal" => $request->meal,
            "age_range" => $request->age_range,
            "placement_fee" => $request->placement_fee,
            "program_duration" => $request->program_duration,
            "deposit_fee" => $request->deposit_fee,
            "special_diet_fee" => $request->special_diet_fee,
            "special_diet_note" => $request->special_diet_note,
            "fee_per_week" => $request->fee_per_week,
            "start_week" => $request->start_week,
            "end_week" => $request->end_week,
            "start_date" => $request->start_date,
            "end_date" => $request->end_date,
            "discount_per_week" => $request->discount_per_week . " " . $request->discount_per_week_symbol,
            "discount_per_week_symbol" => $request->discount_per_week_symbol,
            "discount_start_date" => $request->discount_start_date,
            "discount_end_date" => $request->discount_end_date,
            "summer_fee_per_week" => $request->summer_fee_per_week,
            "summer_fee_start_date" => $request->summer_fee_start_date,
            "summer_fee_end_date" => $request->summer_fee_end_date,
            "peak_time_fee_per_week" => $request->peak_time_fee_per_week,
            "peak_time_fee_start_date" => $request->peak_time_fee_start_date,
            "peak_time_fee_end_date" => $request->peak_time_fee_end_date,
            "christmas_fee_per_week" => $request->christmas_fee_per_week,
            "christmas_fee_start_date" => $request->christmas_fee_start_date,
            "christmas_fee_end_date" => $request->christmas_fee_end_date,
        ];
        CourseAccommodation::where('unique_id', $request->id)->update($array);
        toastr()->success(__('SuperAdmin/backend.data_removed_successfully'));
        return back();
    }

    /*
    * function for delete course accomodation under age
    *
    * @param $id
    *
    * @return back with success message
    *
    * */
    public function courseAccommodationUnderAgeDelete($id)
    {
        CourseAccommodationUnderAge::find($id)->delete();
        toastr()->success(__('SuperAdmin/backend.data_removed_successfully'));
        return back();
    }

    /*
     * function for updating airport
     *
     * @param Request $request
     *
     * @return back with success message
     *
     * */
    public function airportUpdate(Request $request)
    {
        $airport = CourseAirport::where('unique_id', $request->id);
        $input = $request->except('_token', 'id');
        $airport->fill($input)->save();

        toastr()->success(__('SuperAdmin/backend.data_updated'));
        return back();
    }

    /*
    * function for updating medical fees
    *
    * @param Request $request
    *
    * @return back with success message
    *
    * */
    public function medicalUpdate(Request $request)
    {
        $medical = CourseMedicalFee::where('unique_id', $request->id);
        $medical->fill($request->except('_token', 'id'))->save();

        toastr()->success(__('SuperAdmin/backend.data_updated'));

        return back();
    }

    /*
    * function for course program
    *
    * @param Request $request
    *
    * @return back with success message
    *
    * */
    public function courseProgramUpdate(Request $request)
    {
        $courseprogram = CourseProgram::where('unique_id', $request->id);

        $courseprogram->fill($request->except('_token', 'id'))->save();
        toastr(__('SuperAdmin/backend.data_updated'), 'success');
        return $courseprogram;
    }

    /*
    * function for course accomodation under age
    *
    * @param Request $request
    *
    * @return back with success message
    *
    * */
    public function courseAccommodationUnderAgeUpdate(Request $request)
    {
        CourseAccommodationUnderAge::find($request->id)->update(['under_age_fee_per_week' => $request->under_age_fee_per_week, 'under_age' => $request->under_age]);

        toastr()->success(__('SuperAdmin/backend.data_updated'));
        return back();
    }

    public function assignCoursePermission(Request $request)
    {
        $assignpermission = new AssignCoursePermissionToUserService();
        return $assignpermission->AsssignCoursePermissionToUser($request);
    }
}