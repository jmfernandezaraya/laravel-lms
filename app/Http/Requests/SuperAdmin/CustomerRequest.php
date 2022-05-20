<?php

namespace App\Http\Requests\SuperAdmin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Psy\Util\Json;

class CustomerRequest extends FormRequest
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
            'first_name_en' => 'required',
            'first_name_ar' => 'required',
            'last_name_en' => 'required',
            'last_name_ar' => 'required',
            'email' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'first_name_en.required' => __('SuperAdmin/backend.errors.customer_first_name_in_english'),
            'first_name_ar.required' => __('SuperAdmin/backend.errors.customer_first_name_in_arabic'),
            'last_name_en.required' => __('SuperAdmin/backend.errors.customer_last_name_in_english'),
            'last_name_ar.required' => __('SuperAdmin/backend.errors.customer_last_name_in_arabic'),
            'email.required' => __('SuperAdmin/backend.errors.customer_email'),
        ];
    }

    public function failedValidation(Validator $validator)
    {
        return response()->json($validator->errors());
    }
}