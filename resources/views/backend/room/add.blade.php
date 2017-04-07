@extends('layouts.admin')
@section('title')
	添加活动室
@endsection
@section('breadcrumbs')
	<li>添加活动室</li>
@endsection
@section('content')
	<div class="row">
		<form action="" method="post" id="room_form">
			{{csrf_field()}}
			<div class="panel panel-success">
				<div class="panel-heading">
					会议室名称
				</div>
				<div class="form-group panel-body">
					<label for="name" class="control-label">请填写新增的会议室的名称（必填），例如：行政楼一楼会议室</label>
					<input type="text" name="name" id="name" class="form-control">
				</div>
			</div>
			<div class="panel panel-warning">
				<div class="panel-heading">
					会议室地点
				</div>
				<div class="form-group panel-body">
					<label for="address" class="control-label">请填写会议室的详细地址（可不填），例如：春秋大道与xxx交叉口北行政楼一楼101室</label>
					<textarea name="address" id="address" class="form-control" rows="5"></textarea>
				</div>
			</div>
			<div class="panel panel-danger">
				<div class="panel-heading">
					会议室简介/备注
				</div>
				<div class="form-group panel-body">
					<label for="description" class="control-label">请填写会议室的用途/备注（可不填）</label>
					<textarea name="description" id="description" class="form-control" rows="5"></textarea>
				</div>
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-success" value="添加条目" style="padding: 5px 40px;cursor: pointer;border-radius: 15px 0">
			</div>
		</form>
	</div>
@endsection
@section('foot')
	<script>
		var layer = layui.layer;
		$().ready(function () {
			$("#room_form").ajaxForm();
		});
		$("#room_form").on('submit', function (e) {
			e.preventDefault();
			var loadIndex;
			$("#room_form").ajaxSubmit({
				beforeSubmit: function () {
					loadIndex = layer.load(2);
				},
				success: function (data) {
					layer.alert(data['msg'], {
						icon: data['status'] ? 6 : 5
						, btn: ['确定', '取消']
						, yes: function () {
							if (data['status']) {
								location.href = "{{route('admin.room.index')}}";
							}
						}
					})
				},
				error: function () {
					layer.alert('网络故障,请刷新重试 ! ', {
						icon: 2
						, time: 0
						, btn: ['刷新', '取消']
						, yes: function () {
							location.reload(true);
						}
					})
				},
				complete: function () {
					layer.close(loadIndex);
				}
			});
		});
	</script>
@endsection