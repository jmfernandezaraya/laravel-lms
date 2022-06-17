<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseApplicationFee extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function courseApplication()
    {
        return $this->belongsTo(CourseApplication::class);
    }
}