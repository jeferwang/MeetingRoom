<?php

namespace App\Http\Controllers;

use App\Apply;
use Illuminate\Http\Request;

class ApplyController extends Controller
{
	// 前台提交表单进行申请
	public function apply(Request $request)
	{
		$apply = new Apply();
		$apply->fill($request->all());
		$validate = $apply->validateData();
		if ($validate['status']) {
			$apply->save();
			$this->setResp(['status' => true, 'msg' => '提交成功,请等待审核']);
		} else {
			$this->setResp($validate);
		}
		return $this->resp;
	}
}
