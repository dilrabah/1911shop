<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>微商城后台-文章</title>
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
				<li><a href="{{url('/cate')}}">商品分类</a></li>
				<li><a href="{{url('/goods')}}">商品管理</a></li>
				<li><a href="{{url('/admin')}}">管理员管理</a></li>
				<li class="active"><a href="{{url('/admin')}}">文章管理</a></li>
			</ul>
		</div>
		</div>
	</nav>
<center>
	<h2>文章 
		<span style="float:right"><a class="btn btn-default" href="{{'/article'}}">展示</a></span>
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
<form class="form-horizontal" role="form" method="post" action="{{url('/article/store')}}" enctype="multipart/form-data">
	@csrf
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">文章标题</label>
		<div class="col-sm-10">
			<input type="text" name="name" class="form-control" id="firstname" 
				   placeholder="请输入文章标题">
			<b style="color:red">{{$errors->first('name')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">文章分类</label>
		<div class="col-sm-2">
			<select class="form-control" name="t_id" id="firstname">
				<option value="">--请选择--</option>
				@foreach ($type as $v)
				<option value="{{$v->t_id}}">{{$v->t_name}}</option>
				@endforeach
			</select>
			<b style="color:red">{{$errors->first('t_id')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">文章重要性</label>
		<div class="col-sm-10">
			<input type="radio" name="is_zy" value="1">普通
			<input type="radio" name="is_zy" value="2">重要
		</div>
		<b style="color:red">{{$errors->first('is_zy')}}</b>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">是否显示</label>
		<div class="col-sm-10">
			<input type="radio" name="is_show" value="1">是
			<input type="radio" name="is_show" value="2">否
		</div>
		<b style="color:red">{{$errors->first('is_show')}}</b>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">文章作者</label>
		<div class="col-sm-10">
			<input type="text" name="man" class="form-control" id="firstname" 
				   placeholder="请输入文章作者">
			<b style="color:red">{{$errors->first('brand_name')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">作者email</label>
		<div class="col-sm-10">
			<input type="text" name="email" class="form-control" id="lastname" 
				   placeholder="请输入作者Email">
			<b style="color:red">{{$errors->first('brand_url')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">关键字</label>
		<div class="col-sm-10">
			<input type="text" name="keyn" class="form-control" id="lastname" 
				   placeholder="请输入关键字">
			<b style="color:red">{{$errors->first('brand_url')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">上传文件</label>
		<div class="col-sm-10">
			<input type="file" name="img" class="form-control" id="lastname" >
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">网页描述</label>
		<div class="col-sm-10">
			<textarea type="text" name="content" class="form-control" id="lastname"></textarea>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-default">提交</button>
			<button type="reset" class="btn btn-default">重置</button>
		</div>
	</div>
</form>

</body>
</html>