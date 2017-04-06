<?php
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
	// 自动跳转
	Route::get('', function () {
		return redirect(route('admin.index'));
	});
	// 登录
	Route::get('login', 'LoginController@index')->name('login_page');
	Route::post('login', 'LoginController@login')->name('login');
	Route::get('logout', 'LoginController@logout')->name('logout');
	// 登录后
	Route::group(['middleware' => ['admin_login']], function () {
		Route::get('index', 'AdminController@index')->name('index');
	});
});

// 主页
Route::get('/', function () {
	return view('welcome');
});