<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
	public function index()
	{
		$rooms = Room::all();
		return view('backend.room.index', ['rooms' => $rooms]);
	}
	
	public function add(Request $request)
	{
		if ($request->isMethod('post')) {
			$resp = ['status' => true, 'msg' => '添加成功,点击确定跳转到列表页'];
			$validator = Validator::make($request->all(), [
				'name' => 'required|max:30',
			], [
				'name.required' => '会议室名称必须填写',
			]);
			if ($validator->fails()) {
				$resp['status'] = false;
				$resp['msg'] = $validator->errors()->first('name');
			} else {
				$newRoom = Room::create($request->all());
				if (!$newRoom) {
					$resp['status'] = false;
					$resp['msg'] = '未知原因添加失败,请稍后重试';
				}
			}
			return $resp;
		}
		return view('backend.room.add');
	}
}
