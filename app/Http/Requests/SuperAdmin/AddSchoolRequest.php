<?php

namespace App\Http\Requests\SuperAdmin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AddSchoolRequest
 * @package App\Http\Requests\SuperAdmin
 */
class AddSchoolRequest extends FormRequest
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
            'name' => 'required',
            'contact' => 'required',
            'emergency_number' => 'required',

            'logo' => 'mimes:jpg,jpeg,png,bmp,pdf,svg',
            'logos.*' => 'mimes:jpg,jpeg,png,bmp,pdf,svg',

            'multiple_photos.*' => 'mimes:jpg,jpeg,png,bmp,pdf',
            'school_capacity' => 'required',
            'facilities' => 'required',
            'class_size' => 'required',
            'opened' => 'required',
            'about' => 'required',
            'address' => 'required',
            'city' => 'required',

            'country' => 'required',
            'video_url.*' => 'required',
            'name_ar' => 'required',

            'facilities_ar' => 'required',
            'class_size_ar' => 'required',


            'city_ar' => 'required',
            'country_ar' => 'required',
            'about_ar' => 'required',

            'email' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'multiple_photos.*.required' => __('SuperAdmin/backend.messages.multiple_photos_required'),
            'logos.*.required' => __('SuperAdmin/backend.messages.logos_required'),
            'video_url.*.required' => __('SuperAdmin/backend.messages.video_url_required'),
        ];
    }
}

