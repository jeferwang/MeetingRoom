@extends('layouts.admin')
@section('head')
	<link rel="stylesheet" href="/assets/layui/css/layui.css">
@endsection
@section('title')
	修改管理员信息
@endsection
@section('breadcrumbs')
	<li>修改管理员信息</li>
@endsection
@section('content')
	<div class="row">
		<div class="alert alert-warning">
			修改了登录名或密码之后需要 <a href="{{route('admin.logout')}}">重新登录</a>
		</div>
	</div>
	<div class="row">
		<div class="panel panel-success">
			<div class="panel-heading">
				修改登录名
			</div>
			<div class="panel-body">
				<form action="" method="post" id="name_form">
					{{csrf_field()}}
					<input type="hidden" name="type" value="name">
					<div class="form-group">
						<label for="admin_name" class="control-label">登录名</label>
						<input type="text" name="admin_name" class="form-control" value="{{$admin->admin_name}}" id="admin_name" required>
					</div>
					<div class="form-group">
						<input type="submit" value="修改登录名" class="btn btn-success">
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="panel panel-warning">
			<div class="panel-heading">
				修改密码
			</div>
			<div class="panel-body">
				<form action="" method="post" id="pass_form">
					{{csrf_field()}}
					<input type="hidden" name="type" value="pass">
					<div class="form-group">
						<label for="oldPass" class="control-label">旧密码</label>
						<input type="password" class="form-control" name="oldPass" id="oldPass" required>
					</div>
					<div class="form-group">
						<label for="newPass1" class="control-label">新密码</label>
						<input type="password" class="form-control" name="newPass1" id="newPass1" required>
					</div>
					<div class="form-group">
						<label for="newPass2" class="control-label">重复密码</label>
						<input type="password" class="form-control" name="newPass2" id="newPass2" required>
					</div>
					<div class="form-group">
						<input type="submit" value="修改密码" class="btn btn-warning">
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
@section('foot')
	<script src="/assets/jqueryForm/jquery.form.min.js"></script>
	<script src="/assets/layui/lay/dest/layui.all.js"></script>
	<script>
		var layer = layui.layer;
		$().ready(function () {
			$("#name_form").ajaxForm();
			$("#pass_form").ajaxForm();
		});
		var loadIndex;
		var submitOptions = {
			beforeSubmit: function () {
				loadIndex = layer.load(2);
			},
			success: function (data) {
				layer.msg(data['msg'], {
					success: function () {
						if (data['status']) {
							location.href = "{{route('admin.logout')}}";
						}
					}
				});
			},
			error: function () {
				layer.msg('网络错误,请刷新重试 ! ', {
					success: function () {
						location.reload(true);
					}
				})
			},
			complete: function () {
				layer.close(loadIndex);
			}
		};
		$("#name_form").on('submit', function (e) {
			e.preventDefault();
			var newName = document.getElementById('admin_name').value;
			layer.alert('您确定把登录名改为【' + newName + '】吗？', {
				icon: 6,
				btn: ['确定更改', '取消'],
				yes: function (i) {
					layer.close(i);
					$("#name_form").ajaxSubmit(submitOptions);
				}
			})
		});
		$("#pass_form").on('submit', function (e) {
			e.preventDefault();
			$("#pass_form").ajaxSubmit(submitOptions);
		});
	</script>
@endsection