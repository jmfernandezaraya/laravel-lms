<?php

namespace App\Models;

use App\Models\CourseApplication;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseApplicationApprove extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    protected $casts = ['heard_where' => 'array'];

    public function courseApplication()
    {
        return $this->belongsTo(CourseApplication::class);
    }
}