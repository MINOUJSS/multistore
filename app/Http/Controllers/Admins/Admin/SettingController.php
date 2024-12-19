<?php

namespace App\Http\Controllers\Admins\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    //
    public function index()
    {
        return view('admins.admin.setting.index');
    }
}
