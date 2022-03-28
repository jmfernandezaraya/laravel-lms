<?php

namespace App\Http\Requests\SuperAdmin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Psy\Util\Json;

class BlogRequest extends FormRequest
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

            'title_en' => 'required',
            'title_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',

        ];
    }

    public function messages()
    {
     return [

            'title_ar.required' => __('SuperAdmin/backend.errors.blog_title_in_arabic'),
         'title_en.required' => __('SuperAdmin/backend.errors.blog_title_in_english'),
         'description_en.required' => __('SuperAdmin/backend.errors.description_en_required'),
         'description_ar.required' => __('SuperAdmin/backend.errors.description_ar_required'),


     ];
    }

    public function failedValidation(Validator $validator)
    {
     return response()->json($validator->errors());
    }
}

