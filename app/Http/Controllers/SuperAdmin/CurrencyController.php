<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;

use App\Http\Requests\SuperAdmin\CurrencyRequest;

use App\Models\CourseApplication;

use App\Models\SuperAdmin\CurrencyExchangeRate;
use App\Models\SuperAdmin\Choose_Language;
use App\Models\SuperAdmin\Course;
use App\Models\SuperAdmin\TransactionRefund;

use TelrGateway\Transaction;

/**
 * Class CurrencyController
 * @package App\Http\Controllers\SuperAdmin
 */
class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currencies = CurrencyExchangeRate::all();

        return view('superadmin.currency.index', compact('currencies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('superadmin.currency.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\CurrencyRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CurrencyRequest $request, CurrencyExchangeRate $currency)
    {
        $currency->fill($request->validated())->save();

        toastr()->success(__('Admin/backend.data_saved_successfully'));

        return redirect()->route('superadmin.setting.currency.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @param CurrencyExchangeRate $currencyExchangeRate
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $currency = CurrencyExchangeRate::find($id);

        return view('superadmin.currency.edit', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(CurrencyRequest $request, $id)
    {
        $currency = CurrencyExchangeRate::find($id);
        $currency_ratio = $currency->exchange_rate / $request->exchange_rate;

        $course_ids = Course::where('currency', $id)->pluck('unique_id')->toArray();
        for ($course_index = 0; $course_index < count($course_ids); $course_index++) {
            $course_ids[$course_index] = '' . $course_ids[$course_index];
        }
        $course_applications = CourseApplication::whereIn('course_id', $course_ids)->get();
        foreach ($course_applications as $course_application) {
            $paid_amount = 0;
            $amount_added = 0;
            $amount_refunded = 0;
            if ($course_application->transaction) {
                $paid_amount = $course_application->transaction->amount;
                $transaction_refunds = TransactionRefund::where('transaction_id', $course_application->transaction->order_id)->get();
                foreach ($transaction_refunds as $transaction_refund) {
                    $amount_added += $transaction_refund->amount_added;
                    $amount_refunded += $transaction_refund->amount_refunded;
                }
            }
            $amount_paid = $course_application->paid_amount + $amount_added - $amount_refunded;
            $amount_due = $course_application->total_cost_fixed - $amount_paid;
            if (($course_application->status != 'application_cancelled' && $course_application->status != 'completed') && $amount_due != 0) {
                $course_application->total_cost_fixed = $course_application->total_cost * $currency_ratio;
            }
            $course_application->save();
        }

        $currency->fill($request->validated())->save();

        return redirect()->route('superadmin.setting.currency.index');
    }

    public function setDefault(Request $request, $id)
    {
        $currencies = CurrencyExchangeRate::all();
        foreach($currencies as $currency) {
            $currency->is_default = false;
            $currency->save();
        }

        $currency = CurrencyExchangeRate::find($id);
        $currency->is_default = true;
        $currency->save();

        return redirect()->route('superadmin.setting.currency.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $currency = CurrencyExchangeRate::find($id);

        $course_ids = Course::where('currency', $id)->pluck('unique_id')->toArray();
        if (count($course_ids)) {
            toastr()->error(__('Admin/backend.course_has_currency'));
            return back();
        }

        $currency->delete();
        toastr()->success(__('Admin/backend.data_deleted_successfully'));
        return back();
    }
}