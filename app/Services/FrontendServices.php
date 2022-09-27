<?php

namespace App\Services;

use App\Models\Course;
use App\Models\CourseProgram;
use App\Models\ChooseProgramAge;
use App\Models\ChooseStudyTime;

use Illuminate\Http\Request;

class FrontendServices {
    public static function getPrograms(Request $request)
    {
        $courses = Course::with('coursePrograms')->where('school_id', $request->id)
            ->where('display', true)
            ->where('deleted', false)
            ->where('language', 'LIKE', '%"' . $request->language . '"%')
            ->where('study_mode', 'LIKE', '%"' . $request->study_mode . '"%')
            ->whereHas('coursePrograms', function ($query) use ($request) {
                $query->where('program_age_range', 'LIKE', '%"' . $request->age . '"%');
            })->get();

        $output_html = '';
        foreach($courses as $course) {
            if ($course->coursePrograms && count($course->coursePrograms)) {
                $program_name = app()->getLocale() == 'en' ? ucwords($course->program_name) : ucwords($course->program_name_ar);
                $agevalues = getCourseMinMaxAgeRange('' . $course->unique_id);
                $minagevalue = $agevalues['min'];
                $maxagevalue = $agevalues['max'];
                $age = $minagevalue . " - " . $maxagevalue;

                $course_study_time_names = '';
                $course_study_times = ChooseStudyTime::whereIn('unique_id', $course->study_time)->get();
                foreach ($course_study_times as $course_study_time) {
                    if ($course_study_time_names) $course_study_time_names .= ' ';
                    $course_study_time_names .= $course_study_time->name;
                }
    
                $url = route('frontend.course.single', ['school_id' => $course->school_id, 'program_id' => $course->unique_id]);
                $output_html .= "<div class='sub-course mt-3'>
                    <div class='row'>
                        <div class='col-md-2'>
                            <h5>$program_name</h5>
                        </div>
                        <div class='col-md-8'>
                            <div class='row'>
                                <div class='col-md-3 p-0'>
                                    <ul class='d-flex degree-work p-0'>
                                        <li><i class='fa fa-graduation-cap' aria-hidden='true'></i></li>
                                        <li>" . __('Frontend.lesson_week') . "<br><span>$course->lessons_per_week</span></li>
                                    </ul>
                                </div>
                                <div class='col-md-3 p-0'>
                                    <ul class='d-flex degree-work p-0'>
                                        <li><i class='fa fa-graduation-cap' aria-hidden='true'></i></li>
                                        <li>" . __('Frontend.hour_week') . "<br><span>$course->hours_per_week</span></li>
                                    </ul>
                                </div>
                                <div class='col-md-3 p-0'>
                                    <ul class='d-flex degree-work p-0'>
                                        <li><i class='fa fa-graduation-cap' aria-hidden='true'></i></li>
                                        <li>" . __('Frontend.required_level') . "<br><span>$course->program_level</span></li>
                                    </ul>
                                </div>
                                <div class='col-md-3 p-0'>
                                    <ul class='d-flex degree-work p-0'>
                                        <li><i class='fa fa-graduation-cap' aria-hidden='true'></i></li>
                                        <li>" . __('Frontend.study_time') . "<br><span>$course_study_time_names</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-2'>
                            <a href='$url'><button type='button' class='btn btn-primary mt-1 choose'>" . __('Frontend.choose_this_program') . "</button></a>
                        </div>
                    </div>
                </div>";
            }
        }

        return html_entity_decode($output_html);
    }
}