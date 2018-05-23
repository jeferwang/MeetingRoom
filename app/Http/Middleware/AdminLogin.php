<?php

namespace App\Http\Middleware;

use App\Admin;
use Closure;

class AdminLogin
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure                 $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$admin_login = json_decode($request->cookie('admin_login'),true);
		$admin_name = $admin_login['admin_name'];
		$check = Admin::where('admin_name', $admin_name)->first();
		if (!$admin_login || !$admin_name || !$check) {
			return redirect(route('admin.logout'));
		}
		return $next($request);
	}
	
}
