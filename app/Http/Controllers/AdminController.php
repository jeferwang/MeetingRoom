<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
	
	public function index()
	{
		return view('admin.index');
	}
	
	public function changePassword()
	{
		return view('admin.change_password');
	}
	
}
