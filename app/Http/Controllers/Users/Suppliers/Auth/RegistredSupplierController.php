<?php

namespace App\Http\Controllers\Users\Suppliers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegistredSupplierController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('users.suppliers.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
       
        $request->validate([
            'name' => ['required', 'string','min:3','max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'regex:/^(0)(5|6|7)[0-9]{8}$/', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' =>'accepted',
        ]);
        //dd($request);
        //verify if supplier folder exists
        if(supplier_folder_exists($request->store_name))
        {
            return redirect()->back();
        }else
        {
            //if false create new supplier folder
            dd('not existing');
            // inserte supplier data to database

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::SUPPLIERHOME);
        }
        
        
    }
}
