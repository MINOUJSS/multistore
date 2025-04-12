<?php

namespace App\Http\Controllers\Users\Suppliers\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Events\UserLogedInEvent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('users.suppliers.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(Request $request)
    {
       // Validate the login request
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);
    // Extract credentials and 'remember me' value
    $credentials = $request->only('email', 'password');
    $remember = $request->boolean('remember'); // Get the boolean value of 'remember'

    // Attempt to log the user in
    if (Auth::attempt($credentials, $remember)) {
        // Regenerate session to prevent fixation attacks
        $request->session()->regenerate();
        //seed last seen table
        last_seen_user();
        // event(new UserLogedInEvent(auth()->user()));
        // Redirect to intended location or dashboard
        return redirect()->intended(route('supplier.dashboard'));
    }

    // If authentication fails
    return back()->withErrors([
        'email' => 'بيانات الاعتماد المقدمة غير صحيحة.',
    ]);
    }
    public function logout(Request $request)
{
    Auth::logout();

    // Invalidate the session and regenerate CSRF token
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Redirect to login or homepage
    return redirect(route('supplier.login'));
}
    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     dd($request);
    //     $request->authenticate();

    //     $request->session()->regenerate();

    //     // return redirect()->intended(RouteServiceProvider::HOME);
    //     return redirect()->intended(route('supplier.dashboard'));

    // }

    /**
     * Destroy an authenticated session.
     */
    // public function destroy(Request $request): RedirectResponse
    // {
    //     Auth::guard('web')->logout();

    //     $request->session()->invalidate();

    //     $request->session()->regenerateToken();

    //     return redirect('/');
    // }
}