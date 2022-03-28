<?php

namespace App\Models\SchoolAdmin;

use App\Models\SuperAdmin\SendSchoolMessage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyToSendSchoolMessage extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = ['attachment' => 'array'];
    public function messageFromSuperAdmin()
    {
        return $this->belongsTo(SendSchoolMessage::class);
    }

    public function user(){

        return $this->belongsTo(User::class);
    }
}
