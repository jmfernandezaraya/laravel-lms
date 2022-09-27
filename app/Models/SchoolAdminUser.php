<?php

namespace App\Models;

use App\Models\SchoolAdminCourseEditPermissions;
use App\Models\UserSchool;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class SchoolAdminUser
 * @package App\Models
 */
class SchoolAdminUser extends User
{
    protected $table = 'users';
}