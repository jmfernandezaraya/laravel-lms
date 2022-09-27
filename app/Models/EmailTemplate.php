<?php

namespace App\Models;

use App\Models\ChooseLanguage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'keywords' => 'array',
    ];
}