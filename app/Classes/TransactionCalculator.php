<?php

namespace App\Classes;

use App\Models\TransactionRefund;
use App\Models\CourseApplication;

/**
 * Class TransactionCalculator
 * @package App\Classes
 */
class TransactionCalculator implements TransactionCalculatorInterface
{
    /**
     * @var
     */
    public $id;
    /**
     * @var
     */
    private $courseApplicationDetails;
    /**
     * @var
     */
    private $transactionRefundId;

    /**
     * TransactionCalculator constructor.
     * @param CourseApplication $courseApplicationDetails
     */
    public function __construct(CourseApplication $courseApplicationDetails)
    {
        $this->courseApplicationDetails = $courseApplicationDetails;
        $this->transactionRefundId = optional($courseApplicationDetails->transaction)->order_id;
    }

    /**
     * @param $id
     */
    public function amountPaidByStudent()
    {
        return (float)$this->courseApplicationDetails->paid_amount;
    }

    /**
     * @return mixed
     */
    public function amountAdded()
    {
        $transactionRefunded = TransactionRefund::where('transaction_id', $this->transactionRefundId)->first();

        if ($transactionRefunded && $transactionRefunded->getTransactionAdded()) {
            return (float)$transactionRefunded->getTransactionAdded();
        }
        return 0;
    }

    /**
     * @return mixed
     */
    public function amountRefunded()
    {
        $transactionRefunded = TransactionRefund::where('transaction_id', $this->transactionRefundId)->first();
        if ($transactionRefunded &&  $transactionRefunded->getTransactionRefunded()) {
            return (float)$transactionRefunded->getTransactionRefunded();
        }
        return 0;
    }

    /**
     * @return mixed|string
     */
    public function amountDue($amount)
    {
        $total = ($amount - $this->amountPaidByStudent() - $this->amountAdded()) + $this->amountRefunded();
        return number_format($total, 2);
    }
}