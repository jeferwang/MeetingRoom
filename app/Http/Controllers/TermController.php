<?php
namespace App\Http\Controllers;

use function date;
use function dump;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function strtotime;

/*
 * 学期控制器
 * 每学期的开始时间
 * 设定第一周的日期和本学期的总周数
 */

class TermController extends Controller
{
	/**
	 * 后台学期管理页面(单页面)
	 */
	public function index(Request $request)
	{
		if ($request->isMethod('post')) {
			$validator = Validator::make($request->all(),
				[
					'termName'  => 'required',
					'startTime' => 'required|date',
					'weekCount' => 'required|Numeric|min:20|max:25',
				],
				[
					'termName.required'  => '学期名称不能为空',
					'startTime.required' => '开始日期不能为空',
					'startTime.date'     => '开始日期格式错误',
					'weekCount.required' => '周期总数不能为空',
					'weekCount.Numeric'  => '周期总数必须是数字',
					'weekCount.min'      => '周期总数最小为20',
					'weekCount.max'      => '周期总数最大为25',
				]);
			if ($validator->fails()) {
				$this->setResp(['status' => false, 'msg' => $validator->errors()->first()]);
			} else {
				$startTime = strtotime($request->input('startTime'));
				if (date('w', $startTime) != 1) {
					$this->setResp(['status' => false, 'msg' => '学期开始日期必须是星期一 ! ']);
				} else {
					$this->setResp(['status' => true, 'msg' => '添加成功']);
				}
			}
			return $this->resp;
		}
		return view('backend.term.index');
	}
}
