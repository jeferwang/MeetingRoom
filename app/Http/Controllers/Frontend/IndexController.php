<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Notice;

class IndexController extends Controller
{
	public function index()
	{
		$noticeOne = Notice::latest()->first();
		
		return view('frontend.index.index',['noticeOne'=>$noticeOne]);
	}
}
