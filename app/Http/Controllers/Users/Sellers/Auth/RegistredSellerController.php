<?php

namespace App\Http\Controllers\Users\Sellers\Auth;

use App\Events\CreateSellerEvent;
use App\Events\UserLogedInEvent;
use App\Http\Controllers\Controller;
use App\Jobs\Admins\Admin\SendTelegramInfoAboutNewSeller;
use App\Models\Admin;
use App\Models\Seller\Seller;
use App\Models\Seller\SellerPlan;
use App\Models\Seller\SellerPlanPrices;
use App\Models\Seller\SellerPlanSubscription;
use App\Models\Tenant;
use App\Models\User;
use App\Models\UserFreeOrder;
use App\Notifications\Admins\NewUserNotification;
use App\Services\Seller\SellerMediaService;
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
            'store_name' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'regex:/^[a-zA-Z0-9]+$/',
            ],
            'full_name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'regex:/^(0)(5|6|7)[0-9]{8}$/', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => 'accepted',
        ], [
            'store_name.required' => 'اسم المتجر باللغة الإنجليزية مطلوب.',
            'store_name.min' => 'اسم المتجر يجب ألا يقل عن 3 أحرف.',
            'store_name.max' => 'اسم المتجر يجب ألا يتجاوز 50 حرفاً.',
            'store_name.regex' => 'اسم المتجر يجب أن يتكون من أحرف إنجليزية وأرقام فقط (بدون مسافات أو رموز خاصة).',
        ]);
        // --------START--------------
        $store_name = strtolower(trim($request->store_name));
        $store_name = preg_replace('/[^a-z0-9]/', '', $store_name);

        if (empty($store_name) || strlen($store_name) < 3) {
            return redirect()->back()->withInput()->withErrors([
                'store_name' => 'اسم المتجر غير صالح، يجب أن يحتوي على 3 أحرف إنجليزية أو أرقام على الأقل.',
            ]);
        }

        // verify if seller exists
        if (!seller_exists($store_name)) {
            return redirect()->back()->withInput()->withErrors(['store_name' => 'اسم المتجر محجوز مسبقاً، يرجى اختيار اسم آخر.']);
        } else {
            try {
                // Start a transaction for atomicity
                \DB::beginTransaction();
                // check if seller folder exists on the active storage disk configured in .env
                $mediaService = app(SellerMediaService::class);
                $disk = $mediaService->getActiveDisk();
                $path = ($disk === 'seller') ? $store_name : $mediaService->prefixR2Path($store_name);

                if (!Storage::disk($disk)->exists($path)) {
                    Storage::disk($disk)->makeDirectory($path);
                }
                // insert data into seller table and tenant table and domain table
                $tenant = Tenant::create([
                    'id' => $store_name,
                    'type' => 'seller',
                ]);
                $tenant->domains()->create(['domain' => $store_name.'.'.request()->getHost()]);
                // inserte seller data to database
                $seller = Seller::create([
                    'tenant_id' => $tenant->id,
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
                    'type' => 'seller',
                ]);
                // create user balance
                $user->balance()->create([
                    'balance' => '0',
                    'outstanding_amount' => '0',
                ]);
                // create user store settings
                create_seller_store_settings($user, $request);

                // get selected plan data
                $plan = SellerPlan::where('name', $request->plan)->first();
                if (!$plan) {
                    $plan = SellerPlan::first();
                }
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
                    'duration' => $duration,
                    'price' => $price,
                    'subscription_start_date' => now(),
                    'subscription_end_date' => now()->addDays($duration),
                    'status' => $plan->price == 0 ? 'free' : 'pending',
                ]);

                // add free order for this seller
                $freeorders = UserFreeOrder::create([
                    'user_id' => $user->id,
                    'quantity' => '50',
                ]);

                // assign free plan welcome services (5 Chargily orders & 3 Bank transfer orders)
                if ($plan->price == 0 || $plan->id == 1) {
                    assign_free_plan_welcome_services($user);
                }

                // Create all default content (sliders, benefits, categories, products, shipping, faqs, pages)
                // Executed inside transaction to guarantee full atomicity (All or Nothing)
                event(new CreateSellerEvent($seller, $user));

                // Commit the entire transaction atomically
                \DB::commit();

                // send verification email
                event(new Registered($user));

                Auth::login($user);
                // seed last seen table
                event(new UserLogedInEvent(auth()->user()));

                // inform admins about new seller via telegram
                $data = [
                    'full_name' => $request->full_name,
                    'store_name' => $store_name,
                    'email' => $request->email,
                    'plan_name' => $request->plan,
                ];
                SendTelegramInfoAboutNewSeller::dispatch($data);

                // redirect to dashboard or confirm plan page
                if ($plan->price == 0) {
                    return redirect(route('seller.dashboard'));
                } else {
                    return redirect(route('seller.subscription.confirmation'));
                }
            } catch (\Exception $e) {
                // Rollback the transaction
                \DB::rollBack();

                // Clean up created directory on failure ONLY if $store_name is valid and never a root directory
                if (!empty($store_name) && strlen($store_name) >= 3 && isset($disk, $path)) {
                    $cleanCheck = trim($path, '/');
                    if ($cleanCheck !== '' && !in_array($cleanCheck, ['seller', 'supplier', '.', '..', 'public', 'admin'], true)) {
                        try {
                            if (Storage::disk($disk)->exists($path)) {
                                Storage::disk($disk)->deleteDirectory($path);
                            }
                        } catch (\Throwable $delEx) {
                            Log::warning("Failed to clean up seller directory on registration failure: {$path}. Error: " . $delEx->getMessage());
                        }
                    }
                }

                // Log the error for debugging
                Log::error('Seller Registration Error:', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);

                return redirect()->back()->with('message', 'حدث خطأ أثناء تسجيل حساب البائع، يرجى المحاولة مرة أخرى لاحقاً.');
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
