<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Term extends Model
{
	use SoftDeletes;
	protected $fillable = [
		'termName',
		'startTime',
		'weekCount',
		'default',
	];
	protected $dates = ['deleted_at'];
	
	public static function currentTermAndWeeknum()
	{
		$time = time();
		$terms = Term::all();
		foreach ($terms as $term) {
			$timeArea = ['start' => $term->startTime, 'end' => ($term->startTime + (20 * 7 * 24 * 3600))];
			if ($timeArea['start'] < $time && $timeArea['end'] > $time) {
				return ['status' => true, 'term_id' => $term->id, 'weeknum' => ceil((($time - $timeArea['start']) / (7 * 24 * 3600)))];
			}
		}
		return ['status' => false, 'msg' => '未找到当前周的数据或后台配置错误'];
	}
}
