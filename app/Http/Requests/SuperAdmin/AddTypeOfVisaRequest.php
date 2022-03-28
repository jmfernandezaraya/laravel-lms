<?php

namespace App\Http\Requests\SuperAdmin;

use Illuminate\Foundation\Http\FormRequest;

class AddTypeOfVisaRequest extends FormRequest
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
            'visa_en' => 'required|unique:add_type_of_visas',
            'visa_ar' => 'required|unique:add_type_of_visas'
        ];
    }

    public function messages()
    {
        return [

            'visa_en.required' => __('SuperAdmin/backend.visa_form.required_in_english'),
            'visa_ar.required' => __('SuperAdmin/backend.visa_form.required_in_arabic'),
            'visa_en.unique' => __('SuperAdmin/backend.visa_form.already_exists_in_english'),
            'visa_ar.unique' => __('SuperAdmin/backend.visa_form.already_exists_in_arabic'),

        ];
    }
}
