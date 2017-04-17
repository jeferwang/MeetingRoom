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
						icon: ico
					});
				}
				, error     : function () {
					layer.alert('网络错误,请刷新重试', {
						icon: 2
					});
				}
			});
		});
	</script>
@endsection