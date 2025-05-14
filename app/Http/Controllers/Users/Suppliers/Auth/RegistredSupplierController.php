<?php

namespace App\Http\Controllers\Users\Suppliers\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Supplier;
use Illuminate\View\View;
use App\Models\SupplierPlan;
use Illuminate\Http\Request;
use App\Events\UserLogedInEvent;
use Illuminate\Validation\Rules;
use App\Models\BalanceTransaction;
use App\Models\SupplierPlanPrices;
use App\Events\CreateSupplierEvent;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Storage;
use App\Models\SupplierPlanSubscription;

class RegistredSupplierController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        //get palns from plans table
        $plan_array=[];
        $plan_data=null;
        $sub_plan_data=null;
        //add items to the plan array
        $plans=SupplierPlan::all();
        foreach($plans as $plan)
        {
            $plan_array[]=$plan->name;
        }
        //check if the request has the name of the plan
        if(in_array($request->plan,$plan_array))
        {
            $plan=$request->plan; 
            $plan_data=SupplierPlan::where('name',$plan)->first();
            if($request->sub_plan_id)
            {
                foreach($plan_data->pricing as $price)
                {
                    if($price->id==$request->sub_plan_id)
                    {
                        $sub_plan_data=$price;
                    }
                }
            }
        }else
        {
            $plan=$plan_array[0];
            $plan_data=SupplierPlan::findOrFail(1);
        }
        // dd($plan_data,$sub_plan_data);
        return view('users.suppliers.auth.register',compact('plan','plan_data','sub_plan_data'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'full_name' => ['required', 'string','min:3','max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'regex:/^(0)(5|6|7)[0-9]{8}$/', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' =>'accepted',
        ]);
            //--------START--------------
            //verify if supplier exists
        if(!supplier_exists($request->store_name))
        {
            return redirect()->back();
        }else
        {
            try
            {      
                // Start a transaction for atomicity
                \DB::beginTransaction();
                // check if supplier exists
                $path = 'supplier/'.$request->store_name;
                if(!Storage::disk('public')->exists($path))
                {
                    Storage::disk('public')->makeDirectory($path);
                }
                //insert data into supplier table and tenant table and domain table
                $tenant=Tenant::create([
                    'id' => $request->store_name.'.supplier',
                    'type' => 'supplier',
                ]);
                $tenant->domains()->create(['domain'=> $request->store_name.'.'.request()->host()]);
                // inserte supplier data to database
                $supplier = Supplier::create([
                'tenant_id' => $request->store_name.'.supplier',
                'full_name' => $request->full_name,
                'store_name' => $request->store_name,
                 ]);      
                 // insert data into user table
                 $user = User::create([
                    'name' => $request->full_name,
                    'tenant_id' => $tenant->id,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'phone' => $request->phone,
                 ]); 
                 //create user balance
                 $user->balance()->create([
                     'balance' => '0',
                     'outstanding_amount' => '0',
                 ]);
                 //create user store settings
                 create_supplier_store_settings($user,$request);

                 //get selected plan data
                 $plan=SupplierPlan::Where('name',$request->plan)->first(); 
                 //get duration and price
                 if($request->sub_plan_id)
                 {
                    $sub_plan_data=SupplierPlanPrices::findOrFail($request->sub_plan_id);
                    $duration=$sub_plan_data->duration;
                    $price=$sub_plan_data->price; 
                 }else
                 {
                    $duration=$plan->duration;
                    $price=$plan->price;
                 }            
                 //insert in supplier_plan_subscription table
                 $supplier_plan_subscription=SupplierPlanSubscription::create([
                    'supplier_id' => $supplier->id,
                    'plan_id' => $plan->id,
                    'duration' => $duration,//'30',
                    'price' => $price,//$plan->price,
                    'subscription_start_date'=>now(),//date('Y-m-d H:i:s'),
                    'subscription_end_date'=>now()->addDays($duration),//Carbon::parse(date('Y-m-d H:i:s'))->addDays(30)->format('Y-m-d H:i:s'),
                    'status'=>'pending',
                 ]);
                 //check plan subscription
                 if($plan->price==0)
                 {
                    $s_p_subscription=SupplierPlanSubscription::find($supplier_plan_subscription->id);
                    $s_p_subscription->status='free';
                    $s_p_subscription->update();
                    // //add balance to subscription
                    // $user->balance()->update([
                    //     'balance'=> '500',
                    // ]);
                    // //commit this transaction in balance transaction table
                    // BalanceTransaction::create([
                    //     'user_id' => $user->id,
                    //     'transaction_type' => 'addition',
                    //     'amount' => '500',
                    //     'description' => 'منحة من النصة لكشف أرقام الزبائن عند الطلب على منتجاتك',
                    //     'payment_method' =>'نظام المنصة',
                    // ]);
                 }
                                   
                  // Commit the transaction
                 \DB::commit();

                 //send verification email
                event(new Registered($user));
               

                Auth::login($user);
                 //seed last seen table
                 event(new UserLogedInEvent(auth()->user()));
                 //
                 event(new CreateSupplierEvent($supplier));
                
                 //redirect to dashboard of confirme plan page
                 if($plan->price==0)
                 {
                    return redirect(route('supplier.dashboard'));
                 }else
                 {
                    return redirect(route('supplier.subscription.confirmation'));
                 }
            }catch(\Exception $e)
            {
                //delete the folder containing
                //check if supplier exists
                $path = $request->store_name;
                if(Storage::disk('public')->exists($path))
                {
                    Storage::disk('public')->deleteDirectory($path);
                }
               // Rollback the transaction
        \DB::rollBack();
        // Log the error for debugging
        Log::error('Supplier Registration Error:', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        // Return a user-friendly response
        // return response()->json([
        //     'message' => 'An error occurred while registering the supplier. Please try again later.',
        // ], 500); 
        return redirect()->back()->with('message','An error occurred while registering the supplier. Please try again later.');
            }
          }
            // -----END--------------
               
    }
    //
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        //return redirect('/');
    }
}
