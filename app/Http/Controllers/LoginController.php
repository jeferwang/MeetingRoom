<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
	
	public function index()
	{
		return view('login/index');
	}
	
	public function login(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'admin_name' => 'required|exists:admins,admin_name',
			'password'   => 'required',
		], [
			'admin_name.required' => '登录名不能为空',
			'admin_name.exists'   => '登录失败,请检查用户名或密码是否正确',
			'password.required'   => '密码不能为空',
		]);
		if ($validator->fails()) {
			return redirect(route('admin.login_page'))->withErrors($validator)->withInput();
		}
		$admin = Admin::where('admin_name', $request->input('admin_name'))->first();
		if (!\Hash::check($request->input('password'), $admin->password)) {
			$validator->errors()->add('password', '登录失败,请检查用户名或密码是否正确');
			return redirect(route('admin.login_page'))->withErrors($validator)->withInput();
		}
		$admin_login = Cookie::make('admin_login', ['admin_name' => $admin->admin_name, 'admin_id' => $admin->id]);
		return redirect(route('admin.index'))->withCookie($admin_login);
	}
	
	public function logout()
	{
		$forget = Cookie::forget('admin_login');
		return redirect(route('admin.login_page'))->withCookie($forget);
	}
}
