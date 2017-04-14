@extends('layouts.app')
@section('title')
	公告列表
@endsection
@section('content')
	<div class="container">
		<div class="row">
			@foreach($nList as $key=>$item)
				<div class="col-sm-12">
					<div class="alert alert-{{$item->theme}}">
						<a href="javascript:void(0)" onclick="showNotice('{{$item->id}}',this)">{{$item->title}}</a>
						<span class="pull-right">{{$item->created_at}}</span>
					</div>
				</div>
			@endforeach
		</div>
	</div>
@endsection
@section('foot')
	<script>
		window.onload = function () {
			document.getElementById("nav_notice_list").setAttribute('class', 'active');
		};
		layui.use(['layer'], function () {
			var layer = layui.layer;
		});
		/*
		 弹窗显示公告
		 */
		function showNotice($nid, ele) {
			//多窗口模式，层叠置顶
			layer.open({
				type     : 2 // iFrame
				, title  : ele.innerText
				, area   : ['800px', '600px']
				, shade  : 0
				, maxmin : true
				, content: '{{route('frontend.show_notice')}}?nid=' + $nid
				, btn    : ['全部关闭']
				, yes    : function () {
					layer.closeAll();
				}
				, zIndex : layer.zIndex //重点1
				, success: function (layero) {
					layer.setTop(layero); //重点2
				}
			});
		}
	</script>
@endsection