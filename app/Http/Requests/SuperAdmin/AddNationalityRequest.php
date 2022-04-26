<?php

namespace App\Http\Requests\SuperAdmin;

use Illuminate\Foundation\Http\FormRequest;

class AddNationalityRequest extends FormRequest
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
            'nationality_en' => 'required|unique:add_nationalities',
            'nationality_ar' => 'required|unique:add_nationalities'
        ];
    }

    public function messages()
    {
        return [

            'nationality_en.required' => __('SuperAdmin/backend.visa_form.required_in_english'),
            'nationality_ar.required' => __('SuperAdmin/backend.visa_form.required_in_arabic'),
            'nationality_en.unique' => __('SuperAdmin/backend.visa_form.already_exists_in_english'),
            'nationality_ar.unique' => __('SuperAdmin/backend.visa_form.already_exists_in_arabic'),

        ];
    }
}
