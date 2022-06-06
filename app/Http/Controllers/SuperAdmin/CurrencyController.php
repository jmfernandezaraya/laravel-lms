<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;

use App\Http\Requests\SuperAdmin\CurrencyRequest;

use App\Models\UserCourseBookedDetails;

use App\Models\SuperAdmin\CurrencyExchangeRate;
use App\Models\SuperAdmin\Choose_Language;
use App\Models\SuperAdmin\Course;
use App\Models\SuperAdmin\TransactionRefund;

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

        toastr()->success(__('SuperAdmin/backend.data_saved'));

        return redirect()->route('superadmin.currency.index');
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
    public function update(Request $request, $id)
    {
        $currency = CurrencyExchangeRate::find($id);
        $rules = [
            'name' => 'required',
            'exchange_rate' => 'required|numeric|min:0|not_in:0',
        ];
        $this->validate($request, $rules);
        $currency->name = $request->name;
        $currency->exchange_rate = $request->exchange_rate;
        $currency->save();

        $currency_ratio = $currency->exchange_rate / $request->exchange_rate;

        $course_ids = Course::where('currency', $id)->pluck('unique_id')->toArray();
        for ($course_index = 0; $course_index < count($course_ids); $course_index++) {
            $course_ids[$course_index] = '' . $course_ids[$course_index];
        }
        $user_course_booked_details = UserCourseBookedDetails::whereIn('course_id', $course_ids)->get();
        foreach ($user_course_booked_details as $user_course_booked_detail) {
            if ($user_course_booked_detail->status == 'application_cancelled' || $user_course_booked_detail->status == 'completed' || $user_course_booked_detail->paid_amount == $user_course_booked_detail->total_balance) {
                $user_course_booked_detail->total_cost = $user_course_booked_detail->total_cost * $currency_ratio;
            }
            $user_course_booked_detail->paid_amount = $user_course_booked_detail->paid_amount * $currency_ratio;
            $user_course_booked_detail->save();
            $user_course_booked_detail->transaction->amount = $user_course_booked_detail->transaction->amount * $currency_ratio;
            $user_course_booked_detail->transaction->amount_added = $user_course_booked_detail->transaction->amount_added * $currency_ratio;
            $user_course_booked_detail->transaction->save();
            $transaction_refunds = TransactionRefund::where('transaction_id', $user_course_booked_detail->transaction->order_id)->get();
            foreach ($transaction_refunds as $transaction_refund) {
                if ($transaction_refund->amount_refunded) {
                    $transaction_refund->amount_refunded = $transaction_refund->amount_refunded * $currency_ratio;
                    $transaction_refund->save();
                }
            }
        }

        return redirect()->route('superadmin.currency.index');
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

        return redirect()->route('superadmin.currency.index');
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
            toastr()->error(__('SuperAdmin/backend.course_has_currency'));
            return back();
        }

        $currency->delete();
        toastr()->success(__('SuperAdmin/backend.data_deleted'));
        return back();
    }
}