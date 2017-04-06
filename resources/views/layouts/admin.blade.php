<?php
use Illuminate\Support\Facades\Cookie;
$admin_name = Cookie::get('admin_login')['admin_name'];
?>
	<!DOCTYPE html>
<html lang="en">

<head>
	
	<!-- Basic -->
	<meta charset="UTF-8"/>
	
	<title>@yield('title')</title>
	
	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	
	<!-- Import google fonts -->
{{--<link href="http://fonts.useso.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css" />--}}

<!-- Favicon and touch icons -->
	<link rel="shortcut icon" href="/assets/ico/favicon.ico" type="image/x-icon"/>
	<link rel="apple-touch-icon" href="/assets/ico/apple-touch-icon.png"/>
	<link rel="apple-touch-icon" sizes="57x57" href="/assets/ico/apple-touch-icon-57x57.png"/>
	<link rel="apple-touch-icon" sizes="72x72" href="/assets/ico/apple-touch-icon-72x72.png"/>
	<link rel="apple-touch-icon" sizes="76x76" href="/assets/ico/apple-touch-icon-76x76.png"/>
	<link rel="apple-touch-icon" sizes="114x114" href="/assets/ico/apple-touch-icon-114x114.png"/>
	<link rel="apple-touch-icon" sizes="120x120" href="/assets/ico/apple-touch-icon-120x120.png"/>
	<link rel="apple-touch-icon" sizes="144x144" href="/assets/ico/apple-touch-icon-144x144.png"/>
	<link rel="apple-touch-icon" sizes="152x152" href="/assets/ico/apple-touch-icon-152x152.png"/>
	
	<!-- start: CSS file-->
	
	<!-- Vendor CSS-->
	<link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
	<link href="/assets/vendor/skycons/css/skycons.css" rel="stylesheet"/>
	<link href="/assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
	
	<!-- Theme CSS -->
	<link href="/assets/css/jquery.mmenu.css" rel="stylesheet"/>
	
	<!-- Page CSS -->
	<link href="/assets/css/style.css" rel="stylesheet"/>
	<link href="/assets/css/add-ons.min.css" rel="stylesheet"/>
	
	<!-- end: CSS file-->
	
	<!-- Head Libs -->
	<script src="/assets/plugins/modernizr/js/modernizr.js"></script>
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>

<body>

<!-- Start: Header -->
<div class="navbar" role="navigation">
	<div class="container-fluid container-nav">
		<!-- Navbar Action -->
		<ul class="nav navbar-nav navbar-actions navbar-left">
			<li class="visible-md visible-lg"><a href="javascript:void(0)" id="main-menu-toggle"><i class="fa fa-th-large"></i></a></li>
			<li class="visible-xs visible-sm"><a href="javascript:void(0)" id="sidebar-menu"><i class="fa fa-navicon"></i></a></li>
		</ul>
		<!-- Navbar Right -->
		<div class="navbar-right">
			<!-- Userbox -->
			<div class="userbox">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<div class="profile-info">
						<span class="name"><i class="glyphicon glyphicon-dashboard"></i> 附加选项</span>
					</div>
					<i class="fa custom-caret"></i>
				</a>
				<div class="dropdown-menu">
					<ul class="list-unstyled">
						<li class="dropdown-menu-header bk-bg-white bk-margin-top-15">
							<div class="progress progress-xs  progress-striped active">
								<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
									100%
								</div>
							</div>
						</li>
						<li>
							<a href="{{route('admin.logout')}}"><i class="glyphicon glyphicon-log-out"></i> 退出登录</a>
						</li>
					</ul>
				</div>
			</div>
			<!-- End Userbox -->
		</div>
		<!-- End Navbar Right -->
	</div>
</div>
<!-- End: Header -->
<div class="copyrights">Collect from <a href="http://www.cssmoban.com/">企业网站模板</a></div>
<!-- Start: Content -->
<div class="container-fluid content">
	<div class="row">
		
		<!-- Sidebar -->
		<div class="sidebar">
			<div class="sidebar-collapse">
				<!-- Sidebar Header Logo-->
				<div class="sidebar-header">
					<img src="/assets/img/logo.png" class="img-responsive" alt=""/>
				</div>
				<!-- Sidebar Menu-->
				<div class="sidebar-menu">
					<nav id="menu" class="nav-main" role="navigation">
						<ul class="nav nav-sidebar">
							<div class="panel-body text-center">
								<div class="bk-avatar">
									<img src="/assets/img/avatar.jpg" class="img-circle bk-img-60" alt=""/>
								</div>
								<div class="bk-padding-top-10">
									<i class="fa fa-circle text-success"></i>
									<small>{{$admin_name}}</small>
								</div>
							</div>
							<div class="divider2"></div>
							<li class="active">
								<a href="{{route('adminindex')}}">
									<i class="fa fa-laptop" aria-hidden="true"></i><span>首页</span>
								</a>
							</li>
							<li class="nav-parent">
								<a>
									<i class="fa fa-user" aria-hidden="true"></i><span>管理员设置</span>
								</a>
								<ul class="nav nav-children">
									<li><a href="icons-glyphicons.html"><span class="text"> 修改用户名&密码</span></a></li>
								</ul>
							</li>
						</ul>
					</nav>
				</div>
				<!-- End Sidebar Menu-->
			</div>
			<!-- Sidebar Footer-->
			<div class="sidebar-footer">
				<ul class="sidebar-terms">
					<li><a href="javascript:void(0)">Terms</a></li>
					<li><a href="javascript:void(0)">Privacy</a></li>
					<li><a href="javascript:void(0)">Help</a></li>
					<li><a href="javascript:void(0)">About</a></li>
				</ul>
				<div class="copyright text-center">
					<span>Copyright &copy; <?php $year = date('Y', time()); ?><?= ($year == 2017) ? '' : '2017-' ?><?= $year ?> <strong><a target="_blank" href="http://www.xsgzs.org/">Xingsi Studio.</a></strong></span>
					<span>All rights reserved.</span>
				</div>
			</div>
			<!-- End Sidebar Footer-->
		</div>
		<!-- End Sidebar -->
		
		<!-- Main Page -->
		<div class="main ">
			<!-- Page Header -->
			<div class="page-header">
				<div class="pull-left">
					<ol class="breadcrumb visible-sm visible-md visible-lg">
						<li><a href="index.html"><i class="icon fa fa-home"></i>后台首页</a></li>
						@yield('breadcrumbs')
					</ol>
				</div>
				<div class="pull-right">
					<h2>Dashboard</h2>
				</div>
			</div>
			<!-- End Page Header -->
			@yield('content')
		</div>
		<!-- End Main Page -->
	</div>
</div><!--/container-->

<!-- Modal Dialog -->
<div class="modal fade" id="myModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title bk-fg-primary">Modal title</h4>
			</div>
			<div class="modal-body">
				<p class="bk-fg-danger">Here settings can be configured...</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div><!-- End Modal Dialog -->

<div class="clearfix"></div>

<!-- start: JavaScript-->

<!-- Vendor JS-->
<script src="/assets/vendor/js/jquery.min.js"></script>
<script src="/assets/vendor/js/jquery-2.1.1.min.js"></script>
<script src="/assets/vendor/js/jquery-migrate-1.2.1.min.js"></script>
<script src="/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="/assets/vendor/skycons/js/skycons.js"></script>

<!-- Theme JS -->
<script src="/assets/js/jquery.mmenu.min.js"></script>
<script src="/assets/js/core.min.js"></script>

<!-- end: JavaScript-->

</body>

</html>