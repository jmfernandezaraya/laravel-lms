<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;

use App\Http\Requests\SuperAdmin\CurrencyRequest;
use App\Models\SuperAdmin\CurrencyExchangeRate;
use App\Models\SuperAdmin\Choose_Language;

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
            'exchange_rate' => 'required',
        ];
        $this->validate($request, $rules);
        $currency->name = $request->name;
        $currency->exchange_rate = $request->exchange_rate;
        $currency->save();

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
     * @param CurrencyExchangeRate $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy(CurrencyExchangeRate $currency)
    {
        $currency->delete();
        return back();
    }
}
