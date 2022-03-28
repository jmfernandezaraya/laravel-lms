<?php

namespace App\Services;

use App\Models\SuperAdmin\Course;
use App\Models\SuperAdmin\CourseProgram;
use App\Models\SuperAdmin\Choose_Program_Age_Range;

use Illuminate\Http\Request;

class FrontendServices {
    public static function getPrograms(Request $request)
    {
        $courses = Course::where('school_id', $request->id)
            ->where('display', true)
            ->where('deleted', false)
            ->where('study_mode', 'LIKE', '%"' . $request->study_mode . '"%')
            ->get();

        $output_html = '';
        foreach($courses as $course) {
            $course_programs = CourseProgram::where('course_unique_id', $course->unique_id)->count();
            // where(function($q) {
            //     $q->whereNotNull('courier_fee')->where('courier_fee', '<>', '');
            // })->
            if ($course_programs) {
                $program_name = ucwords($course->program_name);
                $agevalues = getCourseMinMaxAgeRange($course->unique_id);
                $minagevalue = $agevalues['min'];
                $maxagevalue = $agevalues['max'];
                $age = $minagevalue . " - " . $maxagevalue;
    
                $url = route('course.single', ['school_id' => $course->school_id, 'program_id' => $course->unique_id]);
                $output_html .= "<div class='sub-cources mt-3'>
                    <div class='row'>
                        <div class='col-md-2'>
                            <h5> $program_name </h5>
                        </div>
                        <div class='col-md-8'>
                            <div class='row'>
                                <div class='col-md-3 p-0'>
                                    <ul class='degree-work p-0'>
                                        <li><i class='fa fa-graduation-cap' aria-hidden='true'></i></li>
                                        <li>" .  __('Frontend.lesson_week') . "<br><span>$course->lessons_per_week</span> </li>
                                    </ul>
                                </div>
                                <div class='col-md-3 p-0'>
                                    <ul class='degree-work p-0'>
                                        <li><i class='fa fa-graduation-cap' aria-hidden='true'></i></li>
                                        <li>" .  __('Frontend.hour_week') . "<br><span>$course->hours_per_week</span> </li>
                                    </ul>
                                </div>
                                <div class='col-md-3 p-0'>
                                    <ul class='degree-work p-0'>
                                        <li><i class='fa fa-graduation-cap' aria-hidden='true'></i></li>
                                        <li>" .  __('Frontend.required_level') . "<br><span>$course->program_level</span> </li>
                                    </ul>
                                </div>
                                <div class='col-md-3 p-0'>
                                    <ul class='degree-work p-0'>
                                        <li><i class='fa fa-graduation-cap' aria-hidden='true'></i></li>
                                        <li>" .  __('Frontend.age_range') . "<br><span>$age</span> </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-2'>
                            <a href='$url'><button type='button' class='btn btn-primary mt-1 choose'>" .  __('Frontend.choose_this_program') . "</button></a>
                        </div>
                    </div>
                </div>";
            }
        }

        return html_entity_decode($output_html);
    }
}