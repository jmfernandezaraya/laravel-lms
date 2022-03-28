<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use TelrGateway\Transaction;

/**
 * Class PaymentController
 * @package App\Http\Controllers\SchoolAdmin
 */
class PaymentController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $payments = Transaction::all();
        $success = __('SuperAdmin/backend.errors.success');
        $failed = __('SuperAdmin/backend.errors.failed');

		return view('schooladmin.payment.index', ['success' => $success, 'failed' => $failed], compact('payments'));
    }
}