@extends('layouts.admin')
@section('title')
	公告列表
@endsection
@section('breadcrumbs')
	<li class="active">公告列表</li>
@endsection
@section('content')
	<table class="table table-hover table-responsive table-bordered table-hover table-striped">
		<thead>
		<tr>
			<th>公告标题</th>
			<th>主题颜色</th>
			<th>操作</th>
		</tr>
		</thead>
		<tbody>
		@foreach($notices as $key=>$notice)
			<tr>
				<td>{{$notice->title}}</td>
				<td><span class="badge badge-{{$notice->theme}}">{{$themeMap[$notice->theme]}}</span></td>
				<td>
					<button class="btn btn-warning btn-xs">修改</button>
					<button class="btn btn-danger btn-xs">删除</button>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
@endsection