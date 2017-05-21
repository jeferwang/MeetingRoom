<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Room;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
	/*
	 * 后台的会议室管理首页
	 */
	public function index()
	{
		$rooms = Room::all();
		return view('backend.room.index', ['rooms' => $rooms]);
	}
	
	/*
	 * 后台添加会议室
	 */
	public function add(Request $request)
	{
		if ($request->isMethod('post')) {
			$resp = ['status' => true, 'msg' => '添加成功,点击确定跳转到列表页'];
			$validator = Validator::make($request->all(),
				[
					'name' => 'required|max:30',
				],
				[
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
		return view('backend.room.add', ['type' => 'add']);
	}
	
	/*
	 * 后台更新会议室
	 */
	public function update(Request $request)
	{
		try {
			$room = Room::findOrFail(Route::input('room_id'));
			if ($request->isMethod('post')) {
				$resp = ['status' => true, 'msg' => '更新成功,点击确定跳转到列表页'];
				$validator = Validator::make($request->all(),
					[
						'name' => 'required|max:30',
					],
					[
						'name.required' => '会议室名称必须填写',
						'name.max'      => '会议室名称不能超过30个字符',
					]);
				if ($validator->fails()) {
					$resp['status'] = false;
					$resp['msg'] = $validator->errors()->first('name');
				} else {
					$room->fill($request->all());
					$upRoom = $room->update();
					if (!$upRoom) {
						$resp['status'] = false;
						$resp['msg'] = '未知原因添加失败,请稍后重试';
					}
				}
				return $resp;
			}
			return view('backend.room.add', ['type' => 'update', 'room' => $room]);
		} catch (ModelNotFoundException $e) {
			return 'NotFound';
		}
	}
	
	/*
	 * 后台删除会议室
	 */
	public function delete()
	{
		$room = Room::findOrFail(Route::input('room_id'));
		if ($room->delete()) {
			return ['status' => true];
		} else {
			return ['status' => false];
		}
	}

//	public function show_meetingroom_list()
//	{
////		$roomList
//		return view('frontend.index.roomlist');
//	}
//	public function getRoomList(Request $request)
//	{
//		$start_time = (int)strtotime($request->input('start_time'));
//		$end_time = (int)strtotime($request->input('end_time'));
//		$checkTime = Room::checkTime($start_time, $end_time);
//		if (!$checkTime['status']) {
//			$this->setResp($checkTime);
//			return $this->resp;
//		}
//		// 获取所有的会议室数据数据
//		$rooms = Room::all();
//		foreach ($rooms as $key => $room) {
//			$rooms[$key]->usable = Room::checkRoomUsable($room->id, $start_time, $end_time) ? false : true;
//		}
//		$this->setResp(['status' => true, 'msg' => '查询成功', 'data' => $rooms]);
//		return $this->resp;
//	}
}
