<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>微商城后台-商品分类</title>
	<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
	<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<nav class="navbar navbar-default" role="navigation">
		<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="#">微商城</a>
		</div>
		<div>
			<ul class="nav navbar-nav">
				<li><a href="{{url('/brand')}}">商品品牌</a></li>
				<li class="active"><a href="{{url('/cate')}}">商品分类</a></li>
				<li><a href="{{url('/goods')}}">商品管理</a></li>
				<li><a href="{{url('/admin')}}">管理员管理</a></li>
				<li><a>欢迎【<font color=red>{{session('admin')->admin_name}}</font>】登录</a></li>
				<li><a href="{{url('/quit')}}">退出</a></li>
			</ul>
		</div>
		</div>
	</nav>
<center>
	<h2>商品分类
		<span style="float:right"><a class="btn btn-info" href="{{'/cate/create'}}">添加</a></span>
	</h2><hr/>
</center>
<font color=red><b>{{session('msg')}}</b></font>
<table class="table">
	<thead>
		<tr>
			<th>分类id</th>
			<th>分类名称</th>
			<th>是否显示</th>
			<th>是否在导航显示</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($cate as $k => $v)
		<tr @if($k%2==0) class="active" @alse class="danger"@endif>
			<td>{{$v->cate_id}}</td>
			<td>{{str_repeat('|——',$v->level)}}{{$v->cate_name}}</td>
			<td>{{$v->is_show==1 ? '√':'×'}}</td>
			<td>@if($v->is_nav_show==1)√@endif @if($v->is_nav_show==2)×@endif</td>
			<td>
				<a class="btn btn-primary" href="{{url('/cate/edit/'.$v->cate_id)}}">编辑</a>
				<a class="btn btn-danger" href="{{url('/cate/destroy/'.$v->cate_id)}}">删除</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
</body>
</html>