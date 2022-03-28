<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param \App\Http\Requests\Auth\LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        if (!Auth::user()->hasVerifiedEmail()) {
            throw ValidationException::withMessages([
                'email' => __('Please Verify Your Email'),
            ]);
        }

        $request->session()->regenerate();

        if ($gate = \Gate::inspect('ip_checker')) {
            if ($gate->denied()) {
                auth()->logout();
                throw ValidationException::withMessages([
                    'email' => __($gate->message()),
                ]);
            }
        }

        /*if (\Gate::denies('check_ip_of_user') == 'User Limit Exceeded') {
            auth()->logout();
            throw ValidationException::withMessages([
                'email' => __('Dwevice'),
            ]);

        }*/

        return \Session::has('redirecting_url') ? redirect()->intended(\Session::get('redirecting_url')) : redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function create_admin()
    {
        return view('auth.admin_login');
    }

    public function store_admin(LoginRequest $request)
    {
        $request->adminAuthenticate();
        $request->session()->regenerate();

        return redirect()->intended(route('admin.index'));
    }

    public function admin_destroy(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('admin.login'));
    }

    public function create_lab_admin()
    {
        return view('auth.lab_admin_login');
    }

    public function store_lab_admin(LoginRequest $request)
    {
        $request->adminAuthenticate();
        $request->session()->regenerate();

        return redirect()->intended(route('labadmin.admin.control_panel'));
    }

    public function lab_admin_destroy(Request $request)
    {
        Auth::guard('labadmin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('labadmin.login'));
    }
}