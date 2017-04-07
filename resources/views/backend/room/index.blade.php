@extends('layouts.admin')
@section('title')
	活动室列表
@endsection
@section('breadcrumbs')
	<li>活动室列表</li>
@endsection
@section('head')
	<style>
		td {
			cursor: pointer;
		}
	</style>
@endsection
@section('content')
	<div class="row">
		<table class="table table-hover table-bordered table-responsive table-striped">
			<thead>
			<tr>
				<th>活动室名称</th>
				<th>地址</th>
				<th>备注</th>
				<th>创建时间</th>
				<th>更新时间</th>
				<th>操作</th>
			</tr>
			</thead>
			<tbody>
			@foreach($rooms as $room)
				<tr>
					<td>{{$room->name}}</td>
					<td>{{$room->address or '（无）'}}</td>
					<td>{{$room->description or '（无）'}}</td>
					<td>{{$room->created_at}}</td>
					<td>{{$room->updated_at}}</td>
					<td>
						<button class="btn btn-warning btn-xs"><i class="fa fa-cloud-upload"></i> 更新</button>
						<button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> 删除</button>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
@endsection