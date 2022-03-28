<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyToSuperAdminCourseMessage extends Model
{
    use HasFactory;
    protected $table = 'super_admin_received_message_student';
    protected $guarded = [];
}
