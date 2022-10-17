<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Config;

use App\Http\Controllers\Controller;

use App\Models\PaymentMethod;
use App\Models\Course;

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
        $payment_method_list = getPaymentMethodList();

        return view('superadmin.payment_method.index', compact('payment_methods', 'payment_method_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $payment_method_list = getPaymentMethodList();

        return view('superadmin.payment_method.add', compact('payment_method_list'));
    }

    private function checkEnvSetting($request)
    {
        if ($request->key == 'Telr') {
            Config::set('telr.test_mode', $request->test_mode ? true : false);
            Config::set('telr.create.ivp_store', $request->store_id);
            Config::set('telr.create.ivp_authkey', $request->store_auth_key);

            envUpdate('TELR_TEST_MODE', $request->test_mode ? true : false);
            envUpdate('TELR_STORE_ID', $request->store_id);
            envUpdate('TELR_STORE_AUTH_KEY', $request->store_auth_key);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\PaymentMethodRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'key' => 'required',
                'store_id' => 'required',
                'store_auth_key' => 'required',
                'store_secret_key' => 'sometimes',
                'test_mode' => 'required',
            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $payment_method = new PaymentMethod($validator->validated());
        $payment_method_id = (new Controller())->my_unique_id();
        $exist_payment_method = PaymentMethod::where('unique_id', $payment_method_id)->get();
        while (count($exist_payment_method)) {
            (new Controller())->my_unique_id(1);
            $payment_method_id = (new Controller())->my_unique_id();
            $exist_payment_method = PaymentMethod::where('unique_id', $payment_method_id)->get();
        }
        $payment_method->unique_id = $payment_method_id;
        $payment_method->save();

        $this->checkEnvSetting($request);

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
        $payment_method = PaymentMethod::where('unique_id', $id)->first();

        $payment_method_list = getPaymentMethodList();

        return view('superadmin.payment_method.edit', compact('payment_method', 'payment_method_list'));
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
        $validator = \Validator::make(
            $request->all(),
            [
                'key' => 'required',
                'store_id' => 'required',
                'store_auth_key' => 'required',
                'store_secret_key' => 'sometimes',
                'test_mode' => 'required',
            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        
        $payment_method = PaymentMethod::where('unique_id', $id)->first();
        $payment_method->fill($validator->validated())->save();

        $this->checkEnvSetting($request);

        toastr()->success(__('Admin/backend.data_updated_successfully'));

        return redirect()->route('superadmin.payment_method.index');
    }

    public function setDefault(Request $request, $id)
    {
        $payment_methods = PaymentMethod::all();
        foreach($payment_methods as $payment_method) {
            $payment_method->is_default = false;
            $payment_method->save();
        }

        $payment_method = PaymentMethod::where('unique_id', $id)->first();
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
        $payment_method = PaymentMethod::where('unique_id', $id)->first();

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