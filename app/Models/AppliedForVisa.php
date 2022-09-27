<?php

namespace App\Models;

use App\Models\AddNationality;
use App\Models\AddTypeOfVisa;
use App\Models\AddWhereToTravel;
use App\Models\ApplyFrom;
use App\Models\VisaApplicationCenter;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppliedForVisa extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts =['other_fields'=> 'json'];

    public function visaCenter()
    {
        return $this->belongsTo(VisaApplicationCenter::class, 'visa_center', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function applyingFrom()
    {
        return $this->belongsTo(ApplyFrom::class, 'applyfrom');
    }

    public function typeOfVisa()
    {
        return $this->belongsTo(AddTypeOfVisa::class, 'visa');
    }

    public function whereToTravel()
    {
        return $this->belongsTo(AddWhereToTravel::class, 'travel');
    }


    public function getNationality()
    {
        return $this->belongsTo(AddNationality::class, 'nationality');

    }
}
