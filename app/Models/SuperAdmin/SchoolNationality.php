<?php

namespace App\Models\SuperAdmin;

use App\Models\Country;
use App\Models\SuperAdmin\Choose_Nationality;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolNationality extends Model
{
    use HasFactory;
    
    public function school()
    {
        return $this->belongsTo(School::class, 'id', 'school_id');
    }
    
    public function nationality()
    {
        return $this->belongsTo(Choose_Nationality::class, 'nationality_id', 'unique_id');
    }
}