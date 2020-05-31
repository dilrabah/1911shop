<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>微商城后台-商品</title>
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
				<li  class="active"><a href="{{url('/goods')}}">商品管理</a></li>
				<li><a href="{{url('/admin')}}">管理员管理</a></li>
			</ul>
		</div>
		</div>
	</nav>
<center>
	<h2>商品 
		<span style="float:right"><a class="btn btn-default" href="{{'/goods'}}">展示</a></span>
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
<form class="form-horizontal" role="form" method="post" action="{{url('/goods/store')}}" enctype="multipart/form-data">
	@csrf
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">商品名称</label>
		<div class="col-sm-10">
			<input type="text" name="goods_name" class="form-control" id="firstname" 
				   placeholder="请输入商品名称">
			<b style="color:red">{{$errors->first('goods_name')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">商品货号</label>
		<div class="col-sm-10">
			<input type="text" name="goods_sn" class="form-control" id="lastname" 
				   placeholder="请输入商品货号">
			<b style="color:red">{{$errors->first('goods_sn')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">商品价格</label>
		<div class="col-sm-10">
			<input type="text" name="goods_price" class="form-control" id="lastname" 
				   placeholder="请输入商品价格">
			<b style="color:red">{{$errors->first('goods_price')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">商品库存</label>
		<div class="col-sm-10">
			<input type="text" name="goods_num" class="form-control" id="lastname" 
				   placeholder="请输入商品库存">
			<b style="color:red">{{$errors->first('goods_num')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">商品分类</label>
		<div class="col-sm-2">
			<select class="form-control" name="cate_id" id="firstname">
				<option value="">--请选择--</option>
				@foreach($cateInfo as $k => $v)
				<option value="{{$v->cate_id}}">{{str_repeat('|——',$v->level)}}{{$v->cate_name}}</option>
				@endforeach
			</select>
			<b style="color:red">{{$errors->first('cate_id')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">商品品牌</label>
		<div class="col-sm-2">
			<select class="form-control" name="brand_id" id="firstname">
				<option value="">--请选择--</option>
				@foreach($brandInfo as $key => $val)
				<option value="{{$val->brand_id}}">{{$val->brand_name}}</option>
				@endforeach
			</select>
			<b style="color:red">{{$errors->first('brand_id')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">商品主图</label>
		<div class="col-sm-3">
			<input type="file" name="goods_img" class="form-control" id="lastname" >
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">商品相册</label>
		<div class="col-sm-3">
			<input type="file" name="goods_imgs[]" multiple class="form-control" id="lastname" >
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">是否上架</label>
		<div class="col-sm-10">
			<input type="radio" name="is_on_sale" value="1" checked>是
			<input type="radio" name="is_on_sale" value="2">否
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">是否新品</label>
		<div class="col-sm-10">
			<input type="radio" name="is_new" value="1" checked>是
			<input type="radio" name="is_new" value="2">否
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">首页幻灯推荐位</label>
		<div class="col-sm-10">
			<input type="radio" name="is_slice" value="1">是
			<input type="radio" name="is_slice" value="2" checked>否
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">是否精品</label>
		<div class="col-sm-10">
			<input type="radio" name="is_best" value="1" checked>是
			<input type="radio" name="is_best" value="2">否
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">商品描述</label>
		<div class="col-sm-10">
			<textarea type="text" name="content" class="form-control" id="lastname"></textarea>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="button" class="btn btn-default">提交</button>
		</div>
	</div>
</form>
<script>
	//商品名称（失去焦点事件）
	$('input[name="goods_name"]').blur(function(){
		$(this).next().empty();
		var goods_name = $(this).val();
		var reg = /^[\u4e00-\u9fa5\w]{2,50}$/;
		if(!reg.test(goods_name)){
			$(this).next().text('商品名称可以包含中文、数字、字母、下划线且唯一，长度范围2-50位');
			return;
		}

		$.ajaxSetup({ 
			headers:{ 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') } 
		});
		//验证唯一
		$.post('/goods/checkName',{goods_name:goods_name},function(res){
			if(res>0){
				$('input[name="goods_name"]').next().text('商品名称已存在');
			}
		})
	})

	//商品货号(失去焦点事件)
	$('input[name="goods_sn"]').blur(function(){
		$(this).next().empty();
		var goods_sn = $(this).val();
		//alert(goods_sn);
		if(!goods_sn){
			$(this).next().text('商品货号不能为空');
		}
	})

	//商品价格(失去焦点事件)
	$('input[name="goods_price"]').blur(function(){
		$(this).next().empty();
		var goods_price = $(this).val();
		//alert(goods_price);
		if(!goods_price){
			$(this).next().text('商品价格不能为空');
		}
	})

	//商品库存(失去焦点事件)
	$('input[name="goods_num"]').blur(function(){
		$(this).next().empty();
		var goods_num = $(this).val();
		//alert(goods_num);
		if(!goods_num){
			$(this).next().text('商品库存不能为空');
		}
	})

	//表单验证提交（点击事件）
	$('button').click(function(){
		var goods_name = $('input[name="goods_name"]').val();
		var reg = /^[\u4e00-\u9fa5\w]{2,50}$/;
		if(!reg.test(goods_name)){
			$('input[name="goods_name"]').next().text('商品名称可以包含中文、数字、字母、下划线且唯一，长度范围2-50位');
			return;
		}
		$.ajaxSetup({ 
			headers:{ 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') } 
		});
		//验证唯一
		var flag = true;
		$.ajax({
			url:"/goods/checkName",
			data:{goods_name:goods_name},
			type:'post',
			async:false,
			success:function(res){
					if(res>0){
					$('input[name="goods_name"]').next().text('商品名称已存在');
					flag = false;
				}
			}
		})
		if(!flag) return;
		var goods_sn = $('input[name="goods_sn"]').val();
		if(!goods_sn){
			$('input[name="goods_sn"]').next().text('商品货号不能为空');
			return;
		}
		var goods_price = $('input[name="goods_price"]').val();
		if(!goods_price){
			$('input[name="goods_price"]').next().text('商品价格不能为空');
			return;
		}
		var goods_num = $('input[name="goods_num"]').val();
		//alert(goods_num);
		if(!goods_num){
			$('input[name="goods_num"]').next().text('商品库存不能为空');
		}

		//form表单提交
		$('form').submit();


	})


</script>
</body>
</html>