<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactUsRequest;

use App\Models\Frontend\ContactUs;

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

        setEmailTemplateSMTP('contact_us');
        \Mail::to(env('MAIL_TO_ADDRESS'))->send(new EmailTemplate('contact_us', $request, app()->getLocale()));
        unsetEmailTemplateSMTP();

        return __('Frontend.contact_us_successfully');
    }
}