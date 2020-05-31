<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>微商城后台-管理员</title>
	<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
	<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<meta name="csrf-token" content="{{csrf_token()}}">
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
				<li><a href="{{url('/cate')}}">商品分类</a></li>
				<li><a href="{{url('/goods')}}">商品管理</a></li>
				<li  class="active"><a href="{{url('/admin')}}">管理员管理</a></li>
			</ul>
		</div>
		</div>
	</nav>
<center>
	<h2>管理员管理 
		<span style="float:right"><a class="btn btn-info" href="{{'/admin'}}">展示</a></span>
	</h2>
</center><hr/>
<!-- @if ($errors->any()) 
	<div class="alert alert-danger"> 
		<ul>@foreach ($errors->all() as $error) 
			<li>{{ $error }}</li> 
			@endforeach
		</ul> 
	</div> 
@endif -->
<form class="form-horizontal" role="form" method="post" action="{{url('/admin/store')}}" enctype="multipart/form-data">
	@csrf
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">管理员名称</label>
		<div class="col-sm-10">
			<input type="text" name="admin_name" class="form-control" id="firstname" 
				   placeholder="请输入管理员名称">
			<b style="color:red">{{$errors->first('admin_name')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">密码</label>
		<div class="col-sm-10">
			<input type="password" name="admin_pwd" class="form-control" id="firstname" 
				   placeholder="请输入密码">
			<b style="color:red">{{$errors->first('admin_pwd')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">确认密码</label>
		<div class="col-sm-10">
			<input type="password" name="admin_pwd1" class="form-control" id="firstname" 
				   placeholder="请再次输入密码">
			<b style="color:red">{{$errors->first('admin_pwd1')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">管理员头像</label>
		<div class="col-sm-2">
			<input type="file" name="admin_img" class="form-control" id="lastname" >
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">管理员电话</label>
		<div class="col-sm-10">
			<input type="text" name="admin_tel" class="form-control" id="lastname" 
				   placeholder="请输入管理员电话">
			<b style="color:red">{{$errors->first('admin_tel')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">管理员邮箱</label>
		<div class="col-sm-10">
			<input type="text" name="admin_email" class="form-control" id="lastname" 
				   placeholder="请输入管理员邮箱">
			<b style="color:red">{{$errors->first('admin_email')}}</b>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-primary">提交</button>
		</div>
	</div>
</form>
// <script>
// 	$('input[name="admin_name"]').blur(function(){
// 		$(this).next().empty();
// 		var admin_name = $(this).val();
// 		var reg = /^[\u4e00-\u9fa5\w]{2,50}$/;
// 		if(!admin_name){
// 			$(this).next().text('管理员名称不能为空');
// 			return;
// 		}else if(!reg.test(admin_name)){
// 			$(this).next().text('管理员名称格式不正确');
// 			return;
// 		}
// 		$.ajaxSetup({ 
// 			headers:{ 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') } 
// 		});
// 		//验证唯一
// 		$.post('/admin/checkName',{admin_name:admin_name},function(res){
// 			//alert(res)
// 			if(res>0){
// 				$('input[name="admin_name"]').next().text('管理员名称已存在');
// 			}
// 		})

// 	})
// </script>
</body>
</html>