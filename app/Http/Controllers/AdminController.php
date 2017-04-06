<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Support\Facades\Cookie;

class AdminController extends Controller
{
	
	public function index()
	{
		return view('admin.index');
	}
	
	public function changeInfo()
	{
		$admin = Admin::where('admin_name', Cookie::get('admin_login')['admin_name'])->first();
		return view('admin.change_info', ['admin' => $admin]);
	}
	
}
