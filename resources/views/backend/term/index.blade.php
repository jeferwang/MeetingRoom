@extends('layouts.admin')
@section('title')
	学期/周数管理
@endsection
@section('breadcrumbs')
	<li class="active">学期/周数管理</li>
@endsection
@section('head')
	<link rel="stylesheet" href="/assets/plugins/bootstrap-datepicker/css/datepicker3.css">
@endsection
@section('content')
	<div class="container-fluid">
		<!--添加表单-->
		<div class="row" id="addForm">
			<div class="panel panel-default">
				<div class="panel-heading" style="line-height: 30px;">
					添加学期
				</div>
				<form action="" method="post" class="panel-body" id="addForm">
					{{csrf_field()}}
					<div class="col-sm-3">
						<div class="input-group">
							<label class="input-group-addon" for="termName">学期名称</label>
							<input type="text" id="termName" name="termName" class="form-control">
						</div>
					</div>
					<div class="col-sm-3">
						<div class="input-group">
							<label class="input-group-addon" for="startTime">起始日期</label>
							<input type="text" id="startTime" name="startTime" class="form-control" data-date-format="yyyy-mm-dd">
						</div>
					</div>
					<div class="col-sm-3">
						<div class="input-group">
							<label class="input-group-addon" for="weekCount">总周数</label>
							<select id="weekCount" name="weekCount" class="form-control">
								@for($i=20;$i<=25;$i++)
									<option value="{{$i}}">{{$i}}周</option>
								@endfor
							</select>
						</div>
					</div>
					<div class="col-sm-3">
						<button type="submit" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-check"></i> 添加</button>
					</div>
				</form>
			</div>
		</div>
		<!--/添加表单-->
		<!--显示已添加-->
		<div class="row" id="showTerm">
			<table class="col-sm-12 table table-bordered table-responsive table-hover">
				<thead>
				<tr>
					<th>学期名称</th>
					<th>开始日期</th>
					<th>总周数</th>
					<th>是否默认</th>
					<th>操作</th>
				</tr>
				</thead>
				<tbody>
				@foreach($terms as $index =>$term)
					<tr class="well">
						<td>{{$term->termName}}</td>
						<td>{{date('Y-m-d',$term->startTime)}}</td>
						<td>{{$term->weekCount}}</td>
						<td class="is_defalut">
							@if($term->default)
								<span class="badge default_yes" style="background: green;">是</span>
							@endif
						</td>
						<td>
							<button class="btn btn-success btn-xs" onclick="setCurrent('{{$term->id}}',this)">设为默认</button>
							<button class="btn btn-danger btn-xs" onclick="delTerm('{{$term->id}}',this)">删除</button>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
		<!--/显示已添加-->
	</div>
@endsection
@section('foot')
	{{--plugins--}}
	<script src="/assets/jqueryForm/jquery.form.min.js"></script>
	<script src="/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	{{--/plugins--}}
	<script>
		layui.use(['layer'], function () {
			var layer = layui.layer;
		});
		$().ready(function () {
			//	日期时间选择器
			var time_input = $("#startTime");
			time_input.datepicker({
				weekStart     : 1,
				todayBtn      : 1,
				autoclose     : 1,
				todayHighlight: 1,
				startView     : 2,
				forceParse    : 0,
				showMeridian  : 1
			});
			$('#addForm').ajaxForm();
		});
		$('#addForm').on('submit', function (e) {
			e.preventDefault();
			$('#addForm').ajaxSubmit({
				method      : 'POST',
				beforeSubmit: function () {
					layer.load(2);
				}
				, complete  : function () {
					layer.closeAll('loading');
				}
				, success   : function (data) {
					var ico = data.status ? 6 : 5;
					layer.alert(data.msg, {
						icon      : ico
						, closeBtn: 0
						, btn     : ['确定']
						, yes     : function () {
							location.reload(true);
						}
					});
				}
				, error     : function () {
					layer.alert('网络错误,请刷新重试', {
						icon: 2
					});
				}
			});
		});
		function delTerm($tId, ele) {
			layer.alert('您确认删除这一条目吗？', {
				icon      : 5
				, btn     : ['删除', '取消']
				, closeBtn: 0
				, yes     : function () {
					$.ajax({
						method      : 'POST'
						, url       : "{{route('admin.term.del')}}"
						, data      : {_token: Laravel.csrfToken, tId: $tId}
						, beforeSend: function () {
							layer.load(2);
						}
						, success   : function (data) {
							var ico = data.status ? 6 : 5;
							layer.alert(data.msg, {
								icon: ico
							});
							if (data.status) {
								$(ele).parent('td').parent('tr').hide(500);
							}
						}
						, error     : function () {
							layer.alert('网络错误,请刷新重试!', {
								icon: 2
							});
						}
						, complete  : function () {
							layer.closeAll('loading');
						}
					});
				}
			})
		}
		function setCurrent($tId, ele) {
			var mark          = '<span class="badge default_yes" style="background: green;">是</span>';
			var setDefaultUrl = "{{route('admin.term.default')}}";
			$.ajax({
				url         : setDefaultUrl
				, method    : 'POST'
				, data      : {_token: Laravel.csrfToken, tId: $tId}
				, beforeSend: function () {
					layer.load(2);
				}
				, complete  : function () {
					layer.closeAll('loading');
				}
				, success   : function (data) {
					if (data.status) {
						layer.msg(data.msg, {
							icon: 6
						});
						$('.default_yes').remove();
						$(ele).parent('td').prev('td.is_defalut')[0].innerHTML = mark;
					} else {
						layer.alert(data.msg, {
							icon: 5
						});
					}
				}
				, error     : function () {
					layer.alert('网络或服务器错误!', {
						icon: 2
					});
				}
			})
		}
	</script>
@endsection