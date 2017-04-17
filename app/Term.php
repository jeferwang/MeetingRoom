<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
	protected $fillable = [
		'termName',
		'startTime',
		'weekCount',
	];
}
