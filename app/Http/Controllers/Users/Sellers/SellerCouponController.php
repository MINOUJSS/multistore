<?php

namespace App\Http\Controllers\Users\Sellers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Seller\SellerProducts;
use App\Models\User;
use App\Models\userCoupons;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SellerCouponController extends Controller
{
    public function index()
    {
        //   $coupons = userCoupons::with(['users', 'categories', 'Seller_products'])->latest()->paginate(10);
        $coupons = userCoupons::where('user_id', auth()->user()->id)->latest()->paginate(10);
        $users = User::all();
        $categories = Category::all();
        $products = SellerProducts::all();

        return view('users.sellers.coupons.index', compact('coupons', 'users', 'categories', 'products'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:user_coupons|uppercase',
            'description' => 'nullable|string',
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:0',
            // 'user_restriction' => 'required|in:all,new,existing,specific',
            // 'specific_users' => 'required_if:user_restriction,specific|array',
            // 'product_restriction' => 'required|in:all,categories,products',
            // 'categories' => 'required_if:product_restriction,categories|array',
            // 'products' => 'required_if:product_restriction,products|array',
            // 'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $start_date = Carbon::parse($request['start_date'])->format('Y-m-d H:i:s');
        $end_date = Carbon::parse($request['end_date'])->format('Y-m-d H:i:s');
        $is_active = $request['is_active'] ? 1 : 0;

        // return response()->json([
        // 'error' =>$request->all(),
        // ],422);

        // $coupon = userCoupons::create($request->except(['specific_users', 'categories', 'products']));
        $user_id = auth()->user()->id;
        $coupon = userCoupons::create([
            'user_id' => $user_id,
            'code' => strtoupper($request['code']), // Store codes in uppercase
            'description' => $request['description'] ?? null,
            'type' => $request['type'],
            'value' => $request['value'],
            'min_order_amount' => $request['min_order_amount'] ?? 0,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'usage_limit' => $request['max_uses'] ?? null,
            'usage_per_user' => 0,
            'is_active' => $is_active,
        ]);

        // // Attach specific users if restriction is set
        // if ($request->user_restriction === 'specific' && $request->specific_users) {
        //     $coupon->users()->attach($request->specific_users);
        // }

        // // Attach categories or products based on restriction
        // if ($request->product_restriction === 'categories' && $request->categories) {
        //     $coupon->categories()->attach($request->categories);
        // } elseif ($request->product_restriction === 'products' && $request->products) {
        //     $coupon->products()->attach($request->products);
        // }

        return response()->json(['message' => 'Coupon created successfully'], 200);
    }

    public function edit($id)
    {
        $coupon = userCoupons::findOrFail($id);
        // $coupon->load(['users', 'categories', 'Seller_products']);
        $coupon->with('users', 'categories', 'Seller_products');

        return response()->json($coupon);
    }

    public function update(Request $request, $id)
    {
        $coupon = userCoupons::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:user_coupons,code,'.$coupon->id.'|uppercase',
            'description' => 'nullable|string',
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:0',
            // 'user_restriction' => 'required|in:all,new,existing,specific',
            // 'specific_users' => 'required_if:user_restriction,specific|array',
            // 'product_restriction' => 'required|in:all,categories,products',
            // 'categories' => 'required_if:product_restriction,categories|array',
            // 'products' => 'required_if:product_restriction,products|array',
            // 'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // $coupon->update($request->except(['specific_users', 'categories', 'products']));
        $start_date = Carbon::parse($request['start_date'])->format('Y-m-d H:i:s');
        $end_date = Carbon::parse($request['end_date'])->format('Y-m-d H:i:s');
        $is_active = $request['is_active'] ? 1 : 0;
        $user_id = auth()->user()->id;

        $coupon->update([
            'user_id' => $user_id,
            'code' => strtoupper($request['code']), // Store codes in uppercase
            'description' => $request['description'] ?? null,
            'type' => $request['type'],
            'value' => $request['value'],
            'min_order_amount' => $request['min_order_amount'] ?? 0,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'usage_limit' => $request['max_uses'] ?? null,
            // 'usage_per_user' => $request['max_uses'] ?? null,
            'is_active' => $is_active,
        ]);

        // // Sync specific users if restriction is set
        // if ($request->user_restriction === 'specific') {
        //     $coupon->users()->sync($request->specific_users);
        // } else {
        //     $coupon->users()->detach();
        // }

        // // Sync categories or products based on restriction
        // if ($request->product_restriction === 'categories') {
        //     $coupon->categories()->sync($request->categories);
        //     $coupon->Seller_products()->detach();
        // } elseif ($request->product_restriction === 'products') {
        //     $coupon->products()->sync($request->products);
        //     $coupon->categories()->detach();
        // } else {
        //     $coupon->categories()->detach();
        //     $coupon->Seller_products()->detach();
        // }

        return response()->json(['message' => 'Coupon updated successfully'], 200);
    }

    public function destroy($id)
    {
        $coupon = userCoupons::findOrFail($id);
        $coupon->delete();

        return response()->json(['message' => 'Coupon deleted successfully'], 200);
    }

    public function filter(Request $request)
    {
        $query = userCoupons::query();

        if ($request->type !== 'all') {
            $query->where('type', $request->type);
        }

        if ($request->status !== 'all') {
            if ($request->status === 'active') {
                $query->where('is_active', 1)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
            } elseif ($request->status === 'expired') {
                $query->where('end_date', '<', now());
            } elseif ($request->status === 'scheduled') {
                $query->where('start_date', '>', now());
            }
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('code', 'like', '%'.$request->search.'%')
                ->orWhere('description', 'like', '%'.$request->search.'%');
            });
        }

        $coupons = $query->paginate(10);
        $users = User::all();
        $categories = Category::all();
        $products = SellerProducts::all();

        return response()->json([
            'html' => view('users.sellers.components.content.coupons.partials.coupon_table', compact('coupons', 'users', 'categories', 'products'))->render(),
        ]);
    }
}
