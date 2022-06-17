<?php

namespace App\Models\SuperAdmin;

use App\Models\SchoolAdmin\ReplyToSchoolAdminMessage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToSchoolAdminMessage extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function courseBookedDetail()
    {
        return $this->belongsTo('App\Models\CourseApplication', 'course_application_id', 'id');
    }

    public function replyFromSchool()
    {
        return $this->hasMany(ReplyToSchoolAdminMessage::class);
    }

    public function setAttachmentAttribute($value)
    {
        $this->attributes['attachment'] = 'public/attachments/' . $value;
    }
}