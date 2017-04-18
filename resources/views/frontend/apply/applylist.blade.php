@extends('layouts.app')
@section('title')
	预约情况
@endsection
@section('content')
	<div class="container">
		<div class="row">
			{{--<table class="table table-responsive table-striped table-hover">--}}
			{{--<thead>--}}
			{{--<tr>--}}
			{{--<th>会议室</th>--}}
			{{--<th>开始时间</th>--}}
			{{--<th>结束时间</th>--}}
			{{--<th>申请时间</th>--}}
			{{--<th>申请人</th>--}}
			{{--<th>会议标题</th>--}}
			{{--<th>是否通过</th>--}}
			{{--</tr>--}}
			{{--</thead>--}}
			{{--<tbody>--}}
			{{--@foreach($applies as $k=>$apply)--}}
			{{--<tr>--}}
			{{--<td>{{$apply->room->name}}</td>--}}
			{{--<td>{{date('Y-m-d H:i:s',$apply->start_time)}}</td>--}}
			{{--<td>{{date('Y-m-d H:i:s',$apply->end_time)}}</td>--}}
			{{--<td>{{$apply->created_at}}</td>--}}
			{{--<td>{{$apply->people_name}}</td>--}}
			{{--<td>{{$apply->meeting_title}}</td>--}}
			{{--<td>--}}
			{{--@if($apply->pass==0)--}}
			{{--<span class="badge" style="background: #F7B824">等待审核</span>--}}
			{{--@elseif($apply->pass==1)--}}
			{{--<span class="badge" style="background: #01AAED;">审核通过</span>--}}
			{{--@elseif($apply->pass==2)--}}
			{{--<span onclick="showReason(this)" class="badge" style="background: #FF5722" title="{{$apply->reason}}">--}}
			{{--审核未通过 <i class="glyphicon glyphicon-question-sign"></i>--}}
			{{--</span>--}}
			{{--@else--}}
			{{--<span class="badge" style="background: #999">数据异常</span>--}}
			{{--@endif--}}
			{{--</td>--}}
			{{--</tr>--}}
			{{--@endforeach--}}
			{{--</tbody>--}}
			{{--</table>--}}
			<div class="col-sm-12 well  form-inline">
				<select name="term" id="term" class="form-control">
					@if($terms->count()==0)
						<option value="">暂未设置学期</option>
					@else
						@foreach($terms as $term)
							<option value="{{$term->id}}">{{$term->termName}}</option>
						@endforeach
					@endif
				</select>
				<button class="btn btn-primary" id="query"><i class="glyphicon glyphicon-search"></i> 查询</button>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12" id="showList">
				<div>
					<ul id="myTab" class="nav nav-tabs">
						<li v-for="(li,key,index) in list" :class="{'active':!index}">
							<a :href="'#tab'+key" data-toggle="tab">
								@{{li.weekName}}
							</a>
						</li>
					</ul>
					
					<div id="myTabContent" class="tab-content">
						<div v-for="(li,key,index) in list" :class="['tab-pane','fade', 'in',{'active':!index}]" :id="'tab'+key">
							<table class="table table-bordered table-responsive table-striped table-hover">
								<thead>
								<tr>
									<th>会议室</th>
									<th>会议名称</th>
									<th>申请人</th>
									<th>申请时间</th>
									<th>开始时间</th>
									<th>结束时间</th>
									<th>是否通过</th>
								</tr>
								</thead>
								<tr v-if="li.applies.length==0">
									<td colspan="7" style="text-align: center;">无数据</td>
								</tr>
								<tr v-for="apply in li.applies">
									<td>@{{ apply.room_name }}</td>
									<td>@{{ apply.meeting_title }}</td>
									<td>@{{ apply.people_name }}</td>
									<td>@{{ apply.created_at }}</td>
									<td>@{{ apply.start_time }}</td>
									<td>@{{ apply.end_time }}</td>
									<td>
										<span v-if="apply.pass==0" class="badge" style="background: #F7B824">等待审核</span>
										<span v-if="apply.pass==1" class="badge" style="background: #01AAED;">审核通过</span>
										<span v-if="apply.pass==2" onclick="showReason(this)" class="badge" style="background: #FF5722" :title="apply.reason">
											<span>审核未通过</span>
											<span class="glyphicon glyphicon-question-sign"></span>
										</span>
									</td>
								</tr>
							</table>
						</div>
					</div>
					@if(!$applyList)
						<div class="alert alert-danger" style="text-align: center;">无数据</div>
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection
@section('foot')
	<script src="/assets/vendor/bootstrap/js/bootstrap-tabdrop.js"></script>
	<script>
		function createDropTab() {
			$('.nav-tabs').tabdrop({
				text: "更多"
			});
		}
		$('.nav-tabs').tabdrop({
			text: " <i class='glyphicon glyphicon-chevron-down'></i>"
		});
		window.onload = function () {
			$("#nav_apply_list").addClass('active');
		};
		layui.use(['layer', 'element'], function () {
			var layer   = layui.layer;
			var element = layui.element
		});
		function showReason(ele) {
			layer.tips(ele.title, ele);
		}
		var vList = new Vue({
			el    : "#showList"
			, data: {
				list: {!! json_encode($applyList['list']) !!}
			}
		});
		createDropTab();
		$('[href=#tab{{$currentWeek}}]').tab('show');
		vList.$watch('list', function () {
			createDropTab();
		});
		$('#query').on('click', function () {
			var $tId = $("#term").val();
			$.ajax({
				method      : 'POST'
				, url       : "{{route('frontend.json.get_apply_list')}}"
				, data      : {tId: $tId, _token: Laravel.csrfToken}
				, beforeSend: function () {
					layer.load(2);
				}
				, complete  : function () {
					layer.closeAll('loading');
				}
				, success   : function (data) {
					if (data.status) {
						vList.$data.list = data.list;
					} else {
						layer.alert(data.msg, {
							icon: 5
						});
					}
				}
				, error     : function () {
					layer.alert('网络或服务器错误,请刷新重试', {
						icon: 2
					});
				}
			});
		});
	</script>
@endsection
