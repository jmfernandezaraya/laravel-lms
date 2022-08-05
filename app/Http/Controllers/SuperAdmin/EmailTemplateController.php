<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;

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
        return view('superadmin.email_template.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\CurrencyRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CurrencyRequest $request, EmailTemplate $email_template)
    {
        $email_template->fill($request->validated())->save();

        toastr()->success(__('Admin/backend.data_saved_successfully'));

        return redirect()->route('superadmin.email_template.index');
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
        $email_template = EmailTemplate::find($id);

        return view('superadmin.email_template.edit', compact('email_template'));
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
            'sender_name' => 'sometimes',
            'sender_name_ar' => 'sometimes',
            'sender_email' => 'sometimes',
            'keywords' => 'sometimes',
            'subject' => 'sometimes',
            'subject_ar' => 'sometimes',
            'content' => 'sometimes',
            'content_ar' => 'sometimes',
        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        }

        $email_template->fill($validator->validated())->save();

        $data['data'] = __('Admin/backend.data_updated_successfully');
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