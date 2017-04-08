@extends('layouts.app')
@section('title')
	首页
@endsection
@section('head')
	<link rel="stylesheet" href="/assets/css/index.css">
	{{--plugins--}}
	<link rel="stylesheet" href="/assets/datetimepicker/bootstrap-datetimepicker.css">
	{{--/plugins--}}
@endsection
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				{{--进度条--}}
				<div class="progress progress-striped active">
					<div class="progress-bar progress-bar-danger" role="progressbar"
					     aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"
					     style="width: 25%;">
						<span class="sr-only">25% 完成（警告）</span>
					</div>
					<div class="progress-bar progress-bar-warning" role="progressbar"
					     aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"
					     style="width: 25%;">
						<span class="sr-only">50% 完成（信息）</span>
					</div>
					<div class="progress-bar progress-bar-info" role="progressbar"
					     aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
					     style="width: 25%;">
						<span class="sr-only">75% 完成</span>
					</div>
					<div class="progress-bar progress-bar-success" role="progressbar"
					     aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
					     style="width: 25%;">
						<span class="sr-only">100% 完成</span>
					</div>
				</div>
				{{--/进度条--}}
			</div>
		</div>
		<div class="row" id="tab_block">
			<div class="col-sm-10 col-sm-offset-1">
				<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
					<ul class="layui-tab-title">
						<li id="tab_1" class="layui-this">选择时间</li>
						<li id="tab_2">会议地点</li>
						<li id="tab_3">预约信息</li>
						<li id="tab_4">会议概要</li>
					</ul>
					{{--第一项内容--}}
					<div class="layui-tab-content" id="content_1">
						<div class="layui-tab-item layui-show panel panel-default">
							<p id="description_1" class="panel-heading">请选择会议的开始时间和结束时间</p>
							<div class="row panel-body time_block">
								<div class="col-md-6">
									<div class="form-group">
										<label for="start_time" class="control-label">开始时间</label>
										<div class="input-group">
											<i class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></i>
											<input type="text" class="form-control" id="start_time"
											       data-date-format="yyyy-mm-dd hh:ii:00" readonly>
											<span class="input-group-addon">S</span>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="end_time" class="control-label">结束时间</label>
										<div class="input-group">
											<i class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></i>
											<input type="text" class="form-control" id="end_time"
											       data-date-format="yyyy-mm-dd hh:ii:00" readonly>
											<span class="input-group-addon">E</span>
										</div>
									</div>
								</div>
							</div>
							<div class="row foot_btn">
								<div class="col-sm-2 col-sm-push-10 next_block">
									<button class="btn btn-success" id="next_1">
										下一步 <i class="glyphicon glyphicon-chevron-right"></i>
									</button>
								</div>
							</div>
						</div>
						{{--第二项内容--}}
						<div class="layui-tab-item" id="content_2">
							<div class="layui-tab-item layui-show panel panel-default">
								<p id="description_1" class="panel-heading">
									请您选择需要预约的会议室(灰色为当前时间段已被 <i>预约成功</i> 的)
								</p>
								<div class="row panel-body time_block">
									<ul class="list-group">
										<li class="list-group-item" v-for="room in rooms">@{{room.name}}</li>
									</ul>
								</div>
								<div class="row foot_btn">
									<div class="col-sm-2 preview_block">
										<button class="btn btn-info" id="preview_2">
											<i class="glyphicon glyphicon-chevron-left"></i> 上一步
										</button>
									</div>
									<div class="col-sm-2 col-sm-push-8 next_block">
										<button class="btn btn-success" id="next_2">
											下一步 <i class="glyphicon glyphicon-chevron-right"></i>
										</button>
									</div>
								</div>
							</div>
						</div>
						{{--第三项内容--}}
						<div class="layui-tab-item" id="content_3">
							<div class="layui-tab-item layui-show panel panel-default">
								<p id="description_1" class="panel-heading">
									请输入预约者的基本信息
								</p>
								<div class="row panel-body time_block">
									<div class="form-group">
										<label for="people_name" class="control-label">预约者姓名</label>
										<div class="input-group">
											<i class="input-group-addon"><i class="glyphicon glyphicon-user"></i></i>
											<input type="text" id="people_name" class="form-control">
										</div>
									</div>
									<div class="form-group">
										<label for="people_tel" class="control-label">联系方式</label>
										<div class="input-group">
											<i class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></i>
											<input type="text" id="people_tel" class="form-control">
										</div>
									</div>
								</div>
								<div class="row foot_btn">
									<div class="col-sm-2 preview_block">
										<button class="btn btn-info" id="preview_3">
											<i class="glyphicon glyphicon-chevron-left"></i> 上一步
										</button>
									</div>
									<div class="col-sm-2 col-sm-push-8 next_block">
										<button class="btn btn-success" id="next_3">
											下一步 <i class="glyphicon glyphicon-chevron-right"></i>
										</button>
									</div>
								</div>
							</div>
						</div>
						{{--第四项内容--}}
						<div class="layui-tab-item" id="content_4">
							<div class="layui-tab-item layui-show panel panel-default">
								<p id="description_1" class="panel-heading">
									请填写会议标题和概要(概要可不填)
								</p>
								<div class="row panel-body time_block">
									<div class="form-group">
										<label for="meeting_title" class="control-label">会议标题</label>
										<div class="input-group">
											<i class="input-group-addon"><i class="glyphicon glyphicon-star"></i></i>
											<input type="text" id="meeting_title" class="form-control">
										</div>
									</div>
									<div class="form-group">
										<label for="meeting_description" class="control-label">会议概要</label>
										<div class="input-group">
											<i class="input-group-addon"><i class="glyphicon glyphicon-list-alt"></i></i>
											<textarea id="meeting_description" rows="3" class="form-control"></textarea>
										</div>
									</div>
								</div>
								<div class="row foot_btn">
									<div class="col-sm-2 preview_block">
										<button class="btn btn-info" id="preview_4">
											<i class="glyphicon glyphicon-chevron-left"></i> 上一步
										</button>
									</div>
									<div class="col-sm-2 col-sm-push-8 next_block">
										<button class="btn btn-success" id="finish">
											<i class="glyphicon glyphicon-send"></i> 完成
										</button>
									</div>
								</div>
							</div>
						</div>
						{{--内容结束--}}
					</div>
					{{--内容主体结束--}}
				</div>
				{{--标签页结束--}}
			</div>
		</div>
	</div>
@endsection
@section('foot')
	{{--plugins--}}
	<script src="/assets/vue/vue.js"></script>
	<script src="/assets/datetimepicker/bootstrap-datetimepicker.js"></script>
	<script src="/assets/datetimepicker/bootstrap-datetimepicker.zh-CN.js"></script>
	{{--/plugins--}}
	<script>
		//注意：导航 依赖 element 模块，否则无法进行功能性操作
		layui.use(['layer', 'element'], function () {
			var layer   = layui.layer;
			var element = layui.element();
			element.on('tab(docDemoTabBrief)', function (data) {
			});
		});
		$().ready(function () {
			//	日期时间选择器
			var time_input = $("#start_time , #end_time");
			time_input.datetimepicker({
				language: 'zh-CN',
				weekStart: 1,
				todayBtn: 1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 2,
				forceParse: 0,
				showMeridian: 1
			});
			// 前后跳转逻辑
			$("#next_1").click(function () {
				$("#tab_2").click();
			});
			$("#next_2").click(function () {
				$("#tab_3").click();
			});
			$("#next_3").click(function () {
				$("#tab_4").click();
			});
			$("#preview_2").click(function () {
				$("#tab_1").click();
			});
			$("#preview_3").click(function () {
				$("#tab_2").click();
			});
			$("#preview_4").click(function () {
				$("#tab_3").click();
			});
			$("#tab_2").click(function () {
				var start_time = document.getElementById('start_time').value;
				var end_time   = document.getElementById('end_time').value;
				$.ajax({
					type: 'POST'
					, url: roomsUrl
					, data: {
						start_time: start_time
						, end_time: end_time
						, _token: Laravel.csrfToken
					}
					,beforeSend: function () {
						layer.load(2);
					}
					, success: function (data) {
						if (data.status) {
							layer.msg(data.msg);
							VueTabBlock.rooms = data.data;
						}else{
							$("#tab_1").click();
							layer.alert(data.msg,{
								icon:5
							});
						}
					}
					, error: function () {
						layer.alert('网络错误,请刷新重试',{
							icon:2
						});
					}
					,complete: function () {
						layer.closeAll('loading');
					}
				});
			});
		});
		var roomsUrl    = "{{route('frontend.json.rooms')}}";
		var VueTabBlock = new Vue({
			el: '#tab_block'
			, data: {
				rooms: []
			}
		});
	</script>
@endsection