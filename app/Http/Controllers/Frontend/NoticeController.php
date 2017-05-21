<?php
namespace app\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
	/*
	 * 前端显示所有公告的列表
	 */
	public function noticeList()
	{
		$nList = Notice::latest()->paginate(10);
		return view('frontend.notice.list', ['nList' => $nList]);
	}
	
	/*
	 * 前端弹窗显示公告
	 */
	public function showNotice(Request $request)
	{
		$nid = $request->input('nid');
		if (!$nid) {
			abort('403', '缺少参数');
		}
		$notice = Notice::findOrFail($nid);
		return view('frontend.notice.show', ['notice' => $notice]);
	}
}