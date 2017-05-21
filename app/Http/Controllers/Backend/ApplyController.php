<?php
namespace app\Http\Controllers\Backend;

use App\Apply;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApplyController extends Controller
{
	/*
	 * 后端进行审核的主页面
	 */
	public function index()
	{
		$applies = Apply::latest()->paginate(15);
		return view('backend.apply.index', ['applies' => $applies]);
	}
	
	/*
	 * Ajax请求审核是否通过
	 */
	public function ajaxPass(Request $request)
	{
		$validator = Validator::make($request->all(),
			[
				'apply_id' => 'required|Numeric',
				'is_pass'  => ['required', Rule::in(['true', 'false'])],
			],
			[
				'apply_id.required' => '参数缺失:apply_id！',
				'apply_id.Numeric'  => '参数异常:apply_id！',
				'is_pass.required'  => '参数缺失:is_pass！',
				'is_pass.in'        => '参数异常:is_pass！',
			]);
		if ($validator->fails()) {
			$this->setResp(['status' => false, 'msg' => $validator->errors()->first()]);
			return $this->resp;
		}
		$apply = Apply::find($request->input('apply_id'));
		$is_pass = $request->input('is_pass');
		if ($is_pass == 'true') {
			$apply->pass = 1;
		} else if ($is_pass == 'false') {
			$apply->pass = 2;
			if ($request->input('reason') != '') {
				$apply->reason = $request->input('reason');
			}
		} else {
			$apply->pass = null;
		}
		if ($apply->update()) {
			$this->setResp(['status' => true, 'msg' => '操作成功']);
		} else {
			$this->setResp(['status' => false, 'msg' => '操作失败']);
		}
		return $this->resp;
	}
}