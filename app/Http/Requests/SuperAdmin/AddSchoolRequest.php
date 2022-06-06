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
            'name_id' => 'required',
            'country_id' => 'required',
            'city_id' => 'required',

            'email' => 'required',
            'contact' => 'required',
            'emergency_number' => 'required',
            
            // 'branch_name' => 'required',
            // 'branch_name_ar' => 'required',

            'logo' => 'mimes:jpg,jpeg,png,bmp,pdf,svg',
            'logos.*' => 'mimes:jpg,jpeg,png,bmp,pdf,svg',
            'multiple_photos.*' => 'mimes:jpg,jpeg,png,bmp,pdf',
            
            'capacity' => 'required',
            'facilities' => 'required',
            'facilities_ar' => 'required',
            'class_size' => 'required',
            'class_size_ar' => 'required',
            'opened' => 'required',
            'opening_hours' => 'required',
            'opening_hours_ar' => 'required',
            'number_of_classrooms' => 'required',
            'about' => 'required',
            'address' => 'required',
            'video_url.*' => 'required',
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

