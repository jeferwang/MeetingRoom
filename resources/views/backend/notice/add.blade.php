@extends('layouts.admin')
@section('title')
	添加公告
@endsection
@section('breadcrumbs')
	<li><a href="{{route('admin.notice.index')}}">公告列表</a></li>
	<li class="active">添加公告</li>
@endsection
@section('head')
	<script src="/assets/ueditor/ueditor.config.js"></script>
	<script src="/assets/ueditor/ueditor.all.js"></script>
	<script src="/assets/ueditor/lang/zh-cn/zh-cn.js"></script>
	<style>
	
	</style>
@endsection
@section('content')
	<div class="container-fluid">
		<div class="row">
			<form action="" method="post">
				<div class="form-group">
					<label for="title" class="control-label">公告标题</label>
					<input type="text" name="title" id="title" class="form-control" value="{{$notice->title or ''}}">
				</div>
				<div class="row layui-form">
					<div class="col-sm-4">
						<div class="alert alert-info">
							<input type="radio" name="theme" title="提示" value="info"
							       @if(!isset($notice) || $notice->theme=='info') checked @endif>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="alert alert-warning">
							<input type="radio" name="theme" title="警告" value="warning"
							       @if($notice->theme=='warning') checked @endif>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="alert alert-danger"><input type="radio" name="theme" title="危险" value="danger"
						                                       @if($notice->theme=='danger') checked @endif>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="control-label">内容</label>
					<script id="content" type="text/plain">{!! $notice->content or ''!!}</script>
				</div>
				<div class="form-group">
					@if($notice)
						<input type="button" class="btn btn-primary" value="更新公告" id="addNotice">
					@else
						<input type="button" class="btn btn-success" value="添加公告" id="addNotice">
					@endif
				</div>
			</form>
		</div>
	</div>
@endsection
@section('foot')
	<script>
		var ue = UE.getEditor('content');
		layui.use(['layer'], function () {
			var layer = layui.layer;
		});
		// 获取表单的数据
		function getData() {
			var title   = document.getElementById('title').value;
			var theme   = $('input[type=radio]:checked').val();
			var content = ue.getContent();
			return {title: title, theme: theme, content: content};
		}
		// 客户端js检查数据是否缺少
		function checkData(data) {
			if (!data.title || data.title === '') {
				return {status: false, msg: '标题不能为空'};
			} else if (!data.theme || data.theme === '') {
				return {status: false, msg: '主题颜色不能为空'};
			} else if (!data.content || data.content === '') {
				return {status: false, msg: '内容不能为空'};
			} else {
				return {status: true};
			}
		}
		// 执行提交并发出Ajax
		url = "{{isset($notice)?route('admin.notice.update'):route('admin.notice.add')}}";
		$('#addNotice').on('click', function (e) {
			e.target.disabled = true;
			var data          = getData();
			var check         = checkData(data);
			@if(isset($notice))
				data.nid      = "{{$notice->id}}";
			@endif
			if (!check.status) {
				layer.msg(check.msg, {
					icon: 5
				});
				e.target.disabled = false;
			} else {  // 数据验证成功
				data._token = Laravel.csrfToken;
				$.ajax({
					type        : 'POST'
					, url       : url
					, data      : data
					, beforeSend: function () {
						layer.load(2);
					}
					, success   : function (res) {
						if (res.status) {
							layer.alert(res.msg, {
								icon      : 6
								, closeBtn: 0
								, btn     : ['转到列表', '留在本页']
								, yes     : function () {
									location.href = "{{route('admin.notice.index')}}"
								}
							})
						} else {
							layer.alert(res.msg, {
								icon: 5
							});
						}
					}
					, error     : function () {
						layer.alert('网络错误或服务错误,请稍后重试', {
							icon: 2
						});
					}
					, complete  : function () {
						layer.closeAll('loading');
					}
				});
			}
			e.target.disabled = false;
		});
	</script>
@endsection