<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactUSRequest;
use App\Mail\ContactUSMail;
use App\Models\Frontend\ContactUs;

/**
 * Class ContactController
 * @package App\Http\Controllers\Frontend
 */
class ContactController extends Controller
{
    /*
     * @param ContactUSRequest $request
     *
     * @return success_message : string
     *
     * */

    /**
     * @param ContactUSRequest $request
     * @return string
     */
    public function ContactUS(ContactUSRequest $request)
    {
        $contactUs = new ContactUs;
        $contactUs->fill($request->validated())->save();

        \Mail::to(env('MAIL_TO_ADDRESS'))->send(new ContactUSMail($request));

        return "Will Contact You Shortly";
    }
}