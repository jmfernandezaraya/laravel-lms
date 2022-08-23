<?php

namespace App\Models\SuperAdmin;

use App\Models\SuperAdmin\Country;
use App\Models\SuperAdmin\ChooseNationality;

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
        return $this->belongsTo(ChooseNationality::class, 'nationality_id', 'unique_id');
    }
}