<?php

namespace App\Http\Requests\SuperAdmin;

use Illuminate\Foundation\Http\FormRequest;

class ApplyForVisaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'applying_from' => 'required',
            'application_center' => 'required',
            'nationality' => 'required',
            'to_travel' => 'required',
            'type_of_visa' => 'required',

            'visa_fee' => 'required',
            'insurance_fee' => 'required',
            'other_visa_name.*' => 'required',
            'other_visa_price.*' => 'required',
            'visa_service_fee.*' => 'required',
            'tax_fee.*' => 'required',
            'travelers_number_start.*' => 'required',
            'travelers_number_end.*' => 'required',

        ];
    }

    public function messages()
    {
        return [


            'applying_from.required' => "Applying From Required",
            'application_center.required' => "Application Center Required" ,
            'nationality.required' =>  "Nationality Required",
            'to_travel.required' => "Travel field required",
            'type_of_visa.required' => "Type of visa required",

            'visa_fee.required' => "Visa Fee Required",
            'insurance_fee.required' => "Insurance Fee Required",
            'other_visa_name.*.required' => "Other visa name Required",
            'other_visa_price.*.required' => "Other visa price Required",
            'visa_service_fee.*.required' => "Visa service fee Required",
            'tax_fee.*.required' => "Tax fee Required",
            'travelers_number_start.*.required' => "Travelers number start Required",
            'travelers_number_end.*.required' => "Travelers number end Required",
        ];
    }
}
