<?php

namespace App\Http\Controllers\Backend;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
	
	public function index()
	{
		return view('backend.admin.index');
	}
	
	public function changeInfo(Request $request)
	{
		if ($request->isMethod('post')) {
			return $this->change($request);
		}
		$admin = Admin::where('admin_name', Cookie::get('admin_login')['admin_name'])->first();
		return view('backend.admin.change_info', ['admin' => $admin]);
	}
	
	public function change(Request $request)
	{
		/*
		 *  密码123456 Hash $2y$10$FRiKbd9k6bUxqFGdNsKD1OrKMXy8ZObqA.Y0oOp07BJ.FxB6Rz8AG
		 */
		$resp = [];
		$cookieAdminName = Cookie::get('admin_login')['admin_name'];
		$admin = Admin::where('admin_name', $cookieAdminName)->first();
		if ($request->input('type') == 'name') {
			$validator = Validator::make($request->all(), [
				'admin_name' => 'required|max:255',
			]);
			if (!$validator->fails()) {
				$admin->admin_name = $request->input('admin_name');
				$admin->save();
				$resp['status'] = true;
				$resp['msg'] = '更新登录名成功 ! ';
			} else {
				$resp['status'] = false;
				$resp['msg'] = '更新失败,登录名不能为空';
			}
		} else if ($request->input('type') == 'pass') {
			$validator = Validator::make($request->all(), [
				'oldPass'  => 'required',
				'newPass1' => 'required',
				'newPass2' => 'required',
			]);
			if (!$validator->fails()) {
				if (\Hash::check($request->input('oldPass'), $admin->password)) {
					if ($request->input('newPass1') == $request->input('newPass2')) {
						$admin->password = bcrypt($request->input('newPass1'));
						$admin->save();
						$resp['status'] = true;
						$resp['msg'] = '修改成功';
					} else {
						$resp['status'] = false;
						$resp['msg'] = '两次密码不一致';
					}
				} else {
					$resp['status'] = false;
					$resp['msg'] = '旧密码不正确';
				}
			} else {
				$resp['status'] = false;
				$resp['msg'] = '表单不能为空';
			}
		} else {
			$resp['status'] = false;
			$resp['msg'] = '未知的参数TYPE';
		}
		return $resp;
	}
}
