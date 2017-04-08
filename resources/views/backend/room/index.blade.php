@extends('layouts.admin')
@section('title')
	活动室列表
@endsection
@section('breadcrumbs')
	<li class="active">活动室列表</li>
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
						<a href="{{route('admin.room.update',['room_id'=>$room->id])}}" class="btn btn-warning btn-xs"><i class="fa fa-cloud-upload"></i> 更新</a>
						<a onclick="del_room(this,'{{route('admin.room.delete',['room_id'=>$room->id])}}')" class="btn btn-danger btn-xs" id="del"><i class="fa fa-trash-o"></i> 删除</a>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
@endsection

@section('foot')
	<script>
		var layer = layui.layer;
		function del_room(obj, href) {
			layer.alert('确认删除这一个会议室吗？警告，删除操作会影响到已经预约的会议室！', {
				icon: 2
				, btn: ['删除', '取消']
				, yes: function (i) {
					layer.close(i);
					$.get(href, {}, function (data) {
						if (data['status']) {
							layer.msg('删除成功！', {
								icon: 6
							});
							$(obj).parent('td').parent('tr').hide(1000);
						} else {
							layer.msg('删除失败，请刷新重试！', {
								icon: 5
							});
						}
					});
				}
			});
		}
	</script>
@endsection