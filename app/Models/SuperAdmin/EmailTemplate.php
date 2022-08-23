<?php

namespace App\Models\SuperAdmin;

use App\Models\SuperAdmin\ChooseLanguage;

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