@extends('layouts.admin')

@section('title')
	后台管理首页
@endsection

@section('content')
	<div class="row">
		<div class="alert alert-danger">
			提示：管理系统需要至少IE9以上的浏览器支持，请使用最新版的 360浏览器（极速模式）、QQ浏览器（极速模式）、Chrome、Firefox 等进行操作
		</div>
	</div>
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading">
				账户信息
			</div>
			<ul class="list-group">
				<li class="list-group-item">当前管理员：{{json_decode(\Illuminate\Support\Facades\Cookie::get('admin_login'),true)['admin_name']}}</li>
				<li class="list-group-item">管理员ID：{{json_decode(\Illuminate\Support\Facades\Cookie::get('admin_login'),true)['admin_id']}}</li>
			</ul>
		</div>
	</div>
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading">
				服务器信息
			</div>
			<ul class="list-group">
				<li class="list-group-item">当前主机名：<?php echo $_SERVER['SERVER_NAME']; ?> </li>
				<li class="list-group-item">网站运行环境：<?php echo $_SERVER['SERVER_SOFTWARE']; ?></li>
				<li class="list-group-item">浏览器信息：<?php echo $_SERVER['HTTP_USER_AGENT'];  ?> </li>
				<li class="list-group-item">文件根目录：<?php echo $_SERVER['DOCUMENT_ROOT'];  ?> </li>
				<li class="list-group-item">CGI规范版本：<?php echo $_SERVER['GATEWAY_INTERFACE']; ?> </li>
				<li class="list-group-item">网络通信协议：<?php echo $_SERVER['SERVER_PROTOCOL']; ?> </li>
				<li class="list-group-item">当前登录IP：<?php echo $_SERVER['REMOTE_ADDR'];  ?> </li>
			</ul>
		</div>
	</div>
@endsection