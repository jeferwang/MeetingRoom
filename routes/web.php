<?php
// 后台
use function foo\func;

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
						Route::get('index', 'Backend\RoomController@index')->name('index');
						Route::match(['get', 'post'], 'add', 'Backend\RoomController@add')->name('add');
						Route::match(['get', 'post'], 'update/{room_id}', 'Backend\RoomController@update')->name('update');
						Route::match(['get', 'post'], 'delete/{room_id}', 'Backend\RoomController@delete')->name('delete');
					});
				// 预约审核
				Route::group(['prefix' => 'apply', 'as' => 'apply.'],
					function () {
						Route::get('index', 'Backend\ApplyController@index')->name('index');
						Route::post('pass', 'Backend\ApplyController@ajaxPass')->name('pass');
					});
				// 公告管理
				Route::group(['prefix' => 'notice', 'as' => 'notice.'],
					function () {
						Route::get('index', 'Backend\NoticeController@index')->name('index');
						Route::match(['get', 'post'], 'add', 'NoticeController@noticeAdd')->name('add');
						Route::post('del', 'Backend\NoticeController@noticeDel')->name('del');
						Route::match(['get', 'post'], 'update', 'Backend\NoticeController@noticeUpdate')->name('update');
					});
				// 学期/周数管理
				Route::group(['prefix' => 'term', 'as' => 'term.'],
					function () {
						Route::match(['get', 'post'], 'index', 'Backend\TermController@index')->name('index');
						Route::post('del', 'Backend\TermController@delTerm')->name('del');
						Route::post('default', 'Backend\TermController@setDefault')->name('default');
					});
				//使用提示管理
				Route::group(['prefix' => 'tip', 'as' => 'tip.'],
					function () {
						Route::match(['get', 'post'], 'index', 'Backend\TipController@index')->name('tip');
					});
			});
	});
// 前端
Route::group(['as' => 'frontend.'],
	function () {
		// 首页
		Route::get('', 'Frontend\IndexController@index')->name('index');
		// 预约列表
		Route::get('applylist', 'Frontend\ApplyController@applyList')->name('apply_list');
		// 管理办法:直接返回视图
		Route::get('manage',
			function () {
				return view('frontend.index.manage');
			})->name('manage');
		// 公告列表
		Route::get('noticelist', 'Frontend\NoticeController@noticeList')->name('notice_list');
		Route::get('shownotice', 'Frontend\NoticeController@showNotice')->name('show_notice');
		// 提交会议室申请
		Route::post('apply', 'Frontend\ApplyController@apply')->name('apply');
		// 根据学期ID和周数ID查询那一周的预约信息
		Route::match(['get', 'post'], 'querytable', 'Frontend\ApplyController@queryTable')->name('query_table');
	});