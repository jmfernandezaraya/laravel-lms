<?php

namespace App\Models;

use App\Models\CouponUsage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $primaryKey = 'unique_id';
    protected $fillable = ['name', 'code', 'discount', 'type', 'number_of_weeks', 'start_date', 'end_date', 'affiliate_id'];
    protected $casts = [ 'course_unique_ids' => 'array' ];

    public function usages()
    {
        return $this->hasMany(CouponUsage::class, 'coupon_id', 'unique_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function afflicate_user()
    {
        return $this->belongsTo(User::class, 'affiliate_id', 'id');
    }
}