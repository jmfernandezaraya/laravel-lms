<?php

namespace App\Models\SuperAdmin;

use App\Models\SuperAdmin\Coupon;
use App\Models\CourseApplication;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponUsage extends Model
{
    use HasFactory;

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id', 'unique_id');
    }

    public function course_application()
    {
        return $this->belongsTo(CourseApplication::class, 'course_application_id', 'unique_id');
    }
}