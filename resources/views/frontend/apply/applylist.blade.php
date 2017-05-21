@extends('layouts.app')
@section('title')
	预约情况
@endsection
@section('head')
	<style>
	</style>
@endsection
@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div class="alert alert-warning">
					<form action="{{route('frontend.query_table')}}" method="post" id="query_form">
						{{csrf_field()}}
						<div class="form-group form-inline">
							<label for="term_id">请选择学期</label>
							<select class="form-control" id="term_id" name="term_id">
								<option value>==学期==</option>
								@foreach($termList as $term)
									<option value="{{$term->id}}">{{$term->termName}}</option>
								@endforeach
							</select>
							<label for="weeknum">请选择周数</label>
							<select class="form-control" id="weeknum" name="weeknum">
								<option value>==周数==</option>
								@for($i=1;$i<=20;$i++)
									<option value="{{$i}}">第{{$i}}周</option>
								@endfor
							</select>
							<a href="javascript:void(0)" class="btn btn-warning" onclick="query_table()"><i class="glyphicon glyphicon-search"></i> 查询</a>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12" id="content_area">
				<p style="text-align: center;margin-bottom: 5px;">状态：
					<span style="color:white;background: grey;border-radius: 3px;">未审核</span>
					<span style="color:white;background: green;border-radius: 3px;">通过</span>
					<span style="color:white;background: red;border-radius: 3px;">未通过</span>
				</p>
				<div class="well" id="table_area">
					请输入查询条件
				</div>
			</div>
		</div>
	</div>
@endsection
@section('foot')
	<script src="/assets/jqueryForm/jquery.form.min.js"></script>
	<script>
		$().ready(function () {
			$('#query_form').ajaxForm();
		});
		layui.use(['layer'], function () {
			var layer = layui.layer;
		});
		function query_table() {
			$('#query_form').ajaxSubmit({
				beforeSubmit: function () {
					layer.load();
				}
				, complete  : function () {
					layer.closeAll('loading');
				}
				, success   : function (data) {
					if (data['status']) {
						document.getElementById("table_area").innerHTML = data['data'];
					} else {
						layer.msg(data['msg'], {
							icon: 5
						});
					}
				}
				, error     : function () {
					layer.msg('网络错误,请刷新或稍后重试！', {
						icon: 2
					})
				}
			})
		}
	</script>
@endsection
