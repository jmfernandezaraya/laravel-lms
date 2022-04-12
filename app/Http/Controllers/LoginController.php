<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Mail\RegisterOTPMail;
use App\Mail\SendVerifyEmailAgain;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        if (auth()->check()) {
            return redirect()->route('land_page');
        }

        session()->put('previous_url', url()->previous());
        return view('frontend.login');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request)
    {
        $route = '/';
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (session()->has("previous_url")) {
                $route = session()->get('previous_url');
                session()->forget('previous_url');
            }

            $reroute = \Session::has('program_unique_id') ? 'reservation_detail' : $route;
            $route = \Session::has('visa_form') ? 'frontend.visa' : $reroute;
            $request->session()->regenerate();
            return redirect()->intended($route);
        }

        return back()->withErrors([
            'email' => __('Frontend.credentials_error'),
        ])->withInput();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('land_page');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function register()
    {
        if (auth()->check()) {
            $reroute = \Session::has('program_unique_id') ? redirect()->route('course.register.detail') : redirect()->route('land_page');

            return \Session::has('visa_form') ? redirect()->route('frontend.visa') : $reroute;
        }

        return view('frontend.register');
    }

    /**
     * @param RegisterUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registerPost(RegisterUserRequest $request)
    {
        if (!$request->validated())
            return back()->withInput()->withErrors();

        $store = new User;
        $token = hash('sha256', \Str::random(16) . time() . rand(0000, 9999));

        $store->fill($request->validated() + ['user_type' => 'user', 'remember_token' => $token])->save();
        \Mail::to($store->email)->send(new RegisterOTPMail($token));

        return back()->with('message', __('Frontend.check_your_email'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forgotPassword(Request $request)
    {
        $status = \Password::sendResetLink($request->only('email'));

        return $status === \Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = \Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => \Hash::make($password)
                ])->setRememberToken(\Illuminate\Support\Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status == \Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    /**
     * @param $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyEmail($token)
    {
        $user = User::where('remember_token', $token)->firstOrFail();
        $user->update(['email_verified_at' => Carbon::now()->toDate()]);

        return redirect()->route('login');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendMailAgain($id)
    {
        $store = User::whereId($id)->first();

        \Mail::to($store->email)->send(new SendVerifyEmailAgain($id));

        return back()->with('message', __('Frontend.check_your_email'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyEmailAgain($id)
    {
        $user = User::find($id);
        $user->update(['email_verified_at' => Carbon::now()->toDate()]);

        return redirect()->route('login');
    }

    /*
     * Superadmin related functions starts
     * */
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function superAdminauthenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $route = '/';
        if (auth('superadmin')->attempt($credentials)) {

            if (auth('superadmin')->user()->isSuperAdmin() == true) {
                $request->session()->regenerate();
                if (session()->has("previous_url")) {
                    $route = session()->get('previous_url');
                    session()->forget('previous_url');
                }

                return redirect()->intended($route);
            } else {
                return back()->withErrors([
                    'email' => __('Frontend.credentials_error'),
                ])->withInput();
            }
        }

        return back()->withErrors([
            'email' => __('Frontend.credentials_error'),
        ])->withInput();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showSuperAdminForm()
    {
        if (auth('superadmin')->check()) {
            return redirect()->route('superadmin.dashboard');
        }
        session()->put('previous_url', url()->previous());
        return view('superadmin.login');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function superAdminlogout(Request $request)
    {
        Auth::guard('superadmin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('superlogin');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function schoolAdminlogout(Request $request)
    {
        Auth::guard('schooladmin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('schoollogin');
    }

    /*
     * Schooladmin related function starts
     *
     * */
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showSchoolAdminForm()
    {
        if (auth('schooladmin')->check()) {
            return redirect()->route('schooladmin.dashboard');
        }
        return view('schooladmin.login');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function schoolAdminauthenticate(Request $request)
    {
        echo "===first====";
                
        $credentials = $request->only('email', 'password');
        var_dump($credentials);
        if (auth('schooladmin')->attempt($credentials)) {
            if (auth('schooladmin')->user()->isSchoolAdmin() == true) {
                $request->session()->regenerate();
                return redirect()->route('schooladmin.dashboard');
            }
        }
        echo "===else====";
        die();

        return back()->withErrors([
            'email' => __('Frontend.credentials_error'),
        ])->withInput();
    }

    /*
    * Schooladmin related function starts
    *
    * */
    /**schoool
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showBranchAdminForm()
    {
        if (auth('branch_admin')->check()) {
            return redirect()->route('branch_admin.dashboard');
        }
        return view('branchadmin.login');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function branchAdminauthenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth('branch_admin')->attempt($credentials)) {
            if (auth('branch_admin')->user()->isBranchAdmin() == true) {
                $request->session()->regenerate();
                return redirect()->route('branch_admin.dashboarschooold');
            }
        }

        return back()->withErrors([
            'email' => __('Frontend.credentials_error'),
        ])->withInput();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function branchAdminlogout(Request $request)
    {
        Auth::guard('branch_admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('branchlogin');
    }
}