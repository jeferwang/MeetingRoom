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
	<div class="container-fluid">
		<div class="row" id="tab_block">
			{{--Start左侧栏--}}
			<div class="col-md-4">
				<div class="panel panel-primary">
					<div class="panel-heading">
						导航
					</div>
					<ul class="nav nav-pills nav-stacked">
						<li><a target="_blank" href="{{route('frontend.notice_list')}}">公告列表</a></li>
						<li><a target="_blank" href="{{route('frontend.apply_list')}}">预约情况</a></li>
						<li><a target="_blank" href="{{route('frontend.manage')}}">管理办法</a></li>
					</ul>
				</div>
				<div class="panel panel-primary">
					<div class="panel-heading">
						使用须知
					</div>
					<div class="panel-body">
						<pre style="border:none;background: none;font-size: 15px;">{{$tip}}</pre>
					</div>
				</div>
			</div>
			{{--End左侧栏--}}
			{{--Start右侧栏--}}
			<div class="col-md-8">
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
				<div class="well">
					<p style="text-align: center;margin-bottom: 5px;">状态：
						<span style="color:white;background: grey;border-radius: 3px;">未审核</span>
						<span style="color:white;background: green;border-radius: 3px;">通过</span>
						<span style="color:white;background: red;border-radius: 3px;">未通过</span>
					</p>
					<div id="show_table" style="max-height: 200px;overflow: hidden;overflow-y: auto;text-align: center;">
						<i class="layui-icon" style="font-size: 25px;">&#xe63d;</i>
					</div>
				</div>
				<form method="post" action="{{route('frontend.apply')}}" class="well" id="infoForm">
					{{csrf_field()}}
					{{--Start会议时间选择--}}
					<label>请选择会议时间</label>
					<div class="form-group form-inline">
						<select name="term_id" id="term_id" class="form-control">
							<option value>===请选择学期===</option>
							@foreach($termList as $term)
								<option value="{{$term->id}}">{{$term->termName}}</option>
							@endforeach
						</select>
						<select name="weeknum" id="weeknum" class="form-control">
							<option value>===请选择周数===</option>
							@for($i=1;$i<=20;$i++)
								<option value="{{$i}}">第{{$i}}周</option>
							@endfor
						</select>
						<select name="week" id="week" class="form-control">
							<option value>===请选择星期===</option>
							<?php $weekWord = [null, '一', '二', '三', '四', '五', '六', '日'] ?>
							@for($i=1;$i<=7;$i++)
								<option value="{{$i}}">星期{{$weekWord[$i]}}</option>
							@endfor
						</select>
						<select class="form-control" id="meeting_time" name="meeting_time" required>
							<option value>===请选择时间===</option>
							<optgroup label="上午">
								<option value="1">上午第一大节</option>
								<option value="2">上午第二大节</option>
							</optgroup>
							<optgroup label="下午">
								<option value="3">下午第一大节</option>
								<option value="4">下午第二大节</option>
							</optgroup>
							<optgroup label="晚上">
								<option value="5">晚上第一大节</option>
							</optgroup>
						</select>
					</div>
					{{--End会议时间选择--}}
					{{--Start会议地点选择--}}
					{{--overflow样式清除layui的radio产生的问题--}}
					<div class="form-group" style="overflow: hidden;">
						<label for="room_id">
							会议地点*&emsp;
							<a class="btn btn-xs btn-info" href="javascript:void(0)" onclick="showMeetingroomList()">查看会议室详情</a>
						</label>
						<select class="form-control" name="room_id" id="room_id" required>
							<option value>===请选择会议室===</option>
							@foreach($roomList as $key=>$room)
								<option value="{{$room->id}}">{{$room->name}}</option>
							@endforeach
						</select>
					</div>
					{{--End会议地点选择--}}
					{{--Start会议详情--}}
					<div class="form-group">
						<label for="meeting_title">会议标题*</label>
						<input type="text" class="form-control" name="meeting_title" id="meeting_title" required>
						<label for="meeting_description">会议概要</label>
						<textarea class="form-control" name="meeting_description" id="meeting_description" rows="3"></textarea>
					</div>
					{{--End会议详情--}}
					{{--Start申请人信息--}}
					<div class="form-group">
						<label for="people_name">申请人姓名*</label>
						<input type="text" class="form-control" name="people_name" id="people_name" required>
						<label for="people_tel">手机号*</label>
						<input type="text" class="form-control" name="people_tel" id="people_tel" required>
					</div>
					{{--End申请人信息--}}
					<div>
						<input type="button" class="btn btn-primary" value="提交申请" onclick="confirmInfo()">
					</div>
				</form>
			</div>
			{{--End右侧栏--}}
		</div>
	</div>
@endsection
@section('foot')
	{{--plugins--}}
	<script src="/assets/jqueryForm/jquery.form.min.js"></script>
	{{--/plugins--}}
	<script>
		var showNoticeUrl      = '{{route('frontend.show_notice')}}?nid=';
		var successRedirectUrl = "{{route('frontend.apply_list')}}";
		var querytable         = "{{route('frontend.query_table')}}";
		var roomList           = {!! json_encode($roomList) !!};
	</script>
	<script src="/assets/js/frontend/index.js"></script>
@endsection



