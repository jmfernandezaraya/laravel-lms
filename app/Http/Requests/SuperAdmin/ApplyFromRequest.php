<?php

namespace App\Http\Requests\SuperAdmin;

use Illuminate\Foundation\Http\FormRequest;

class ApplyFromRequest extends FormRequest
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
            'apply_from_en' => 'required|unique:apply_froms',
            'apply_from_ar' => 'required|unique:apply_froms'
        ];
    }

    public function messages()
    {
        return [

            'apply_from_en.required' => __('Admin/backend.visa_form.required_in_english'),
            'apply_from_ar.required' => __('Admin/backend.visa_form.required_in_arabic'),
            'apply_from_en.unique' => __('Admin/backend.visa_form.already_exists_in_english'),
            'apply_from_ar.unique' => __('Admin/backend.visa_form.already_exists_in_arabic'),

        ];
    }

}
