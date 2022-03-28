<?php

namespace App\Classes;

/**
 * Interface TransactionCalculatorInterface
 * @package App\Classes
 */
interface TransactionCalculatorInterface {
    /**
     * @param $id
     * @return mixed
     */
    public function amountPaidByStudent();

    /**
     * @return mixed
     */
    public function amountAdded();

    /**
     * @return mixed
     */
    public function amountRefunded();


    /**
     * @return mixed
     */
    public function amountDue($amount);
}