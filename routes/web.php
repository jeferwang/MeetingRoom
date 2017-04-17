<?php
// 后台
Route::group(['prefix' => 'admin', 'as' => 'admin.'],
	function () {
		// 自动跳转
		Route::get('',
			function () {
				return redirect(route('admin.index'));
			});
		// 登录
		Route::get('login', 'Backend\LoginController@index')->name('login_page');
		Route::post('login', 'Backend\LoginController@login')->name('login');
		Route::get('logout', 'Backend\LoginController@logout')->name('logout');
		// 登录后
		Route::group(['middleware' => ['admin_login']],
			function () {
				// 后台首页
				Route::get('index', 'Backend\AdminController@index')->name('index');
				// 管理员账户模块
				Route::group(['prefix' => 'account', 'as' => 'account.'],
					function () {
						Route::match(['get', 'post'], 'changeinfo', 'Backend\AdminController@changeInfo')->name('change_info');
					});
				// 活动室
				Route::group(['prefix' => 'room', 'as' => 'room.'],
					function () {
						Route::get('index', 'RoomController@index')->name('index');
						Route::match(['get', 'post'], 'add', 'RoomController@add')->name('add');
						Route::match(['get', 'post'], 'update/{room_id}', 'RoomController@update')->name('update');
						Route::match(['get', 'post'], 'delete/{room_id}', 'RoomController@delete')->name('delete');
					});
				// 预约审核
				Route::group(['prefix' => 'apply', 'as' => 'apply.'],
					function () {
						Route::get('index', 'ApplyController@index')->name('index');
						Route::post('pass', 'ApplyController@ajaxPass')->name('pass');
					});
				// 公告管理
				Route::group(['prefix' => 'notice', 'as' => 'notice.'],
					function () {
						Route::get('index', 'NoticeController@index')->name('index');
						Route::match(['get', 'post'], 'add', 'NoticeController@noticeAdd')->name('add');
						Route::post('del', 'NoticeController@noticeDel')->name('del');
						Route::match(['get', 'post'], 'update', 'NoticeController@noticeUpdate')->name('update');
					});
				// 学期/周数管理
				Route::group(['prefix' => 'term', 'as' => 'term.'],
					function () {
						Route::match(['get', 'post'], 'index', 'TermController@index')->name('index');
						Route::post('del','TermController@delTerm')->name('del');
					});
			});
	});
// 前端
Route::group(['as' => 'frontend.'],
	function () {
		// 首页
		Route::get('', 'Frontend\IndexController@index')->name('index');
		// 预约列表
		Route::get('applylist', 'ApplyController@applyList')->name('apply_list');
		// 管理办法
		Route::get('manage',
			function () {
				return view('frontend.index.manage');
			})->name('manage');
		// 公告列表
		Route::get('noticelist', 'NoticeController@noticeList')->name('notice_list');
		Route::get('shownotice', 'NoticeController@showNotice')->name('show_notice');
		// 前端js接口
		Route::group(['prefix' => 'json', 'as' => 'json.'],
			function () {
				// 获取符合条件的会议室列表
				Route::post('rooms', 'RoomController@getRoomList')->name('rooms');
				// 提交表单提交申请
				Route::post('apply', 'ApplyController@apply')->name('apply');
			});
	});