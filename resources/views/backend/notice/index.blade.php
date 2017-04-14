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
					<button class="btn btn-warning btn-xs" onclick="updateN({{$notice->id}})">修改</button>
					<button class="btn btn-danger btn-xs" onclick="delN('{{$notice->id}}',this)">删除</button>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
@endsection
@section('foot')
	<script>
		// 加载Layer模块
		layui.use(['layer'], function () {
			var layer = layui.layer;
		});
		// Blade生成JS使用的URL
		var updateUr = "{{route('admin.notice.update')}}";
		var delUrl   = "{{route('admin.notice.del')}}";
		/*
		 * 修改一篇公告
		 * $nid Notice ID
		 */
		function updateN($nid, ele) {
		}
		/*
		 * 删除一篇公告
		 * $nid Notice ID
		 * ele 按钮元素
		 */
		function delN($nid, ele) {
			var nTitle = $(ele).parent('td').parent('tr').find('td:first').text();
			layer.alert('确实要删除公告【' + nTitle + '】吗？', {
				icon : 2
				, btn: ['删除', '取消']
				, yes: function () {
					$.ajax({
						url         : delUrl
						, method    : 'POST'
						, data      : {_token: Laravel.csrfToken, nid: $nid}
						, beforeSend: function () {
							layer.load(2)
						}
						, complete  : function () {
							layer.closeAll('loading')
						}
						, error     : function () {
							layer.alert('网络或服务器错误,请刷新重试', {icon: 2})
						}
						, success   : function (data) {
							if (data.status) {
								layer.msg(data.msg, {
									icon: 6
								});
								$(ele).parent('td').parent('tr').hide(500);
							} else {
								layer.alert(data.msg, {
									icon      : 2
									, closeBtn: 0
									, btn     : ['刷新']
									, yes     : location.reload(true)
								});
							}
						}
					});
				}
			});
		}
	</script>
@endsection