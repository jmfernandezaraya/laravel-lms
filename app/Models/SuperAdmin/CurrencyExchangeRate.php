<?php

namespace App\Models\SuperAdmin;

use App\Models\SuperAdmin\ChooseLanguage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyExchangeRate extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    protected $table = 'currency_exchange_rates';

    public function language()
    {
        return $this->belongsTo(ChooseLanguage::class, 'language_id', 'unique_id');
    }
}