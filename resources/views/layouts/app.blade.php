<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>@yield('title')</title>
	<link rel="stylesheet" href="/assets/vendor/bootstrap/css/bootstrap-bootswatch.min.css">
	<link rel="stylesheet" href="/assets/layui/css/layui.css">
	<style>
		body, div, p, h1, h2, h3, h4, h5, h6 {
			font-family: 微软雅黑, serif;
		}
	</style>
	@yield('head')
	<script>
		window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
	</script>
</head>
<body>
{{--导航--}}
<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<a class="navbar-brand" href="/">HPU会议室预约系统</a>
		{{--<div class="navbar-header">--}}
		{{--<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#example-navbar-collapse">--}}
		{{--<span class="sr-only">切换导航</span>--}}
		{{--<span class="icon-bar"></span>--}}
		{{--<span class="icon-bar"></span>--}}
		{{--<span class="icon-bar"></span>--}}
		{{--</button>--}}
		{{--</div>--}}
		{{--<div class="collapse navbar-collapse" id="example-navbar-collapse">--}}
		{{--<ul class="nav navbar-nav navbar-right">--}}
		{{--<li id="nav_index"><a href="{{route('frontend.index')}}">首页</a></li>--}}
		{{--<li id="nav_notice_list"><a href="{{route('frontend.notice_list')}}">公告列表</a></li>--}}
		{{--<li id="nav_apply_list"><a href="{{route('frontend.apply_list')}}">预约情况</a></li>--}}
		{{--<li id="nav_manage"><a href="{{route('frontend.manage')}}" target="_blank">管理办法</a></li>--}}
		{{--<!----}}
		{{--<li class="dropdown">--}}
		{{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
		{{--其他问题 <b class="caret"></b>--}}
		{{--</a>--}}
		{{--<ul class="dropdown-menu">--}}
		{{--<li><a href="#">预约条款</a></li>--}}
		{{--<li class="divider"></li>--}}
		{{--<li><a href="#">其他链接</a></li>--}}
		{{--</ul>--}}
		{{--</li>--}}
		{{---->--}}
		{{--</ul>--}}
		{{--</div>--}}
	</div>
</nav>
{{--/导航--}}
@yield('content')
</body>
<script src="/assets/vendor/js/jquery-2.1.1.min.js"></script>
<script src="/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="/assets/layui/layui.js"></script>
@yield('foot')
</html>