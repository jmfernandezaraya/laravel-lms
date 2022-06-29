<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\ApplyForVisaRequest;
use App\Models\SuperAdmin\VisaForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class VisaFormController
 * @package App\Http\Controllers\SuperAdmin
 */
class VisaFormController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('superadmin.visa_application.apply_visa');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show()
    {
        $visaforms = VisaForm::with("applyFrom")->with('visaOtherFee')->with('visaServiceFee')->
        get();

        return view('superadmin.visa.view_visa_forms', compact('visaforms'));
    }

    /**
     * @param ApplyForVisaRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function applyForVisa(ApplyForVisaRequest $request)
    {
        try{
            $db = \DB::transaction(function () use ($request) {
                $visaformsave = VisaForm::create([
                    'applying_from' => $request->applying_from,
                    'application_center' => $request->application_center,
                    'nationality' => $request->nationality,
                    'to_travel' => $request->to_travel,
                    'type_of_visa' => $request->type_of_visa,
                    'visa_information_en' => $request->visa_information_en,
                    'visa_information_ar' => $request->visa_information_ar,
                    'visa_fee' => $request->visa_fee,
                    'insurance_fee' => $request->insurance_fee,
                ]);


                for ($i = 0; $i < count($request->other_visa_name); $i++) {
                    $visaformsave->visaOtherFee()->create([
                        "other_visa_name" => $request->other_visa_name[$i],
                        "other_visa_price" => $request->other_visa_price[$i]
                    ]);
                }

                for ($j = 0; $j < count($request->tax_fee); $j++) {
                    $visaformsave->visaServiceFee()->create([
                        "visa_service_fee" => $request->visa_service_fee[$j],
                        "tax_fee" => $request->tax_fee[$j],
                        "travelers_number_start" => $request->travelers_number_start[$j],
                        "travelers_number_end" => $request->travelers_number_end[$j],
                    ]);
                }
                return true;
            });

            if ($db) {
                $data['success'] = true;
                $data['data'] = __('Admin/backend.errors.success');
                return response($data);
            }
        } catch(\Exception $e){
            $data['errors'] = $e->getMessage();
            $data['success'] = false;
            return response($data);
        }
        return response(false);
    }

    /**
     * @param VisaForm $visaId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(VisaForm $visaId)
    {
        $visaId->delete();

        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $visaforms = VisaForm::with("applyFrom")->with('visaOtherFees')->with('visaServiceFee')
            ->with('visaServiceFees') ->with('TypeOfVisa')->with('whereToTravel')->with('getNationality')->with('applicationCenter')->where('id', $id)->first();

        return view("superadmin.visa.edit", compact('visaforms'));
    }

    /**
     * @param Request $request
     * @param VisaForm $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $db = \DB::transaction(function () use ($request, $id) {
            $visaformsave = VisaForm::updateOrCreate(['id' => $id], [
                'applying_from' => $request->applying_from,
                'application_center' => $request->application_center,
                'nationality' => $request->nationality,
                'to_travel' => $request->to_travel,
                'type_of_visa' => $request->type_of_visa,
                'visa_information_en' => $request->visa_information_en,
                'visa_information_ar' => $request->visa_information_ar,
                'visa_fee' => $request->visa_fee,
                'insurance_fee' => $request->insurance_fee
            ]);

            $visaformsave->visaOtherFees()->delete();
            for ($i = 0; $i < count($request->other_visa_name); $i++) {
                $visaformsave->visaOtherFee()->create([
                    "other_visa_name" => $request->other_visa_name[$i],
                    "other_visa_price" => $request->other_visa_price[$i]
                ]);
            }
            $visaformsave->visaServiceFees()->delete();

            for ($j = 0; $j < count($request->tax_fee); $j++) {
                $visaformsave->visaServiceFee()->create([
                    "visa_service_fee" => $request->visa_service_fee[$j],
                    "tax_fee" => $request->tax_fee[$j],
                    "travelers_number_start" => $request->travelers_number_start[$j],
                    "travelers_number_end" => $request->travelers_number_end[$j],
                ]);
            }
            return true;
        });
        if ($db) {
            $data['success'] = true;
            $data['data'] = __('Admin/backend.errors.success');
            return response($data);

        }
        return response(false);
    }
}