<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Frontend\AppliedForVisa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class VisaApplicationController extends Controller
{
    public function index()
    {
        $visas =  AppliedForVisa::with(['user', 'applyingFrom','typeOfVisa','whereToTravel','getNationality','visaCenter'])->where('payment_status', true)->get();

        return view('superadmin.visa_application.index', compact('visas'));
    }

    public function getOtherFields($id)
    {
        $other_field = AppliedForVisa::find($id);
        $other_fields = json_decode($other_field->other_fields);

        foreach($other_fields as $otherfield) {
        }

        return view('superadmin.visa.other_fields',compact('other_fields'));
    }
}