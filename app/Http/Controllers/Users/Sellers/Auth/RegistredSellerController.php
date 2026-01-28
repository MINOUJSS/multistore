<?php

namespace App\Http\Controllers\Users\Sellers\Auth;

use App\Events\CreateSellerEvent;
use App\Events\UserLogedInEvent;
use App\Http\Controllers\Controller;
use App\Models\Seller\Seller;
use App\Models\Seller\SellerPlan;
use App\Models\Seller\SellerPlanPrices;
use App\Models\Seller\SellerPlanSubscription;
use App\Models\Tenant;
use App\Models\User;
use App\Models\UserFreeOrder;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegistredSellerController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        // get palns from plans table
        $plan_array = [];
        $plan_data = null;
        $sub_plan_data = null;
        // add items to the plan array
        $plans = SellerPlan::all();
        foreach ($plans as $plan) {
            $plan_array[] = $plan->name;
        }
        // check if the request has the name of the plan
        if (in_array($request->plan, $plan_array)) {
            $plan = $request->plan;
            $plan_data = SellerPlan::where('name', $plan)->first();
            if ($request->sub_plan_id) {
                foreach ($plan_data->pricing as $price) {
                    if ($price->id == $request->sub_plan_id) {
                        $sub_plan_data = $price;
                    }
                }
            }
        } else {
            $plan = $plan_array[0];
            $plan_data = SellerPlan::findOrFail(1);
        }

        // dd($plan_data,$sub_plan_data);
        return view('users.sellers.auth.register', compact('plan', 'plan_data', 'sub_plan_data'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'full_name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'regex:/^(0)(5|6|7)[0-9]{8}$/', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => 'accepted',
        ]);
        // --------START--------------
        // verify if seller exists
        if (!seller_exists($request->store_name)) {
            return redirect()->back();
        } else {
            try {
                // Start a transaction for atomicity
                \DB::beginTransaction();
                // check if seller exists
                $path = 'seller/'.$request->store_name;
                if (!Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->makeDirectory($path);
                }
                // insert data into seller table and tenant table and domain table
                $tenant = Tenant::create([
                    'id' => $request->store_name,
                    'type' => 'seller',
                ]);
                $tenant->domains()->create(['domain' => $request->store_name.'.'.request()->host()]);
                // inserte seller data to database
                $seller = Seller::create([
                    'tenant_id' => $request->store_name,
                    'full_name' => $request->full_name,
                    'store_name' => $request->store_name,
                    'email' => $request->email,
                ]);
                // insert data into user table
                $user = User::create([
                    'name' => $request->full_name,
                    'tenant_id' => $tenant->id,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'phone' => $request->phone,
                    'type' => 'seller',
                ]);
                // create user balance
                $user->balance()->create([
                    'balance' => '0',
                    'outstanding_amount' => '0',
                ]);
                // create user store settings
                create_Seller_store_settings($user, $request);

                // get selected plan data
                $plan = SellerPlan::Where('name', $request->plan)->first();
                // get duration and price
                if ($request->sub_plan_id) {
                    $sub_plan_data = SellerPlanPrices::findOrFail($request->sub_plan_id);
                    $duration = $sub_plan_data->duration;
                    $price = $sub_plan_data->price;
                } else {
                    $duration = $plan->duration;
                    $price = $plan->price;
                }
                // insert in seller_plan_subscription table
                $seller_plan_subscription = SellerPlanSubscription::create([
                    'seller_id' => $seller->id,
                    'plan_id' => $plan->id,
                    'duration' => $duration, // '30',
                    'price' => $price, // $plan->price,
                    'subscription_start_date' => now(), // date('Y-m-d H:i:s'),
                    'subscription_end_date' => now()->addDays($duration), // Carbon::parse(date('Y-m-d H:i:s'))->addDays(30)->format('Y-m-d H:i:s'),
                    'status' => 'pending',
                ]);
                // check plan subscription
                if ($plan->price == 0) {
                    $s_p_subscription = SellerPlanSubscription::find($seller_plan_subscription->id);
                    $s_p_subscription->status = 'free';
                    $s_p_subscription->update();
                    // //add free order fore this seller
                    // $freeorders=UserFreeOrder::create([
                    //     'user_id'=>$user->id,
                    //     'quantity'=>'50',
                    // ]);
                }

                // add free order fore this seller
                $freeorders = UserFreeOrder::create([
                    'user_id' => $user->id,
                    'quantity' => '50',
                ]);

                // Commit the transaction
                \DB::commit();

                // send verification email
                event(new Registered($user));

                Auth::login($user);
                // seed last seen table
                event(new UserLogedInEvent(auth()->user()));

                event(new CreateSellerEvent($seller));

                // redirect to dashboard of confirme plan page
                if ($plan->price == 0) {
                    return redirect(route('seller.dashboard'));
                } else {
                    return redirect(route('seller.subscription.confirmation'));
                }
            } catch (\Exception $e) {
                // delete the folder containing
                // check if seller exists
                $path = $request->store_name;
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->deleteDirectory($path);
                }
                // Rollback the transaction
                \DB::rollBack();
                // Log the error for debugging
                Log::error('Seller Registration Error:', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);

                // Return a user-friendly response
                // return response()->json([
                //     'message' => 'An error occurred while registering the seller. Please try again later.',
                // ], 500);
                return redirect()->back()->with('message', 'An error occurred while registering the Seller. Please try again later.');
            }
        }
        // -----END--------------
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // return redirect('/');
    }
}
