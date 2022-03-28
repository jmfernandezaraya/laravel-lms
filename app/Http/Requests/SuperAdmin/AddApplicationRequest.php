<?php

namespace App\Http\Requests\SuperAdmin;

use Illuminate\Foundation\Http\FormRequest;

class AddApplicationRequest extends FormRequest
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
            'application_center_en' => 'required|unique:visa_application_centers',
            'application_center_ar' => 'required|unique:visa_application_centers'
        ];
    }

    public function messages()
    {
        return [

            'application_center_en.required' => __('SuperAdmin/backend.visa_form.required_in_english'),
            'application_center_ar.required' => __('SuperAdmin/backend.visa_form.required_in_arabic'),
            'application_center_en.unique' => __('SuperAdmin/backend.visa_form.already_exists_in_english'),
            'application_center_ar.unique' => __('SuperAdmin/backend.visa_form.already_exists_in_arabic'),

        ];
    }
}
