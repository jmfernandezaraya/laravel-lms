<?php

namespace App\Models\SuperAdmin;

use App\Models\SuperAdmin\City;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    public function cities()
    {
        return $this->hasMany(City::class, 'country_id', 'id');
    }
}