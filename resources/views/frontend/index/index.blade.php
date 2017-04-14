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
		@if($noticeOne)
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-{{$noticeOne->theme}}" onclick="showNotice('{{$noticeOne->id}}',this)" style="cursor: pointer;">
						<span>{{$noticeOne->title}}</span>
						<span class="pull-right">{{$noticeOne->created_at}}</span>
					</div>
				</div>
			</div>
		@endif
		<div class="row" id="tab_block">
			<div class="col-sm-12">
				<form id="main_form" method="post" action="{{route('frontend.json.apply')}}"
				      class="layui-tab layui-tab-brief"
				      lay-filter="mainTab">
					{{csrf_field()}}
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
											<i class="input-group-addon"><i
													class="glyphicon glyphicon-calendar"></i></i>
											<input type="text" class="form-control" id="start_time" name="start_time"
											       data-date-format="yyyy-mm-dd hh:ii:00" readonly>
											<span class="input-group-addon">Start</span>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="end_time" class="control-label">结束时间</label>
										<div class="input-group">
											<i class="input-group-addon"><i
													class="glyphicon glyphicon-calendar"></i></i>
											<input type="text" class="form-control" id="end_time" name="end_time"
											       data-date-format="yyyy-mm-dd hh:ii:00" readonly>
											<span class="input-group-addon">End</span>
										</div>
									</div>
								</div>
							</div>
							<div class="row foot_btn">
								<div class="col-sm-2 col-sm-push-10 next_block">
									<a href="javascript:void(0)" class="btn btn-success" id="next_1">
										下一步 <i class="glyphicon glyphicon-chevron-right"></i>
									</a>
								</div>
							</div>
						</div>
						{{--第二项内容--}}
						<div class="layui-tab-item" id="content_2">
							<div class="layui-tab-item layui-show panel panel-default">
								<p id="description_1" class="panel-heading">
									请您选择需要预约的会议室
								</p>
								<div class="row panel-body time_block">
									<ul class="list-group">
										<li class="list-group-item" v-for="room in rooms">
											<label>
												<input type="radio" name="room_id" :value="room.id" v-if="room.usable">
												<input type="radio" name="room_id" :value="room.id" disabled
												       v-if="!room.usable">
												<span>@{{ room.name }}</span>
												<span v-if="!room.usable">(已被预约)</span>
											</label>
										</li>
									</ul>
								</div>
								<div class="row foot_btn">
									<div class="col-sm-2 preview_block">
										<a href="javascript:void(0)" class="btn btn-info" id="preview_2">
											<i class="glyphicon glyphicon-chevron-left"></i> 上一步
										</a>
									</div>
									<div class="col-sm-2 col-sm-push-8 next_block">
										<a href="javascript:void(0)" class="btn btn-success" id="next_2">
											下一步 <i class="glyphicon glyphicon-chevron-right"></i>
										</a>
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
											<input type="text" id="people_name" name="people_name" class="form-control">
										</div>
									</div>
									<div class="form-group">
										<label for="people_tel" class="control-label">联系方式</label>
										<div class="input-group">
											<i class="input-group-addon"><i
													class="glyphicon glyphicon-earphone"></i></i>
											<input type="text" id="people_tel" name="people_tel" class="form-control">
										</div>
									</div>
								</div>
								<div class="row foot_btn">
									<div class="col-sm-2 preview_block">
										<a href="javascript:void(0)" class="btn btn-info" id="preview_3">
											<i class="glyphicon glyphicon-chevron-left"></i> 上一步
										</a>
									</div>
									<div class="col-sm-2 col-sm-push-8 next_block">
										<a href="javascript:void(0)" class="btn btn-success" id="next_3">
											下一步 <i class="glyphicon glyphicon-chevron-right"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
						{{--第四项内容--}}
						<div class="layui-tab-item" id="content_4">
							<div class="layui-tab-item layui-show panel panel-default">
								<p id="description_1" class="panel-heading">
									请填写会议标题和概要
								</p>
								<div class="row panel-body time_block">
									<div class="form-group">
										<label for="meeting_title" class="control-label">会议标题</label>
										<div class="input-group">
											<i class="input-group-addon"><i class="glyphicon glyphicon-star"></i></i>
											<input type="text" id="meeting_title" name="meeting_title"
											       class="form-control">
										</div>
									</div>
									<div class="form-group">
										<label for="meeting_description" class="control-label">会议概要(可留空)</label>
										<div class="input-group">
											<i class="input-group-addon"><i
													class="glyphicon glyphicon-list-alt"></i></i>
											<textarea id="meeting_description" name="meeting_description" rows="3"
											          class="form-control"></textarea>
										</div>
									</div>
								</div>
								<div class="row foot_btn">
									<div class="col-sm-2 preview_block">
										<a href="javascript:void(0)" class="btn btn-info" id="preview_4">
											<i class="glyphicon glyphicon-chevron-left"></i> 上一步
										</a>
									</div>
									<div class="col-sm-2 col-sm-push-8 next_block">
										<button type="submit" class="btn btn-success" id="finish">
											<i class="glyphicon glyphicon-send"></i> 完成
										</button>
									</div>
								</div>
							</div>
						</div>
						{{--内容结束--}}
					</div>
					{{--内容主体结束--}}
				</form>
				{{--标签页结束--}}
			</div>
		</div>
	</div>
@endsection
@section('foot')
	{{--plugins--}}
	<script src="/assets/jqueryForm/jquery.form.min.js"></script>
	<script src="/assets/vue/vue.js"></script>
	<script src="/assets/datetimepicker/bootstrap-datetimepicker.js"></script>
	<script src="/assets/datetimepicker/bootstrap-datetimepicker.zh-CN.js"></script>
	{{--/plugins--}}
	<script>
		var roomsUrl      = "{{route('frontend.json.rooms')}}";
		var showNoticeUrl = '{{route('frontend.show_notice')}}?nid=';
	</script>
	<script src="/assets/js/frontend/index.js"></script>
@endsection