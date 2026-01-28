<?php

namespace App\Http\Controllers\Admins\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminController extends Controller
{
    // index
    public function index()
    {
        $users = User::all();
        $suppliers = User::where('type', 'supplier')->get();
        $sellers = User::where('type', 'seller')->get();
        $marketers = User::where('type', 'marketer')->get();

        return view('admins.admin.index', compact('users', 'suppliers', 'sellers', 'marketers'));
    }
}
