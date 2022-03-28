<?php

namespace App\Http\Controllers\Auth;

use App\Events\AdditionalUsersMailSend;
use App\Http\Controllers\Controller;
use App\Http\Controllers\User\PaymentGatewayController;
use App\Models\User;
use App\Models\User\IpAddressOfUser;
use App\Models\User\Payment;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',

            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'organization_name' => 'required',
            'logo' => 'required|mimes:jpg,jpeg,png,bmp,svg,webp',
            'captcha_code' => 'required',
            'terms_and_conditions' => 'required'
        ]);

        /* 
        if(!captcha_check($request->captcha_code) && config('app.env') != 'local') {
            throw ValidationException::withMessages([
                'captcha_code' => "Wrong Captcha",
            ]);
        }*/

        $filename = $request->file('logo')->getClientOriginalName();
        $request->file('logo')->move('assets/user_logo/', $filename);
        \DB::transaction(function () use ($request, $filename) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'organization_name' => $request->organization_name,
                'logo' => $filename,
                'user_type' => 'main_user',
                'lab_name' => \Str::slug($request->organization_name),
            ]);
            $expire_date = Carbon::now()->addYear();
            Payment::create([
                'user_id' => $user->id,
                'setup_charge' => request()->setup_charge,
                'annual_charge' => request()->annual_charge,
                'data_space_purchased' => request()->data_space_purchased,
                'data_space_purchased_price' => request()->data_space_purchased_price,

                'qr_code_purchased' => request()->qr_code_purchased,
                'qr_code_purchased_price' => request()->qr_code_purchased_price,
                'additional_users' => request()->additional_users,
                'additional_users_purhcased_price' => request()->additional_users_purhcased_price,
                'expire_date' => $expire_date,
                'total_amount' => request()->total_amount,
                'paid_status' => 'pending',
            ]);

            generateLabId($user);
            $ipaddress = IpAddressOfUser::create(['user_id' => $user->id,
                'ip_address' => request()->ip()]);
            $user->ip_address_of_user_id = $ipaddress->id;
            $user->save();

            $array_merge = array_merge($request->additional_users_email, $request->additional_users_password);

            for ($i = 0; $i < count($array_merge['email']); $i++) {
                $subUser = User::create([
                    'name' => $request->name,
                    'email' => $array_merge['email'][$i],
                    'user_type' => 'user',
                    'main_user_id' => $user->id,
                    'password' => bcrypt($array_merge['password'][$i]),
                    'organization_name' => $request->organization_name,
                ]);

                event(new AdditionalUsersMailSend($subUser, $array_merge['password'][$i]));
            }
            $request->request->add(['user_id' => $user->id, 'form_submit_url' => 'user.paymentPagePost']);
        });

        //->with(['request' => \Arr::except($request->all(), 'logo')]);

        \Session::put('payment_fields', $request->except('logo'));
        return redirect()->route('user.paymentPage');
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha' => captcha_img()]);
    }
}