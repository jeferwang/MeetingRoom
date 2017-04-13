@extends('layouts.app')
@section('title')
	预约情况
@endsection
@section('content')
	<div class="container">
		<div class="row">
			<table class="table table-responsive table-striped table-hover">
				<thead>
				<tr>
					<th>会议室</th>
					<th>开始时间</th>
					<th>结束时间</th>
					<th>申请时间</th>
					<th>申请人</th>
					<th>会议标题</th>
					<th>是否通过</th>
				</tr>
				</thead>
				<tbody>
				@foreach($applies as $k=>$apply)
					<tr>
						<td>{{$apply->room->name}}</td>
						<td>{{date('Y-m-d H:i:s',$apply->start_time)}}</td>
						<td>{{date('Y-m-d H:i:s',$apply->end_time)}}</td>
						<td>{{$apply->created_at}}</td>
						<td>{{$apply->people_name}}</td>
						<td>{{$apply->meeting_title}}</td>
						<td>
							@if($apply->pass==0)
								<span class="badge" style="background: #F7B824">等待审核</span>
							@elseif($apply->pass==1)
								<span class="badge" style="background: #01AAED;">审核通过</span>
							@elseif($apply->pass==2)
								<span onclick="showReason(this)" class="badge" style="background: #FF5722" title="{{$apply->reason}}">
							审核未通过 <i class="glyphicon glyphicon-question-sign"></i>
						</span>
							@else
								<span class="badge" style="background: #999">数据异常</span>
							@endif
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>
@endsection
@section('foot')
	<script>
		window.onload = function () {
			$("#nav_apply_list").addClass('active');
		};
		layui.use(['layer'], function () {
			var layer = layui.layer;
		});
		function showReason(ele) {
			layer.tips(ele.title, ele);
		}
	</script>
@endsection