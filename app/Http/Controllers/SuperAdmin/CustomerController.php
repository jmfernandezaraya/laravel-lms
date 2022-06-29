<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\CustomerRequest;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Exception\NotReadableException;

use Image;

/**
 * Class CustomerController
 * @package App\Http\Controllers\SuperAdmin
 */
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = User::where('user_type', 'user')->get();

        return view('superadmin.customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('superadmin.customer.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        try {
            (new User($request->validated()))->save();
            $saved = __('Admin/backend.data_saved_successfully');
            return redirect()->route('superadmin.customer.index');
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()]);
        } catch (NotReadableException $e) {
            $exception = __('Admin/backend.errors.image_required');
            return response()->json(['catch_error' => $exception]);
        } catch (\Exception $e) {
            return response()->json(['catch_error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(User $customer)
    {
        return view('superadmin.customer.edit', compact('customer'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $customers = User::find($id);

        $rules = [
            'first_name_en' => 'required',
            'first_name_ar' => 'required',
            'last_name_en' => 'required',
            'last_name_ar' => 'required',
            'email' => 'required',
        ];

        $validate = Validator::make($request->all(), $rules, [
            'first_name_en.required' => __('Admin/backend.errors.customer_first_name_in_english'),
            'first_name_ar.required' => __('Admin/backend.errors.customer_first_name_in_arabic'),
            'last_name_en.required' => __('Admin/backend.errors.customer_last_name_in_english'),
            'last_name_ar.required' => __('Admin/backend.errors.customer_last_name_in_arabic'),
            'email.required' => __('Admin/backend.errors.customer_email'),
        ]);
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        }
        $save = $validate->validated();

        $customers->fill($save)->save();
        $saved = __('Admin/backend.data_saved_successfully');
        return response()->json(['success' => true, 'data' => $saved]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = User::findorFail($id);
        $deleted = __('Admin/backend.data_deleted_successfully');

        if ($delete->image != '' && $delete->image != null && file_exists($delete->image)) {
            unlink($delete->image);
        }
        $delete->delete();
        return back()->with(['message' => $deleted]);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload');
            $fulloriginName = $originName->getClientOriginalName();
            $fileName = pathinfo($fulloriginName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . 'webp';

            $interventionImage = Image::make($originName)->resize(150, 150, function($constrained) {
                $constrained->aspectRatio();
            })->encode('webp');
            file_put_contents(public_path('images/customer_images/' .$fileName), $interventionImage);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('public/images/customer_images/' . $fileName);
            $msg = __('Admin/backend.image_uploaded_successfully');
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            return $response;
        }
    }
}