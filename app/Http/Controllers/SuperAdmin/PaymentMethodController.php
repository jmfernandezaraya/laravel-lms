<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;

use App\Http\Requests\SuperAdmin\PaymentMethodRequest;

use App\Models\CourseApplication;

use App\Models\PaymentMethod;
use App\Models\ChooseLanguage;
use App\Models\Course;
use App\Models\TransactionRefund;

use TelrGateway\Transaction;

/**
 * Class PaymentMethodController
 * @package App\Http\Controllers\SuperAdmin
 */
class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payment_methods = PaymentMethod::all();

        return view('superadmin.payment_method.index', compact('payment_methods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('superadmin.payment_method.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\PaymentMethodRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentMethodRequest $request, PaymentMethod $payment_method)
    {
        $payment_method->fill($request->validated())->save();

        toastr()->success(__('Admin/backend.data_saved_successfully'));

        return redirect()->route('superadmin.payment_method.index');
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
     * @param PaymentMethod $payment_methodExchangeRate
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payment_method = PaymentMethod::find($id);

        return view('superadmin.payment_method.edit', compact('payment_method'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentMethodRequest $request, $id)
    {
        $payment_method = PaymentMethod::find($id);

        $payment_method->fill($request->validated())->save();

        return redirect()->route('superadmin.payment_method.index');
    }

    public function setDefault(Request $request, $id)
    {
        $payment_methods = PaymentMethod::all();
        foreach($payment_methods as $payment_method) {
            $payment_method->is_default = false;
            $payment_method->save();
        }

        $payment_method = PaymentMethod::find($id);
        $payment_method->is_default = true;
        $payment_method->save();

        return redirect()->route('superadmin.payment_method.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment_method = PaymentMethod::find($id);

        $course_ids = Course::where('payment_method', $id)->pluck('unique_id')->toArray();
        if (count($course_ids)) {
            toastr()->error(__('Admin/backend.course_has_payment_method'));
            return back();
        }

        $payment_method->delete();
        toastr()->success(__('Admin/backend.data_deleted_successfully'));
        return back();
    }
}