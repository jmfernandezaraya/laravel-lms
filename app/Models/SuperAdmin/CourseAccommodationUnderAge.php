<?php

namespace App\Models\SuperAdmin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseAccommodationUnderAge extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts  = ['under_age' => 'array'];
    protected $table = 'course_accommodation_under_age';
}