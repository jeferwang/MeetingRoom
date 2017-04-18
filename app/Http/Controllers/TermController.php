<?php
namespace App\Http\Controllers;

use App\Term;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
		// Method==POST
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
					$create = Term::create([
						'termName'  => $request->input('termName'),
						'startTime' => $startTime,
						'weekCount' => $request->input('weekCount'),
						'default'   => !Term::exists(),
					]);
					$this->setResp(['status' => true, 'msg' => '添加成功']);
				}
			}
			return $this->resp;
		}// END Method==POST
		$terms = Term::all();
		return view('backend.term.index', ['terms' => $terms]);
	}
	
	public function delTerm(Request $request)
	{
		$tId = $request->input('tId', 0);
		if (!$tId) {
			$this->setResp(['status' => false, 'msg' => '缺少参数tId']);
		}
		$del = Term::findOrFail($tId)->delete();
		$this->setResp(['status' => true, 'msg' => '删除成功']);
		return $this->resp;
	}
	
	public function setDefault(Request $request)
	{
		$tId = $request->input('tId', 0);
		try {
			$term = Term::findOrFail($tId);
		} catch (ModelNotFoundException $e) {
			$this->setResp(['status' => false, 'msg' => '找不到对应的学期']);
			return $this->resp;
		}
		Term::where('default', true)->update(['default' => false]);
		$term->default = true;
		$term->save();
		$this->setResp(['status' => true, 'msg' => '设置成功 ! ']);
		return $this->resp;
	}
}
