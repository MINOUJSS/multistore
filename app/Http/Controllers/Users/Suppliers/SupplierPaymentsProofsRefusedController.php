<?php

namespace App\Http\Controllers\Users\Suppliers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UsersPaymentsProofsRefused;

class SupplierPaymentsProofsRefusedController extends Controller
{
    //
    public function index()
    {
        $proofs = UsersPaymentsProofsRefused::where('user_id', auth()->user()->id)->with(['user', 'admin'])
        ->orderByDesc('created_at')
        ->paginate(10);
        return view('users.suppliers.proofs_refused.index', compact('proofs'));
    }
    //show
    public function show($id)
    {
        $proof = UsersPaymentsProofsRefused::where('user_id', auth()->user()->id)->with(['user', 'admin'])->findOrFail($id);
        return view('users.suppliers.proofs_refused.show', compact('proof'));
    }
}
