<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseApplicationStatus extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function courseApplication()
    {
        return  $this->belongsTo(CourseApplication::class, 'course_application_id');
    }
}