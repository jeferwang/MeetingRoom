$().ready(function () {
	$('#infoForm').ajaxForm();
	$.ajax({
		url       : querytable
		, type    : 'get'
		, cache   : false
		, dataType: 'json'
		, success : function (dat) {
			document.getElementById("show_table").innerHTML = dat['data'];
		}
		, error   : function () {
			document.getElementById("show_table").innerText = '网络服务器错误,加载失败';
		}
	});
});
//注意：导航 依赖 element 模块，否则无法进行功能性操作
layui.use(['layer', 'element', 'form'], function () {
	var layer   = layui.layer;
	var element = layui.element();
	var layForm = layui.form();
});
/**
 * 弹窗显示公告
 * @param $nid 公告ID
 * @param ele 包含标题信息的元素
 */
function showNotice($nid, ele) {
	//多窗口模式，层叠置顶
	layer.open({
		type     : 2 // iFrame
		, title  : $(ele).find('span:first').text()
		, area   : ['800px', '600px']
		, shade  : 0
		, maxmin : true
		, content: showNoticeUrl + $nid
		, btn    : ['关闭']
	});
}
/**
 * 查看详细的会议室列表
 */
function showMeetingroomList() {
	var content = "";
	for (var i = 0; i < roomList.length; i++) {
		content += "<tr><td>" + roomList[i]['name'] + "</td><td>" + roomList[i]['address'] + "</td><td>" + roomList[i]['description'] + "</td></tr>"
	}
	var htmlFrame = "<table class='table table-bordered table-responsive table-striped table-hover'>" + "<tr><th>会议室名称</th><th>地点</th><th>备注</th></tr>" + content + "</table>";
	layer.open({
		type     : 1
		, title  : '会议室详情'
		, area   : ['800px', '600px']
		, shade  : 0
		, maxmin : true
		, content: htmlFrame
		, btn    : ['关闭']
	});
}
/**
 * 弹窗确认提交信息
 */
function confirmInfo() {
	layer.alert('确认提交申请吗？', {
		icon : 6
		, btn: ['提交申请', '取消']
		, yes: function () {
			$('#infoForm').ajaxSubmit({
				beforeSubmit: function () {
					layer.load();
				}
				, success   : function (data) {
					var ico = data['status'] ? 6 : 5;
					layer.alert(data['msg'], {
						closeBtn: false
						, icon  : ico
						, btn   : ['确定']
						, yes   : function () {
							window.location.reload(true);
						}
					});
				}
				, error     : function () {
					layer.alert('网络错误,请刷新重试', {
						icon: 2
					});
				}
				, complete  : function () {
					layer.closeAll('loading');
				}
			});
		}
	});
}