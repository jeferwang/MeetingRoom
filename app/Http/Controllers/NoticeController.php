<?php

namespace App\Http\Controllers;

use App\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NoticeController extends Controller
{
	/*
	 * 后台管理公告页面
	 * 添加
	 * 删除
	 */
	public function index()
	{
		$notices = Notice::paginate(10);
		$themeMap = ['info' => '提示', 'warning' => '警告', 'danger' => '严重'];
		return view('backend.notice.index', ['notices' => $notices, 'themeMap' => $themeMap]);
	}
	
	public function noticeAdd(Request $request)
	{
		if ($request->isMethod('post')) {
			$validator = Validator::make($request->all(), [
				'title'   => 'required|max:50',
				'theme'   => 'required',
				'content' => 'required',
			], [
				'title.required'   => '标题不能为空',
				'title.max'        => '标题不能超过50个字符',
				'theme.required'   => '主题颜色不能为空',
				'content.required' => '内容不能为空',
			]);
			if ($validator->fails()) {
				$this->setResp(['status' => false, 'msg' => $validator->errors()->first()]);
			} else {
				Notice::create($request->all());
				$this->setResp(['status' => true, 'msg' => '添加公告成功']);
			}
			return $this->resp;
		}
		return view('backend.notice.add');
	}
	
	public function noticeEdit()
	{
	
	}
	
	public function noticeDel()
	{
	
	}
}
