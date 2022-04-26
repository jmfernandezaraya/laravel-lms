<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCourseBookedStatus extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function userCourseBooked()
    {
        return  $this->belongsTo(UserCourseBookedDetails::class, 'user_course_booked_detail_id');
    }
}