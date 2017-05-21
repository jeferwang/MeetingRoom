<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Notice;
use App\Room;
use App\Term;
use App\Tip;

class IndexController extends Controller
{
	public function index()
	{
		$noticeOne = Notice::latest()->first(); // 最新的公告
		$roomList = Room::all();    // 会议室列表
		$termList = Term::all();
		$firstTipContent = Tip::where('id', 1)->first();
		if (!$firstTipContent) {
			$firstTipContent = '暂无使用须知';
		} else {
			$firstTipContent = $firstTipContent->content;
		}
		return view('frontend.index.index',
			[
				'noticeOne' => $noticeOne,
				'roomList'  => $roomList,
				'termList'  => $termList,
				'tip'       => $firstTipContent,
			]);
	}
}
