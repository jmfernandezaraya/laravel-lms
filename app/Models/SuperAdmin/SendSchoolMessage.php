<?php

namespace App\Models\SuperAdmin;

use App\Models\SchoolAdmin\ReplyToSendSchoolMessage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendSchoolMessage extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function replyFromSchool()
    {
        return $this->hasMany(ReplyToSendSchoolMessage::class);
    }

    public function setAttachmentAttribute($value)
    {
        $this->attributes['attachment'] =  'public/attachments/'.$value;
    }

}