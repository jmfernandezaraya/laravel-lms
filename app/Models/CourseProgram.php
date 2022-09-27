<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseProgram extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $primaryKey = 'unique_id';

    protected $table = 'course_programs';

    protected $casts = ['program_age_range' => 'array'];

    public function course()
    {
        return $this->belongsTo('App\Models\Course', 'course_unique_id');
    }

    public function courseUnderAge()
    {
        return $this->hasOne('App\Models\CourseProgramUnderAgeFee', 'course_program_id');
    }

    public function courseUnderAges()
    {
        return $this->hasMany('App\Models\CourseProgramUnderAgeFee', 'course_program_id')->orderBy('id', 'asc');
    }

    public function getUnderAge()
    {
        $under_age_gets = $this->courseUnderAges()->get();

        $under_age = [];
        foreach ($under_age_gets as $under_age_get) {
            $under_age[] = (array)$under_age_get->under_age;
        }
        $under_ages = call_user_func_array('array_merge', $under_age);

        return $under_ages;
    }

    public function getUnderAgeFees($array)
    {
      $under_age_fees = $this->courseUnderAges()->where('under_age', 'LIKE', '%' .  $array . '%')->first();

        return $under_age_fees->under_age_fee_per_week;
    }

    public function courseTextBookFee()
    {
        return $this->hasOne('App\Models\CourseProgramTextBookFee', 'course_program_id');
    }

    public function courseTextBookFees()
    {
        return $this->hasMany('App\Models\CourseProgramTextBookFee', 'course_program_id')->orderBy('id', 'asc');
    }

    public function TextBookFee($value)
    {
        $first_text_book = $this->courseTextBookFees->where('text_book_start_date', '<=', $value)->where('text_book_end_date', '>=', $value)->first();
        if ($first_text_book) return $first_text_book['text_book_fee'];
        return 0;
    }
}