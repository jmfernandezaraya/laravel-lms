<?php

namespace App\Models;

use App\Classes\BindsDynamically;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calculator extends Model
{
    use HasFactory;
	use BindsDynamically;

	protected $guarded = [];

    public function __construct()
    {
        $this->setTable('calculators');
    }

    public function save_to_db($type, $value)
    {
        $this->$type = $value;
        $this->save();
    }
}