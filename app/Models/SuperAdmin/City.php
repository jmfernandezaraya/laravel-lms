<?php

namespace App\Models\SuperAdmin;

use App\Models\SuperAdmin\Country;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
}