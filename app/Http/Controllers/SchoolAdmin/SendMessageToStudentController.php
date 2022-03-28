<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Mail\SendMessageToStudentMail;
use App\Models\User;
use Illuminate\Http\Request;

class SendMessageToStudentController extends Controller
{
    /*
     *
     * @return view schooladmin.send_message_to_student.index
     * */
    public function index()
    {
        $allcustomers = User::where('email_verified_at', '!=', null)->get();

        return view('schooladmin.send_message_to_student.index', compact('allcustomers'));
    }

    public function sendMessage(Request $request)
    {
        $request->save_file = $request->file('file')->getClientOriginalName();
        \Storage::put('public/sent_attachments/' . $request->save_file, fopen($request->file('file'), 'r+'));
        \Mail::to($request->email)->send(new SendMessageToStudentMail($request));
        return back();
    }
}