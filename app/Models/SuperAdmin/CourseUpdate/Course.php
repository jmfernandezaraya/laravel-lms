<?php

namespace App\Models\SuperAdmin\CourseUpdate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Classes\BindsDynamically;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $primaryKey = 'unique_id';
    protected $table = 'courses_en';
    protected $casts = [
        'under_age' => 'array',
        'program_type' => 'array',
        'branch' => 'array',
        'study_mode' => 'array',
        'study_time' => 'array',
        'start_date' => 'array',
        'classes_day' => 'array',
        'age_range' => 'array',
        'language' => 'array',
        'classes_day' => 'array'
    ];

    protected $guarded = [];

    public function accomodations()
    {
        return $this->hasMany('App\Models\SuperAdmin\Accommodation', 'course_unique_id', 'unique_id');
    }

    public function accomodation()
    {
        return $this->hasOne('App\Models\SuperAdmin\Accommodation', 'course_unique_id', 'unique_id');
    }

    public function courseProgram()
    {
        return $this->hasOne('App\Models\SuperAdmin\CourseProgram', 'course_unique_id', 'unique_id');
    }

    public function coursePrograms()
    {
        return $this->hasMany(CourseProgram::class, 'course_unique_id', 'unique_id');
    }

    public function getMinimumAge()
    {
        $program_get = $this->coursePrograms()->get();

        $age_range_start =[];
        foreach ($program_get as $program) {
            $age_range_start[] = $program->program_age_range;
        }
        $age_range_starts[] =  array_filter($age_range_start);

        if (is_array($age_range_starts) && $age_range_starts !=null) {
            (sort($age_range_starts));
            $age_range_starts =  call_user_func_array('array_merge', $age_range_starts);
            if(count($age_range_starts) > 0){
                return min($age_range_starts);
            }
            return $age_range_starts;
        }
        return null;
    }

    public function getMaximumAge()
    {
        $program_get = $this->coursePrograms()->get();

        $age_range_start = [];
        foreach ($program_get as $program) {
            $age_range_start[] = $program->program_age_range;
        }
        $age_range_starts[] =   array_filter($age_range_start);
        (sort($age_range_starts));
        if($age_range_starts != null && is_array($age_range_starts)) {
            $age_range_starts = call_user_func_array('array_merge', $age_range_starts);
            if(count($age_range_starts) > 0) {
                return max($age_range_starts);
            }
            return $age_range_starts;
        }
        return null;
    }

    public function airport()
    {
        return $this->hasOne('App\Models\SuperAdmin\CourseAirport', 'course_unique_id', 'unique_id');
    }

    public function airports()
    {
        return $this->hasMany('App\Models\SuperAdmin\CourseAirport', 'course_unique_id', 'unique_id');
    }

    public function medical()
    {
        return $this->hasOne('App\Models\SuperAdmin\CourseMedicalFee', 'course_unique_id', 'unique_id');
    }

    public function medicals()
    {
        return $this->hasMany('App\Models\SuperAdmin\CourseMedicalFee', 'course_unique_id', 'unique_id');
    }

    public function getMedicalInsuranceFees($value)
    {
        return $this->medicals->where('start_date', '<=', $value)->where('end_date', '>=', $value)->first()['fees_per_week'];
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id', 'id');
    }
}