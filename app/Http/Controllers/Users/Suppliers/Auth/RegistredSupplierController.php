<?php

namespace App\Http\Controllers\Users\Suppliers\Auth;

use App\Events\CreateSupplierEvent;
use App\Events\UserLogedInEvent;
use App\Http\Controllers\Controller;
use App\Jobs\Admins\Admin\SendTelegramInfoAboutNewSupplier;
use App\Models\Admin;
use App\Models\Supplier\Supplier;
use App\Models\Supplier\SupplierPlan;
use App\Models\Supplier\SupplierPlanPrices;
use App\Models\Supplier\SupplierPlanSubscription;
use App\Models\Tenant;
use App\Models\User;
use App\Models\UserFreeOrder;
use App\Notifications\Admins\NewUserNotification;
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

class RegistredSupplierController extends Controller
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
        $plans = SupplierPlan::all();
        foreach ($plans as $plan) {
            $plan_array[] = $plan->name;
        }
        // check if the request has the name of the plan
        if (in_array($request->plan, $plan_array)) {
            $plan = $request->plan;
            $plan_data = SupplierPlan::where('name', $plan)->first();
            if ($request->sub_plan_id) {
                foreach ($plan_data->pricing as $price) {
                    if ($price->id == $request->sub_plan_id) {
                        $sub_plan_data = $price;
                    }
                }
            }
        } else {
            $plan = $plan_array[0];
            $plan_data = SupplierPlan::findOrFail(1);
        }

        // dd($plan_data,$sub_plan_data);
        return view('users.suppliers.auth.register', compact('plan', 'plan_data', 'sub_plan_data'));
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
        $store_name = strtolower(trim($request->store_name));
        $store_name = preg_replace('/[^a-z0-9]/', '', $store_name);
        // --------START--------------
        // verify if supplier exists
        if (!supplier_exists($store_name)) {
            return redirect()->back()->withErrors(['store_name' => 'اسم متجر المورد محجوز مسبقاً، يرجى اختيار اسم آخر.']);
        } else {
            try {
                // Start a transaction for atomicity
                \DB::beginTransaction();
                // check if supplier folder exists
                $path = 'supplier/'.$store_name;
                if (!Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->makeDirectory($path);
                }
                // insert data into supplier table and tenant table and domain table
                $tenant = Tenant::create([
                    'id' => $store_name.'.supplier',
                    'type' => 'supplier',
                ]);
                $tenant->domains()->create(['domain' => $store_name.'.'.request()->getHost()]);
                // inserte supplier data to database
                $supplier = Supplier::create([
                    'tenant_id' => $store_name.'.supplier',
                    'full_name' => $request->full_name,
                    'store_name' => $store_name,
                    'email' => $request->email,
                ]);
                // insert data into user table
                $user = User::create([
                    'name' => $request->full_name,
                    'tenant_id' => $tenant->id,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'phone' => $request->phone,
                    'type' => 'supplier',
                ]);
                // create user balance
                $user->balance()->create([
                    'balance' => '0',
                    'outstanding_amount' => '0',
                ]);
                // create user store settings
                create_supplier_store_settings($user, $request);

                // get selected plan data
                $plan = SupplierPlan::where('name', $request->plan)->first();
                if (!$plan) {
                    $plan = SupplierPlan::first();
                }
                // get duration and price
                if ($request->sub_plan_id) {
                    $sub_plan_data = SupplierPlanPrices::findOrFail($request->sub_plan_id);
                    $duration = $sub_plan_data->duration;
                    $price = $sub_plan_data->price;
                } else {
                    $duration = $plan->duration;
                    $price = $plan->price;
                }
                // insert in supplier_plan_subscription table
                $supplier_plan_subscription = SupplierPlanSubscription::create([
                    'supplier_id' => $supplier->id,
                    'plan_id' => $plan->id,
                    'duration' => $duration,
                    'price' => $price,
                    'subscription_start_date' => now(),
                    'subscription_end_date' => now()->addDays($duration),
                    'status' => $plan->price == 0 ? 'free' : 'pending',
                ]);

                // add free order for this supplier
                $freeorders = UserFreeOrder::create([
                    'user_id' => $user->id,
                    'quantity' => '50',
                ]);

                // Create all default content (sliders, benefits, categories, products, shipping, faqs, pages)
                // Executed inside transaction to guarantee full atomicity (All or Nothing)
                event(new CreateSupplierEvent($supplier, $user));

                // Commit the entire transaction atomically
                \DB::commit();

                // send verification email
                event(new Registered($user));

                Auth::login($user);
                // seed last seen table
                event(new UserLogedInEvent(auth()->user()));

                // inform admins about new supplier via telegram
                $data = [
                    'full_name' => $request->full_name,
                    'store_name' => $store_name,
                    'email' => $request->email,
                    'plan_name' => $request->plan,
                ];
                SendTelegramInfoAboutNewSupplier::dispatch($data);

                // redirect to dashboard or confirm plan page
                if ($plan->price == 0) {
                    return redirect(route('supplier.dashboard'));
                } else {
                    return redirect(route('supplier.subscription.confirmation'));
                }
            } catch (\Exception $e) {
                // Rollback the transaction
                \DB::rollBack();

                // Clean up created directory on failure
                $path = 'supplier/'.$store_name;
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->deleteDirectory($path);
                }

                // Log the error for debugging
                Log::error('Supplier Registration Error:', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);

                return redirect()->back()->with('message', 'حدث خطأ أثناء تسجيل حساب المورد، يرجى المحاولة مرة أخرى لاحقاً.');
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
