<?php
namespace App\Http\Controllers\Frontend;

use App\Apply;
use App\Http\Controllers\Controller;
use App\Room;
use App\Term;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ApplyController extends Controller
{
	// 前台提交表单进行申请
	public function apply(Request $request)
	{
		$validator = Validator($request->all(),
			[
				'term_id'       => 'required|numeric',
				'weeknum'       => 'required|numeric',
				'week'          => 'required|numeric',
				'meeting_time'  => 'required|numeric',
				'room_id'       => 'required|numeric',
				'meeting_title' => 'required',
				'people_name'   => 'required',
				'people_tel'    => 'required|numeric',
			],
			[
				'term_id.required'       => '请选择学期',
				'weeknum.required'       => '请选择周数',
				'week.required'          => '请选择星期',
				'meeting_time.required'  => '请选择会议时间',
				'room_id.required'       => '请选择会议室',
				'meeting_title.required' => '请填写会议概要',
				'people_name.required'   => '请填写申请人姓名',
				'people_tel.required'    => '请填写手机号码',
				'term_id.numeric'        => '学期数据格式错误,请刷新重试',
				'weeknum.numeric'        => '周数格式错误,请刷新重试',
				'week.numeric'           => '星期格式错误,请刷新重试',
				'meeting_time.numeric'   => '您选择的会议室数据格式错误,请刷新重试',
				'room_id.numeric'        => '您选择的会议室格式错误,请刷新重试',
				'people_tel.numeric'     => '您输入的手机号码格式错误,请修改',
			]);
		if (!$validator->fails()) {
			$apply = new Apply();
			$apply->fill($request->all());
			$apply->save();
			$this->setResp(['status' => true, 'msg' => '提交成功,请等待审核']);
		} else {
			$this->setResp(['status' => false, 'msg' => $validator->errors()->first()]);
		}
		return $this->resp;
	}
	
	/*
	 * Page
	 * 前台显示当前预约情况
	 */
	public function applyList()
	{
		$termList = Term::all();
		$roomList = Room::all();
		return view('frontend.apply.applylist',
			[
				'termList' => $termList,
				'roomList' => $roomList,
			]);
	}
	
	/**
	 * Ajax返回按周查询结果
	 * 查询条件:学期id&周数id
	 * term_id & weeknum
	 *
	 * @param Request|null $request
	 * @return array
	 */
	public function queryTable(Request $request)
	{
		if ($request->isMethod('post')) {
			$validator = validator($request->all(),
				[
					'term_id' => 'required|numeric',
					'weeknum' => 'required|numeric',
				],
				[
					'term_id.required' => '请选择学期',
					'term_id.numeric'  => '学期数据格式异常,请刷新重试',
					'weeknum.required' => '请选择周数',
					'weeknum.numeric'  => '周数数据格式异常,请刷新重试',
				]);
			if($validator->fails()){
				return ['status'=>false,'msg'=>$validator->errors()->first()];
			}
			$term_id = $request->input('term_id');
			$weeknum = $request->input('weeknum');
		} else if ($request->isMethod('get')) {
			$getCurr = Term::currentTermAndWeeknum();
			if ($getCurr['status']) {
				$term_id = $getCurr['term_id'];
				$weeknum = $getCurr['weeknum'];
			} else {
				return ['status' => true, 'msg' => '获取成功', 'data' => $getCurr['msg']];
			}
		} else {
			return ['status' => false, 'msg' => 'http请求方式错误'];
		}
		$applies = Apply::where('term_id', $term_id)->where('weeknum', $weeknum)->get();
		$roomList = Room::all();
		$weekList = [null, '一', '二', '三', '四', '五', '六', '日'];
		$timeList = [null, '上午第一大节', '上午第二大节', '下午第一大节', '下午第二大节', '晚上第一大节'];
		$html = <<<HTML
		<table class="table table-bordered table-hover table-striped table-responsive" style="text-align: left;">
			<tr>
				<th colspan="2">
				时间\地点
				</th>
HTML;
		foreach ($roomList as $v) {
			$html .= "<th>$v->name</th>";
		}
		$html .= '</tr>';
		for ($w = 1; $w <= 7; $w++) {
			for ($s = 1; $s <= 5; $s++) {
				$html .= '<tr>';
				if ($s == 1) {
					$html .= "<th rowspan='5'>星期$weekList[$w]</th>";
				}
				$html .= "<th>$timeList[$s]</th>";
				foreach ($roomList as $r) {
					$html .= '<td>';
					$ins = false;
					foreach ($applies as $apply) {
						if ($apply->week == $w && $apply->meeting_time == $s && $apply->room_id == $r->id) {
							if ($ins) {
								$html .= ' || ';
							}
							switch ($apply->pass) {
								case 0:
									$html .= "<span style='color: grey;'>$apply->meeting_title</span>";
									break;
								case 1:
									$html .= "<span style='color: green;'>$apply->meeting_title</span>";
									break;
								case 2:
									$html .= "<span style='color: red;'>$apply->meeting_title</span>";
									break;
								default:
									$html .= "<span style='color: grey;'>$apply->meeting_title</span>";
							}
							$ins = true;
						}
					}
					$html .= '</td>';
//					if (!$ins) {
//						$html .= "<td></td>";
//					}
				}
				$html .= '</tr>';
			}
		}
		$html .= '</table>';
		return ['status' => true, 'msg' => '获取成功', 'data' => $html];
	}
}
