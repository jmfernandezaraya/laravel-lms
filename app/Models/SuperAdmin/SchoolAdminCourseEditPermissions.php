<?php

namespace App\Models\SuperAdmin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolAdminCourseEditPermissions extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'unique_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class)->where('user_type', 'school_admin');
    }

    public function checkForPermission($course_id)
    {
        return $this->query()->where('course_id', $course_id)->where('user_id', auth('school_admin')->user()->id)->where('is_true', true)->first();
    }
}
