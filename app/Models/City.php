<?php

namespace App\Models;

use App\Models\Country;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public function cities()
    {
        return $this->belongsTo(Country::class, 'id', 'country_id');
    }
}