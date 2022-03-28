<?php


namespace App\Models;
use App\Models\SuperAdmin\SchoolAdminCourseEditPermissions;
use App\Models\SuperAdmin\UsersSchools;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class SchoolAdminUser
 * @package App\Models
 */
class SchoolAdminUser extends User
{

    protected $table = 'users';


}
