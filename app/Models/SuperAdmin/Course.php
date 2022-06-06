<?php

namespace App\Models\SuperAdmin;

use App\Classes\BindsDynamically;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'courses';

    protected $primaryKey = 'unique_id';
    
    protected $casts = [
        'under_age' => 'array',
        'program_type' => 'array',
        'study_mode' => 'array',
        'study_time' => 'array',
        'start_date' => 'array',
        'classes_day' => 'array',
        'age_range' => 'array',
        'language' => 'array',
        'classes_day' => 'array'
    ];

    public function accomodation()
    {
        return $this->hasOne('App\Models\SuperAdmin\CourseAccommodation', 'course_unique_id');
    }

    public function accomodations()
    {
        return $this->hasMany('App\Models\SuperAdmin\CourseAccommodation', 'course_unique_id')->orderBy('order', 'asc');
    }

    public function courseProgram()
    {
        return $this->hasOne('App\Models\SuperAdmin\CourseProgram', 'course_unique_id');
    }

    public function coursePrograms()
    {
        return $this->hasMany('App\Models\SuperAdmin\CourseProgram', 'course_unique_id')->orderBy('order', 'asc');
    }

    public function airport()
    {
        return $this->hasOne('App\Models\SuperAdmin\CourseAirport', 'course_unique_id');
    }

    public function airports()
    {
        return $this->hasMany('App\Models\SuperAdmin\CourseAirport', 'course_unique_id')->orderBy('order', 'asc');
    }

    public function medical()
    {
        return $this->hasOne('App\Models\SuperAdmin\CourseMedical', 'course_unique_id');
    }

    public function medicals()
    {
        return $this->hasMany('App\Models\SuperAdmin\CourseMedical', 'course_unique_id')->orderBy('order', 'asc');
    }

    public function getMedicalInsuranceFees($value)
    {
        return $this->medicals->where('medical_start_date', '<=', $value)->where('medical_end_date', '>=', $value)->first()['medical_fees_per_week'];
    }

    public function custodian()
    {
        return $this->hasOne('App\Models\SuperAdmin\CourseCustodian', 'course_unique_id');
    }

    public function custodians()
    {
        return $this->hasMany('App\Models\SuperAdmin\CourseCustodian', 'course_unique_id')->orderBy('order', 'asc');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id', 'id');
    }

    public function getCurrency()
    {
        return $this->belongsTo(CurrencyExchangeRate::class, 'currency');
    }

    public function schoolForBranchAdmin()
    {
        return $this->belongsTo(School::class, 'school_id', 'id')->whereIn("branch_name", getBranchesForBranchAdmin());
    }

    public function userCourseBookedDetails()
    {
        return $this->hasMany(\App\Models\UserCourseBookedDetails::class, 'course_id', 'id');
    }
}
