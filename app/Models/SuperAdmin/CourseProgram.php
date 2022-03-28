<?php

namespace App\Models\SuperAdmin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseProgram extends Model
{
    use HasFactory;

    protected $casts = ['program_age_range' => 'array'];

    protected $guarded = [];

    protected $table = 'courses_program_en';

    public function save_model($db1, $db2, $input1, $input2)
    {
        $db = \DB::transaction(function () use ($db1, $db2, $input1, $input2) {
            $db1->fill($input1)->save();
            $save1 = $db2->fill($input2)->save();
            if ($save1)
                return true;
        });

        if ($db) {
            \Session::forget(['input1', 'input2', 'db1', 'db2']);
            return true;
        }
    }

    public function course()
    {
        return $this->belongsTo('App\Models\SuperAdmin\Course', 'course_unique_id', 'unique_id');
    }

    public function courseUnderAge()
    {
        return $this->hasOne('App\Models\SuperAdmin\CourseProgramUnderAgeFee', 'course_program_id', 'unique_id');
    }

    public function courseUnderAges()
    {
        return $this->hasMany('App\Models\SuperAdmin\CourseProgramUnderAgeFee', 'course_program_id', 'unique_id');
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
      $under_age_fees = $this->courseUnderAges()->where('under_age', 'LIKE', '%'.  $array. '%')->first();

        return $under_age_fees->underage_fee_per_week;
    }

    public function courseTextBookFee()
    {
        return $this->hasOne('App\Models\CourseProgramTextBook', 'program_id', 'unique_id');
    }

    public function courseTextBookFees()
    {
        return $this->hasMany('App\Models\CourseProgramTextBook', 'program_id', 'unique_id');
    }

    public function TextBookFee($value)
    {
        $first_text_book = $this->courseTextBookFees->where('text_book_start_date', '<=', $value)->where('text_book_end_date', '>=', $value)->first();
        if ($first_text_book) return $first_text_book['text_book_fee'];
        return 0;
    }
}