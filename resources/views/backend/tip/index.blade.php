@extends('layouts.admin')
@section('title')
	使用须知修改
@endsection
@section('breadcrumbs')
	<li>使用须知修改</li>
@endsection
@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<form action="" method="post" id="tipForm">
					{{csrf_field()}}
					<div class="from-group">
						<label for="content" class="control-label">请填写提示内容</label>
						<textarea rows="10" class="form-control" name="content" id="content"></textarea>
						<br>
						<a href="javascript:void(0)" class="btn btn-success" onclick="submitTip()">更新/修改</a>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
@section('foot')
	<script>
		$().ready(function () {
			$('#tipForm').ajaxForm();
		});
		function submitTip() {
			$('#tipForm').ajaxSubmit({
				beforeSubmit: function () {
					layer.load();
				}
				, complete  : function () {
					layer.closeAll('loading');
				}
				, success   : function (data) {
					var ico = data['status'] ? 6 : 5;
					layer.msg(data['msg'], {
						icon: ico
					});
				}
				, error     : function () {
					layer.alert('网络或服务器错误,请刷新重试',{
						icon:2
					});
				}
			});
		}
	</script>
@endsection