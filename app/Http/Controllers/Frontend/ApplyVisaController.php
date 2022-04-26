<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Formbuilder;
use App\Models\Frontend\AppliedForVisa;
use App\Models\SuperAdmin\AddNationality;
use App\Models\SuperAdmin\AddTypeOfVisa;
use App\Models\SuperAdmin\AddWhereToTravel;
use App\Models\SuperAdmin\ApplyFrom;
use App\Models\SuperAdmin\VisaApplicationCenter;
use App\Models\SuperAdmin\VisaForm;
use App\Models\UserCourseBookedDetails;
use Illuminate\Http\Request;

/**
 * Class ApplyVisaController
 * @package App\Http\Controllers\Frontend
 */
class ApplyVisaController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function applyForVisa()
    {
        $apply_from = ApplyFrom::all();
        $visa_center = VisaApplicationCenter::all();
        $nationality = AddNationality::all();
        $travel = AddWhereToTravel::all();
        $visa = AddTypeOfVisa::all();

        return view('frontend.apply_visa', compact('apply_from', 'visa_center', 'nationality', 'travel', 'visa'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getVisaDetails(Request $request)
    {
        extract($request->all());
        $visaform = VisaForm::with('formBuilder')->with('visaServiceFee')->with('visaOtherFee')->where("applying_from", $applyfrom)
            ->where("application_center", $visa_center)
            ->where("nationality", $nationality)
            ->where("to_travel", $travel)
            ->where("type_of_visa", $visa)
            ->first();

        $visaforms = $visaform->visaServiceFees()->where("travelers_number_start", "<=", (int)$people)
            ->where("travelers_number_end", ">=", (int)$people)->first();

        $data['success'] = true;
        $lang = $visaform->{'visa_information_' . get_language()};

        $data['information'] = html_entity_decode("<label for='inputvisa4'>Visa information and requirement</label>
                       <div class = 'form-control'> $lang</div>");
        $data['visa_fee'] = $visaform->visa_fee * (int)$people;
        $data['insurance_fee'] = $visaform->insurance_fee * (int)$people;
        $data['visa_service_fee'] = $visaforms->visa_service_fee * (int)$people;
        $data['tax_fee'] = $visaforms->tax_fee * (int)$people;
        $data['other_fees'] = '';
        $data['fetch_form_builder'] = false;
        $data['fetch_form_name'] = false;
        if (!empty($visaform->formBuilder)) {
            $data['fetch_form_builder'] = auth()->check() == true ? html_entity_decode($visaform->formBuilder->form_data) : '';
        }
        $data['other_fees'] = '';
        if (!empty($visaform->visaOtherFees)) {
            $data['otherprice'] = 0;
            $data['other_service_name'] = '';
            foreach ($visaform->visaOtherFees as $visa_other) {
                $other_price = $visa_other->other_visa_price * (int)$people;
                $data['other_fees'] .= "
                <div class='form-row'>
                    <div class='form-group col-md-6'>
                        <label for='inputEmail4'>Other Visa Fee Name</label>
                        <input readonly type='visa7' class='form-control' id='inputvisa7' placeholder='$visa_other->other_visa_name' value ='$visa_other->other_visa_name'>
                    </div>
                    <div class='form-group col-md-6'>
                        <label for='inputEmail4'>Other visa Fee Price</label>
                        <input readonly type='visa8' class='form-control' id='inputvisa8' placeholder='$other_price' value ='$other_price'>
                    </div>
                </div>";
                $data['otherprice'] += $other_price;
                $data['other_service_name'] .=    "<tr>
                            <td>Other Service Fee ({$visa_other->other_visa_name})</td>
                            <td id='other_fee'>{$other_price }SAR</td>
                        </tr>";
            }
        }

        $data['tax_fee'] = $data['tax_fee'] % $data['visa_service_fee']/*($taxfee / 100) * ($data['visa_service_fee'])*/;

        $data['form_id'] = auth()->check() == true ? (isset($visaform->formBuilder->id) ? $visaform->formBuilder->id : "") : "";
        return response($data);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getNumberOfPeople(Request $request)
    {
        extract($request->all());
        $visaform = VisaForm::with('formBuilder')->with('visaServiceFee')->with('visaOtherFee')->where("applying_from", $applyfrom)
            ->where("application_center", $visa_center)
            ->where("nationality", $nationality)
            ->where("to_travel", $travel)
            ->where("type_of_visa", $visa)
            ->first();

        // $start_people = $visaform->visaServiceFee->travelers_number_start;

        $start_people = collect($visaform->visaServiceFees)->min('travelers_number_start');
        $end_people = collect($visaform->visaServiceFees)->max('travelers_number_end');


        $getPeople = [];
        for ($people = $start_people; $people <= $end_people; $people++) {

            $getPeople[] = $people;

        }
        $select = __("SuperAdmin/backend.select_option");
        $getoption = "<option value=''>$select </option>";
        foreach ($getPeople as $peoples) {

            $getoption .= "<option value=$peoples>$peoples</option>";

        }

        $data['success'] = true;
        $data['option'] = $getoption;
        return response($data);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function applyForVisaPost(Request $request)
    {
        //dd($request->all());
        !session()->has('visa_form') ? session()->put('visa_form', 'hsa') : '';

        $formbuilder = Formbuilder::find($request->form_id)->first();

        $change_name = json_decode($formbuilder->form_data);
        /*
         *
         *
         * to check file
         * */

        $to_be_saved_field = [];

        for ($i = 0; $i < count($change_name); $i++) {
            $names = $change_name[$i]->name;
            if (isset($change_name[$i]->label)) {
                if ($change_name[$i]->type == "file" && $request->file($change_name[$i]->name)) {
                    $filenames = $change_name[$i]->name;

                    $filename_to_be_saved = time() . rand(000, 999) . "." . $request->file($filenames)->getClientOriginalExtension();
                    \Storage::put('visa_related_files/' . $filename_to_be_saved, fopen($request->file($filenames), 'r+'));
                    $filename_to_be_saveds['name'] = $filenames;
                    $filename_to_be_saveds['value'] = $filename_to_be_saved;
                    $to_be_saved_field[] = ($filename_to_be_saveds);
                } else {
                    $requesting['name'] = $change_name[$i]->name;
                    $requesting['value'] = $request->$names;

                    $to_be_saved_field[] = ($requesting);
                }
            }
        }

        $applied_id = AppliedForVisa::create([
            'user_id' => auth()->id(),
            'visa_center' => $request->visa_center,
            'other_fields' => json_encode($to_be_saved_field),
            'applyfrom' => $request->apply_form,
            'people' => $request->people_select,
            'visa' => $request->type_of_visa,
            'travel' => $request->travel,
            'nationality' => $request->nationality,
        ]);
        session()->put('applied_form_id', $applied_id->id);

        $telrManager = new \TelrGateway\TelrManager();

        $billingParams = [
            'first_name' => auth()->user()->first_name_en,
            'sur_name' => '',
            'address_1' => auth()->user()->address,
            'address_2' => '',
            'city' => auth()->user()->address,
            'region' => auth()->user()->state,
            'zip' => auth()->user()->zip,
            'country' => auth()->user()->country,
            'email' => auth()->user()->email,
        ];
        $data['data'] = 'Success';
        session()->put('paid_amount', $request->total_value);
        return $telrManager->pay(time() . rand(00, 99), $request->total_value, 'Visa Form Apply', $billingParams)->redirect();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getNationality($id)
    {
        $getNationality = VisaForm::with('getNationality')->whereApplyingFrom($id)
            ->get()->collect()->unique('getNationality.nationality_' . get_language())
            ->values()->all();

        $option = __('SuperAdmin/backend.select_option');
        $data['option'] = "<option value= ''>$option</option>";

        foreach ($getNationality as $nation) {
            $name = $nation->getNationality->{'nationality_' . get_language()};
            $id = $nation->getNationality->id;
            $data['option'] .= "<option value= '$id'>$name</option>";
        }

        return response($data);
    }

    /**
     * @param $id
     * @param $apply_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getTravel($id, $apply_id)
    {
        $getTravel = VisaForm::with('whereToTravel')->
        whereApplyingFrom($apply_id)->
        whereNationality($id)
            ->get()->collect()->unique('whereToTravel.travel_' . get_language())
            ->values()->all();

        $option = __('SuperAdmin/backend.select_option');
        $data['option'] = "<option value= ''>$option</option>";

        foreach ($getTravel as $travel) {
            $name = $travel->whereToTravel->{'travel_' . get_language()};
            $id = $travel->whereToTravel->id;
            $data['option'] .= "<option value= '$id'>$name</option>";
        }

        return response($data);
    }

    /**
     * @param $id
     * @param $apply_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getApplicationCenter($id, $apply_id)
    {
        $getOption = VisaForm::with('applicationCenter')->whereApplyingFrom($apply_id)
            ->whereTypeOfVisa($id)
            ->get()->collect()->unique('applicationCenter.application_center_' . get_language())
            ->values()->all();

        $option = __('SuperAdmin/backend.select_option');
        $data['option'] = "<option value= ''>$option</option>";

        foreach ($getOption as $option_get) {
            $name = $option_get->applicationCenter->{'application_center_' . get_language()};
            $id = $option_get->applicationCenter->id;
            $data['option'] .= "<option value= '$id'>$name</option>";
        }

        return response($data);
    }

    /**
     * @param $id
     * @param $apply_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getTypeOfVisa($id, $apply_id)
    {
        $getOption = VisaForm::with('TypeOfVisa')->whereApplyingFrom($apply_id)
            ->whereToTravel($id)
            ->get()->collect()->unique('TypeOfVisa.visa_' . get_language())
            ->values()->all();

        $option = __('SuperAdmin/backend.select_option');
        $data['option'] = "<option value= ''>$option</option>";

        foreach ($getOption as $option_get) {
            $name = $option_get->TypeOfVisa->{'visa_' . get_language()};
            $id = $option_get->TypeOfVisa->id;
            $data['option'] .= "<option value= '$id'>$name</option>";
        }

        return response($data);
    }
}