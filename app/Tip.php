<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * 使用提示
 * Class Tip
 *
 * @package App
 */
class Tip extends Model
{
	protected $fillable = ['content', 'default'];
}