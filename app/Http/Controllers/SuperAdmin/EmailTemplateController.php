<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;

use App\Models\Setting;
use App\Models\CourseApplication;

use App\Models\SuperAdmin\EmailTemplate;

/**
 * Class EmailTemplateController
 * @package App\Http\Controllers\SuperAdmin
 */
class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $email_templates = EmailTemplate::all();

        return view('superadmin.email_template.index', compact('email_templates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $site = Setting::where('setting_key', 'site')->first();
        $site_setting_value = unserialize($site->setting_value);
        $smtp_setting = (object)$site_setting_value['smtp'];

        return view('superadmin.email_template.add', compact('smtp_setting'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'template' => 'required',
            'smtp_server' => 'sometimes',
            'smtp_user_name' => 'sometimes',
            'smtp_password' => 'sometimes',
            'smtp_port' => 'sometimes',
            'sender_name' => 'sometimes',
            'sender_name_ar' => 'sometimes',
            'sender_email' => 'sometimes',
            'keywords' => 'sometimes',
            'subject' => 'sometimes',
            'subject_ar' => 'sometimes',
            'content' => 'sometimes',
            'content_ar' => 'sometimes',
            'admin_sender_name' => 'sometimes',
            'admin_sender_name_ar' => 'sometimes',
            'admin_sender_email' => 'sometimes',
            'admin_subject' => 'sometimes',
            'admin_subject_ar' => 'sometimes',
            'admin_content' => 'sometimes',
            'admin_content_ar' => 'sometimes',
        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        }

        $email_template = new EmailTemplate();
        $email_template->fill($validator->validated())->save();

        $data['data'] = __('Admin/backend.data_updated_successfully');
        $data['redirect_link'] = route('superadmin.email_template.index');        
        $data['success'] = true;

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @param EmailTemplate $EmailTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $site = Setting::where('setting_key', 'site')->first();
        $site_setting_value = unserialize($site->setting_value);
        $smtp_setting = (object)$site_setting_value['smtp'];
        $email_template = EmailTemplate::find($id);

        return view('superadmin.email_template.edit', compact('email_template', 'smtp_setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $email_template = EmailTemplate::find($id);

        $rules = [
            'smtp_server' => 'sometimes',
            'smtp_user_name' => 'sometimes',
            'smtp_password' => 'sometimes',
            'smtp_port' => 'sometimes',
            'sender_name' => 'sometimes',
            'sender_name_ar' => 'sometimes',
            'sender_email' => 'sometimes',
            'keywords' => 'sometimes',
            'subject' => 'sometimes',
            'subject_ar' => 'sometimes',
            'content' => 'sometimes',
            'content_ar' => 'sometimes',
            'admin_sender_name' => 'sometimes',
            'admin_sender_name_ar' => 'sometimes',
            'admin_sender_email' => 'sometimes',
            'admin_subject' => 'sometimes',
            'admin_subject_ar' => 'sometimes',
            'admin_content' => 'sometimes',
            'admin_content_ar' => 'sometimes',
        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $requested_save = $validator->validated();
        if (!$requested_save['smtp_password']) {
            unset($requested_save['smtp_password']);
        }

        $email_template->fill($requested_save)->save();

        $data['data'] = __('Admin/backend.data_updated_successfully');
        $data['redirect_link'] = route('superadmin.email_template.index');  
        $data['success'] = true;

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $email_template = EmailTemplate::find($id);

        $email_template->delete();

        toastr()->success(__('Admin/backend.data_deleted_successfully'));
        return back();
    }
}