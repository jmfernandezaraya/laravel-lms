<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactUsRequest;
use App\Mail\ContactUs;
use App\Models\Frontend\ContactUs;

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

        \Mail::to(env('MAIL_TO_ADDRESS'))->send(new ContactUs($request, app()->getLocale()));

        return "Will Contact You Shortly";
    }
}