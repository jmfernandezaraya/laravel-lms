<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Mail\ReplyToEnquiry;
use App\Models\Enquiry;
use Illuminate\Http\Request;

/**
 * Class EnquiryController
 * @package App\Http\Controllers\SuperAdmin
 */
class EnquiryController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $enquiries = Enquiry::all();

        return view('superadmin.enquiry.index', compact('enquiries'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $enquiry = Enquiry::where('id', $request->id)->first();
        \Mail::to($request->email)->send(new ReplyToEnquiry($request));
        $enquiry->replied = 1;
        $enquiry->save();
        toastr()->success(__('Frontend.message_sent_thank_you'));
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('frontend.inquiry');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
