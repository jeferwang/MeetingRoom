//注意：导航 依赖 element 模块，否则无法进行功能性操作
layui.use(['layer', 'element'], function () {
	var layer   = layui.layer;
	var element = layui.element();
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
			, beforeSend: function () {
				layer.load(2);
			}
			, success: function (data) {
				if (data.status) {
					layer.msg(data.msg);
					VueTabBlock.rooms = data.data;
				} else {
					$("#tab_1").click();
					layer.alert(data.msg, {
						icon: 5
					});
				}
			}
			, error: function () {
				layer.alert('网络错误,请刷新重试', {
					icon: 2
				});
			}
			, complete: function () {
				layer.closeAll('loading');
			}
		});
	});
});
var VueTabBlock = new Vue({
	el: '#tab_block'
	, data: {
		rooms: []
	}
});
$().ready(function () {
	$("#main_form").ajaxForm();
});
$("#main_form").on('submit', function (e) {
	e.preventDefault();
	$("#main_form").ajaxSubmit({
		beforeSubmit: function () {
			layer.load(2);
		}
		, success: function (data) {
			if (data.status) {
				layer.alert(data.msg, {
					icon: 6
					,closeBtn:0
					,btn:['确定']
					,yes: function (i) {
						layer.close(i);
						location.href='/';
					}
				});
			} else {
				layer.alert(data.msg, {
					icon: 5
				});
			}
		}
		, error: function () {
			layer.alert('网络错误,请刷新重试', {
				icon: 2
			});
		}
		, complete: function () {
			layer.closeAll('loading');
		}
	});
});