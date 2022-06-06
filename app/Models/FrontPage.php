<?php

namespace App\Models;

use App\Traits\StorageTrait;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrontPage extends Model
{
    use HasFactory;
    use StorageTrait;
}