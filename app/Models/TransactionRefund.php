<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TelrGateway\Transaction;

/**
 * Class TransactionRefund
 * @package App\Models\SuperAdmin
 */
class TransactionRefund extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getTransaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'order_id');
    }

    /**
     * @return int|mixed
     */
    public function getTransactionRefunded()
    {
        return $this->query()->whereNotNull('amount_refunded')->sum('amount_refunded');
    }

    /**
     * @return int|mixed
     */
    public function getTransactionAdded()
    {
        return $this->query()->whereNotNull('amount_added')->sum('amount_added');
    }
}