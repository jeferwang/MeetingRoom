<?php
namespace App\Http\Controllers\Backend;

use App\Tip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * 后台的使用提示控制器
 * Class TipController
 *
 * @package App\Http\Controllers\Backend
 */
class TipController extends Controller
{
	/**
	 * 后台显示Tips列表
	 */
	public function index(Request $request)
	{
		if ($request->isMethod('get')) {
			return view('backend.tip.index');
		} else if ($request->isMethod('post')) {
			$content=$request->input('content');
			$firstTip=Tip::where('id',1)->first();
			if(!$firstTip){
			    $firstTip=new Tip();
			    $firstTip->id=1;
			}
			$firstTip->content=$content;
			if($firstTip->save()){
				return ['status'=>true,'msg'=>'保存成功'];
			}else{
				return ['status'=>false,'msg'=>'保存失败,请复制内容之后刷新重试'];
			}
		} else {
			return ['status' => false, 'msg' => '请求错误'];
		}
	}
}
