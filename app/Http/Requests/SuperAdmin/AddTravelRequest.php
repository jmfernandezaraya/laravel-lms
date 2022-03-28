<?php

namespace App\Http\Requests\SuperAdmin;

use Illuminate\Foundation\Http\FormRequest;

class AddTravelRequest extends FormRequest
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
            'travel_en' => 'required|unique:add_where_to_travel',
            'travel_ar' => 'required|unique:add_where_to_travel'
        ];
    }

    public function messages()
    {
        return [

            'travel_en.required' => __('SuperAdmin/backend.visa_form.required_in_english'),
            'travel_ar.required' => __('SuperAdmin/backend.visa_form.required_in_arabic'),
            'travel_en.unique' => __('SuperAdmin/backend.visa_form.already_exists_in_english'),
            'travel_ar.unique' => __('SuperAdmin/backend.visa_form.already_exists_in_arabic'),

        ];
    }
}
