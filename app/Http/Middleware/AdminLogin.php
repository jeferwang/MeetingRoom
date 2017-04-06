<?php

namespace App\Http\Middleware;

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
		if (!$request->cookie('admin_login')) {
			return redirect(route('admin.logout'));
		}
		return $next($request);
	}
	
}
