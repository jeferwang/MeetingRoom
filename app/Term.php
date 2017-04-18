<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Term extends Model
{
	protected $fillable = [
		'termName',
		'startTime',
		'weekCount',
		'default',
	];
	
	public static function findCurrentTerm()
	{
		$terms = Term::all();
		foreach ($terms as $term) {
			$startTime = (int)$term->startTime;
			if (time() > $startTime && time() < $startTime + (int)($term->weekCount) * 7 * 24 * 60 * 60) {
				$currentTerm = $term;
			}
		}
		if (!isset($currentTerm)) {
			return false;
		}
		return $currentTerm;
	}
	
	public static function findWeekApply($termId)
	{
		try {
			$term = Term::findOrFail($termId);
		} catch (ModelNotFoundException $e) {
			return ['status' => false, 'msg' => '找不到对应的学期'];
		}
		$data = [];
		for ($i = 1; $i <= $term->weekCount; $i++) {
			$data[$i]['weekName'] = '第'.$i.'周';
			$startTime = (int)($term->startTime) + ($i - 1) * (7 * 24 * 60 * 60);
			$endTime = (int)($term->startTime) + $i * (7 * 24 * 60 * 60);
			$applies = Apply::where([
				['start_time', '>', $startTime],
				['end_time', '<', $endTime],
			])->latest()->get();
			$applies = $applies->map(function ($apply) {
				$apply->stampToTime();
				return $apply;
			});
			$data[$i]['applies'] = $applies->toArray();
		}
		return ['status' => true, 'list' => $data, 'msg' => '查询成功'];
	}
}
