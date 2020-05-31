<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>微商城后台-商品品牌</title>
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
				<li class="active"><a href="{{url('/brand')}}">商品品牌</a></li>
				<li><a href="{{url('/cate')}}">商品分类</a></li>
				<li><a href="{{url('/goods')}}">商品管理</a></li>
				<li><a href="{{url('/admin')}}">管理员管理</a></li>
			</ul>
		</div>
		</div>
	</nav>
<center>
	<h2>商品品牌 
		<span style="float:right"><a class="btn btn-default" href="{{'/brand'}}">展示</a></span>
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
<form class="form-horizontal" role="form" method="post" action="{{url('/brand/store')}}" enctype="multipart/form-data">
	@csrf
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">品牌名称</label>
		<div class="col-sm-10">
			<input type="text" name="brand_name" class="form-control" id="firstname" 
				   placeholder="请输入品牌名称">
			<b style="color:red">{{$errors->first('brand_name')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">品牌网址</label>
		<div class="col-sm-10">
			<input type="text" name="brand_url" class="form-control" id="lastname" 
				   placeholder="请输入品牌网址">
			<b style="color:red">{{$errors->first('brand_url')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">品牌LOGO</label>
		<div class="col-sm-10">
			<input type="file" name="brand_logo" class="form-control" id="lastname" >
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">品牌描述</label>
		<div class="col-sm-10">
			<textarea type="text" name="brand_desc" class="form-control" id="lastname"></textarea>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="button" class="btn btn-default">提交</button>
		</div>
	</div>
</form>
<script>
	//品牌失去焦点事件
	$('input[name="brand_name"]').blur(function(){
		$(this).next().empty();
		var brand_name = $(this).val();
		if(!brand_name){
			$(this).next().text('品牌名称不能为空');
			return;
		}

		$.ajaxSetup({ 
			headers:{ 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') } 
		});
		//验证唯一
		$.post('/brand/checkName',{brand_name:brand_name},function(res){
			//alert(123)
			if(res>0){
				$('input[name="brand_name"]').next().text('品牌名称已存在');
			}
		})
	})

	//品牌网址
	$('input[name="brand_url"]').blur(function(){
		$(this).next().empty();
		var brand_url = $(this).val();
		if(!brand_url){
			$(this).next().text('品牌网址不能为空');
		}
	})

	//表单提交点击
	$('button').click(function(){
		var brand_name = $('input[name="brand_name"]').val();
		if(!brand_name){
			$('input[name="brand_name"]').next().text('品牌名称不能为空');
			return;
		}
		$.ajaxSetup({ 
			headers:{ 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') } 
		});
		//验证唯一
		var flag = true;
		$.ajax({
			url:"/brand/checkName",
			data:{brand_name:brand_name},
			type:'post',
			async:false,
			success:function(res){
					if(res>0){
					$('input[name="brand_name"]').next().text('品牌名称已存在');
					flag = false;
				}
			}
		})
		if(!flag) return;
		var brand_url = $('input[name="brand_url"]').val();
		if(!brand_url){
			$('input[name="brand_url"]').next().text('品牌网址不能为空');
			return;
		}

		//form表单提交
		$('form').submit();

	})

</script>
</body>
</html>