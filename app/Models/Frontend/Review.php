<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'author_id', 'id');
    }

    public function course_booked_details()
    {
        return $this->belongsTo('App\Models\User', 'user_course_booked_details_id', 'id');
    }
}