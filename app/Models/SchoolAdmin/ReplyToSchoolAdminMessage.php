<?php

namespace App\Models\SchoolAdmin;

use App\Models\SuperAdmin\ToSchoolAdminMessage;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyToSchoolAdminMessage extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = ['attachment' => 'array'];

    public function messageFromSuperAdmin()
    {
        return $this->belongsTo(ToSchoolAdminMessage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}