<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Storage;

class Message extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'attachments' => 'array',
    ];

    public function fromUser()
    {
        return $this->belongsTo('App\Models\User', 'from_user', 'id');
    }

    public function toUser()
    {
        return $this->belongsTo('App\Models\User', 'to_user', 'id');
    }
}