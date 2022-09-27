<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikedSchool extends Model
{
    use HasFactory;
    protected $table = 'likedschools';
    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
