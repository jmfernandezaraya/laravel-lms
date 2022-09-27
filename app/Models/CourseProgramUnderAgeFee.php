<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseProgramUnderAgeFee extends Model
{
    use HasFactory;

    protected $casts =[
        'under_age' => 'array'

    ];
    protected $guarded = [];
    protected $table = 'course_program_under_age_fees';

    public function courseProgram()
    {
        return $this->belongsTo('App\Models\CourseProgram', 'course_program_id', 'unique_id');
    }

    public function cousreTextBooks()
    {
        return $this->hasMany('App\Models\CourseProgramTextBookFee', 'course_program_id', 'course_program_id')->orderBy('id', 'asc');
    }
}