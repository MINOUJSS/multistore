<?php

namespace App\Http\Controllers\Admins\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //index
    public function index()
    {
        return view('admins.admin.index');
    }
}
