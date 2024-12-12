<?php

namespace App\Http\Controllers\Admins\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    //show login form
    public function create()
    {
        return view('admins.admin.auth.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $remember = $request->boolean('remember'); // Get the boolean value of 'remember'
        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'بيانات الاعتماد المقدمة غير صحيحة',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('admin.login'));
    }
}
