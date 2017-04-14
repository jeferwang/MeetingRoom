<!doctype html>
<html lang="zh_CN">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title></title>
	<style>
		.title {
			text-align: center;
		}
		.info{
			text-align: center;
			color: #aaa;
			font-size: 12px;
		}
	</style>
</head>
<body>
<h1 class="title">{{$notice->title}}</h1>
<p class="info">创建日期：{{$notice->created_at}}&emsp;&emsp;更新日期：{{$notice->updated_at}}</p>
<hr />
<div id="content">
	{!! $notice->content !!}
</div>
</body>
</html>