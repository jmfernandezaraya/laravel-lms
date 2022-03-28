<?php

namespace App\Models\SuperAdmin;

use App\Models\UserCourseBookedDetails;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCourseBookedDetailsApproved extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    protected $casts = ['heard_where' => 'array'];

    public function userCourseBooked()
    {
        return $this->belongsTo(UserCourseBookedDetails::class);
    }
}