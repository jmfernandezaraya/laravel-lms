<?php

namespace App\Classes;

use App\Models\SuperAdmin\TransactionRefund;
use App\Models\UserCourseBookedDetails;

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
    private $userCourseBookedDetails;
    /**
     * @var
     */
    private $transactionrefundId;

    /**
     * TransactionCalculator constructor.
     * @param UserCourseBookedDetails $userCourseBookedDetails
     */
    public function __construct(UserCourseBookedDetails $userCourseBookedDetails)
    {
        $this->userCourseBookedDetails = $userCourseBookedDetails;
        $this->transactionrefundId = optional($userCourseBookedDetails->transaction)->order_id;
    }

    /**
     * @param $id
     */
    public function amountPaidByStudent()
    {
        return (float)$this->userCourseBookedDetails->paid_amount;
    }

    /**
     * @return mixed
     */
    public function amountAdded()
    {
        $transactionRefunded = TransactionRefund::where('transaction_id', $this->transactionrefundId)->first();

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
        $transactionRefunded = TransactionRefund::where('transaction_id', $this->transactionrefundId)->first();
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