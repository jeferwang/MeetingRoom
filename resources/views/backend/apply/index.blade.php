@extends('layouts.admin')
@section('title')
	预约审核
@endsection
@section('breadcrumbs')
	<li class="active">预约审核</li>
@endsection
@section('content')
	<div class="row">
		<table class="table table-bordered table-responsive table-striped table-hover">
			<thead>
			<tr>
				<th>会议室</th>
				<th>开始时间</th>
				<th>结束时间</th>
				<th>预约者姓名</th>
				<th>联系方式</th>
				<th>会议标题</th>
				<th>会议概要</th>
				<th>当前状态</th>
				<th>审核操作</th>
			</tr>
			</thead>
			<tbody>
			@foreach($applies as $apply)
				<tr>
					<td>{{$apply->room->name}}</td>
					<td>{{date('Y-m-d H:i:s',$apply->start_time)}}</td>
					<td>{{date('Y-m-d H:i:s',$apply->end_time)}}</td>
					<td>{{$apply->people_name}}</td>
					<td>{{$apply->people_tel}}</td>
					<td>{{$apply->meeting_title}}</td>
					<td>{{$apply->meeting_description or '（无）'}}</td>
					<td>
						@if($apply->pass=='yes')
							<span class="badge badge-success">通过</span>
						@elseif($apply->pass=='no')
							<span class="badge badge-danger">未通过</span>
						@else
							<span class="badge badge-info">未审核</span>
						@endif
					</td>
					<td>
						@if($apply->pass==null)
							<button class="btn btn-xs btn-success" id="pass_yes" onclick="pass('{{$apply->id}}',true)">通过
							</button>
							<button class="btn btn-xs btn-danger" id="pass_no" onclick="pass('{{$apply->id}}',false)">未通过
							</button>
						@endif
					</td>
				</tr>
			@endforeach
			</tbody>
			<tr>
				<td colspan="9"
				    style="text-align: center;">{{((string)$applies->links()=="")? '没有更多内容了' : $applies->links()}}</td>
			</tr>
		</table>
	</div>
@endsection

@section('foot')
	<script>
		layui.use(['layer'], function () {
			var layer = layui.layer;
		});
		function pass($id, $pass) {
			var msg  = $pass ? '确定要【审核通过】吗？' : '确定要【审核不通过】吗？';
			var icon = $pass ? 6 : 5;
			layer.alert(msg, {
				icon: icon
				, btn: ['确定', '取消']
				, yes: function (i) {
					layer.close(i);
					// 发出Ajax
					if (!$pass) {
						layer.prompt({
							title:'请填写不通过的理由',
							formType: 2,
							maxlength: 255
						}, function (reason,index) {
							layer.close(index);
							ajaxPass($id, $pass,reason);
						});
					}else{
						ajaxPass($id, $pass,'');
					}
				}
			});
		}
		var passUrl = "{{route('admin.apply.pass')}}";
		function ajaxPass($apply_id, $pass,$reason) {
			$.ajax({
				type: 'POST'
				, url: passUrl
				, data: {'apply_id': $apply_id, 'is_pass': $pass, '_token': Laravel.csrfToken,'reason':$reason}
				, beforeSend: function () {
					layer.load(2);
				}
				, success: function (data) {
					var ico = data.status ? 6 : 5;
					layer.alert(data.msg, {
						icon: ico
						, closeBtn: 0
						, btn: ['确定']
						, yes: function (i) {
							layer.close(i);
							if (data.msg) {
								location.reload(true);
							}
						}
					});
				}
				, error: function () {
					layer.alert('网络错误,请刷新重试', {
						icon: 2
					});
				}
				, complete: function () {
					layer.closeAll('loading');
				}
			});
		}
	</script>
@endsection