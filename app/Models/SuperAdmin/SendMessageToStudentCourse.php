<?php

namespace App\Models\SuperAdmin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendMessageToStudentCourse extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = ['attachment' => 'array'];
}
