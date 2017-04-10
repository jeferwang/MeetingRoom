<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Apply extends Model
{
	protected $fillable = [
		'room_id', 'start_time', 'end_time', 'people_name', 'people_tel', 'meeting_title', 'meeting_description',
	];
	
	public function validateData()
	{
		// 整体验证
		$validator = Validator::make($this->attributes, [
			'room_id' => 'required', 'start_time' => 'required', 'end_time' => 'required', 'people_name' => 'required', 'people_tel' => 'required', 'meeting_title' => 'required',
		], [
			'room_id.required' => '会议地点必须选择一项', 'start_time.required' => '开始时间不能为空', 'end_time.required' => '结束时间不能为空', 'people_name.required' => '预约者姓名不能为空', 'people_tel.required' => '预约者电话不能为空', 'meeting_title.required' => '会议标题不能为空',
		]);
		if ($validator->fails()) {
			return ['status' => false, 'msg' => $validator->errors()->first()];
		}
		// 验证时间
		$this->start_time = (int)strtotime($this->start_time);
		$this->end_time = (int)strtotime($this->end_time);
		$checkTime = Room::checkTime($this->start_time, $this->end_time);
		if (!$checkTime['status']) {
			return $checkTime;
		}
		$checkUsable = Room::checkRoomUsable($this->room_id, $this->start_time, $this->end_time);
		if ($checkUsable) {
			return ['status' => false, 'msg' => '您所选择的时间段已经被预约,请更换其他时间或其他会议室'];
		}
		return ['status' => true];
	}
	
}