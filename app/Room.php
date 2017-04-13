<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
	protected $guarded = [];
	
	/*
	 * 检查Room是否在当前选择时间段可用
	 * 返回值:Apply Or null
	 */
	public static function checkRoomUsable($room_id, $start_time, $end_time)
	{
		// $res = true;
		return Apply::where('room_id', $room_id)
		            ->whereIn('pass', [0,1])
		            ->where(function ($query) use ($start_time, $end_time) {
			            $query->where([['start_time', '>=', $start_time], ['start_time', '<', $end_time]])->orWhere([
				            ['start_time', '<=', $start_time,], ['end_time', '>=', $end_time,],
			            ])->orWhere([['end_time', '>', $start_time], ['end_time', '<=', $end_time]]);
		            })->first();
		// $applies = Apply::where('room_id', $room_id)->where('start_time', '>', time())->where('pass', 'in', [null, 'yes'])->get();
		// foreach ($applies as $key => $apply) {
		// 	if (($apply->start_time >= $start_time && $apply->start_time < $end_time) && ($apply->start_time <= $start_time && $apply->end_time >= $end_time) && ($apply->end_time > $start_time && $apply->end_time <= $end_time)) {
		// 		$res = false;
		// 	}
		// }
		// return $res;
	}
	
	/*
	 * 检查时间填写是否正确
	 */
	public static function checkTime($start_time, $end_time)
	{
		// 验证时间的正确性
		if ($start_time == 0 || $end_time == 0) {
			return ['status' => false, 'msg' => '时间格式错误'];
		} else if ($start_time >= $end_time || $start_time < time()) {
			return ['status' => false, 'msg' => '时间选择错误'];
		} else if (($end_time - $start_time) > 86400) {
			return ['status' => false, 'msg' => '预约会议室时长不能大于24小时'];
		} else {
			return ['status' => true];
		}
	}
}
