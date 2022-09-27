<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactUsRequest;

use App\Models\ContactUs;

use App\Mail\AdminEmailTemplate;
use App\Mail\EmailTemplate;

/**
 * Class ContactController
 * @package App\Http\Controllers\Frontend
 */
class ContactController extends Controller
{
    /*
     * @param ContactUsRequest $request
     *
     * @return success_message : string
     *
     * */

    /**
     * @param ContactUsRequest $request
     * @return string
     */
    public function ContactUs(ContactUsRequest $request)
    {
        $contactUs = new ContactUs;
        $contactUs->fill($request->validated())->save();

        sendEmail('contact_us', $request->email, $request, app()->getLocale());

        return __('Frontend.contact_us_successfully');
    }
}