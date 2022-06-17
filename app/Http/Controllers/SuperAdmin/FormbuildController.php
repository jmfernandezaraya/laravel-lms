<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Formbuilder;
use App\Models\CourseApplication;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

/**
 * Class FormbuildController
 * @package App\Http\Controllers\SuperAdmin
 */
class FormbuildController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $forms =  Formbuilder::all();
        $data['booked_details'] = CourseApplication::all();
        return view('superadmin.visa.index', $data, compact('forms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('superadmin.visa.formbuilder');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validate = \Validator::make($request->all(), ['form_name' => 'unique:form_builders', 'visa_id' => 'required']);

        if($validate->fails()){
        $failed  = __('SuperAdmin/backend.errors.name');
            toastr()->error($failed);
            return back();
        }
        $change_name = json_decode($request->formvalue);

        for($i=0; $i<count($change_name); $i++){
            if(isset($change_name[$i]->label)){
                $change_name[$i]->name = strtolower(str_replace(' ', '_', $change_name[$i]->label));
            }
        }


        Formbuilder::create(['visa_form_id' => $request->visa_id, 'form_name' => $request->form_name, 'form_data' => json_encode($change_name), 'active' => 1]);
            $success = __('SuperAdmin/backend.data_saved');
            toastr()->success($success);
            return view('superadmin.visa.formbuilder');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $formbuilder = Formbuilder::find($id);

        return view('superadmin.visa.edit', compact('formbuilder'));
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
        $formbuilder = Formbuilder::find($id)->first();

        $formbuilder->form_name  = $request->form_name;


        $change_name = json_decode($request->formvalue);
        
        for($i=0; $i<count($change_name); $i++){
            if(isset($change_name[$i]->label)){
                $change_name[$i]->name = strtolower(str_replace(' ', '_', $change_name[$i]->label));
            }
        }

        $formbuilder->form_data = json_encode($change_name);

        $formbuilder->save();
        toastr()->success(__('SuperAdmin/backend.data_updated'));

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Formbuilder::find($id)->delete();
            $deleted = __('SuperAdmin/backend.data_deleted');
            toastr()->success($deleted);
            return back();
    }
}
