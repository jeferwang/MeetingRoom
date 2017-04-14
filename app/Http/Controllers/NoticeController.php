<?php
namespace App\Http\Controllers;

use function abort;
use App\Notice;
use const false;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function view;

class NoticeController extends Controller
{
	/*
	 * 后台管理公告页面
	 * 添加
	 * 删除
	 */
	public function index()
	{
		// 分页取出结果
		$notices = Notice::paginate(10);
		// theme映射
		$themeMap = ['info' => '提示', 'warning' => '警告', 'danger' => '严重'];
		
		// 渲染页面
		return view('backend.notice.index', ['notices' => $notices, 'themeMap' => $themeMap]);
	}
	
	/*
	 * 添加新的公告
	 */
	public function noticeAdd(Request $request)
	{
		// POST请求执行添加
		if ($request->isMethod('post')) {
			// 验证规则
			$validateRule = [
				'title'   => 'required|max:50',
				'theme'   => 'required',
				'content' => 'required',
			];
			$errorMsg = [
				'title.required'   => '标题不能为空',
				'title.max'        => '标题不能超过50个字符',
				'theme.required'   => '主题颜色不能为空',
				'content.required' => '内容不能为空',
			];
			// 执行验证
			$validator = Validator::make($request->all(), $validateRule, $errorMsg);
			// 是否通过验证
			if ($validator->fails()) {
				$this->setResp(['status' => false, 'msg' => $validator->errors()->first()]);
			} else {
				Notice::create($request->all());
				$this->setResp(['status' => true, 'msg' => '添加公告成功']);
			}
			
			// 返回Ajax结果
			return $this->resp;
		}
		
		// GET请求得到页面
		return view('backend.notice.add');
	}
	
	/*
	 * 更新公告
	 */
	public function noticeUpdate(Request $request)
	{
		$nid = $request->input('nid');
		if (!$nid) {
			abort(403, 'Missing Parameter');
		}
		$notice = Notice::findOrFail($nid);
		// POST请求执行添加
		if ($request->isMethod('post')) {
			// 验证规则
			$validateRule = [
				'nid'     => 'required|Numeric',
				'title'   => 'required|max:50',
				'theme'   => 'required',
				'content' => 'required',
			];
			$errorMsg = [
				'nid.required'     => '参数缺失',
				'nid.Numeric'      => '参数格式不正确',
				'title.required'   => '标题不能为空',
				'title.max'        => '标题不能超过50个字符',
				'theme.required'   => '主题颜色不能为空',
				'content.required' => '内容不能为空',
			];
			// 执行验证
			$validator = Validator::make($request->all(), $validateRule, $errorMsg);
			// 是否通过验证
			if ($validator->fails()) {
				$this->setResp(['status' => false, 'msg' => $validator->errors()->first()]);
			} else {
				$notice->fill($request->all());
				$save = $notice->save();
				if ($save) {
					$this->setResp(['status' => true, 'msg' => '保存成功']);
				} else {
					$this->setResp(['status' => false, 'msg' => '保存失败']);
				}
			}
			
			// 返回Ajax结果
			return $this->resp;
		}
		
		return view('backend.notice.update', ['notice' => $notice]);
	}
	
	/*
	 * 删除一篇公告(Ajax)
	 */
	public function noticeDel(Request $request)
	{
		// 取出参数
		$nid = $request->input('nid', null);
		if (!$nid) {
			$this->setResp(['status' => false, 'msg' => '缺少参数nid']);
		}
		// 执行删除
		$del = Notice::where('id', $nid)->delete();
		// 检查是否删除成功
		if ($del) {
			$this->setResp(['status' => true, 'msg' => '删除成功']);
		} else {
			$this->setResp(['status' => false, 'msg' => '删除错误,请刷新重试']);
		}
		
		// 返回Ajax结果
		return $this->resp;
	}
	/*
	 * 前端显示所有公告的列表
	 */
	public function noticeList()
	{
		$nList=Notice::latest()->paginate(10);
		return view('frontend.notice.list',['nList'=>$nList]);
	}
	
	public function showNotice(Request $request)
	{
		$nid=$request->input('nid');
		if(!$nid){
		    abort('403','缺少参数');
		}
		$notice=Notice::findOrFail($nid);
		return view('frontend.notice.show',['notice'=>$notice]);
	}
}
