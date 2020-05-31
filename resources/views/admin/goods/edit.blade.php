<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>微商城后台-商品</title>
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
<form class="form-horizontal" role="form" method="post" action="{{url('/goods/update/'.$goods->goods_id)}}" enctype="multipart/form-data">
	@csrf
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">商品名称</label>
		<div class="col-sm-10">
			<input type="text" name="goods_name" value="{{$goods->goods_name}}" class="form-control" id="firstname" 
				   placeholder="请输入商品名称">
			<b style="color:red">{{$errors->first('goods_name')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">商品货号</label>
		<div class="col-sm-10">
			<input type="text" name="goods_sn" value="{{$goods->goods_sn}}" class="form-control" id="lastname" 
				   placeholder="请输入商品货号">
			<b style="color:red">{{$errors->first('goods_sn')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">商品价格</label>
		<div class="col-sm-10">
			<input type="text" name="goods_price" value="{{$goods->goods_price}}" class="form-control" id="lastname" 
				   placeholder="请输入商品价格">
			<b style="color:red">{{$errors->first('goods_price')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">商品库存</label>
		<div class="col-sm-10">
			<input type="text" name="goods_num" value="{{$goods->goods_num}}" class="form-control" id="lastname" 
				   placeholder="请输入商品库存">
			<b style="color:red">{{$errors->first('goods_num')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">商品分类</label>
		<div class="col-sm-10">
			<select class="form-control" name="cate_id" id="firstname">
				<option value="">--请选择--</option>
				@foreach($cateInfo as $k => $v)
				<option value="{{$v->cate_id}}" {{$goods->cate_id==$v->cate_id?'selected':''}}>{{str_repeat('|——',$v->level)}}{{$v->cate_name}}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">品牌分类</label>
		<div class="col-sm-10">
			<select class="form-control" name="brand_id" id="firstname">
				<option value="">--请选择--</option>
				@foreach($brandInfo as $key => $val)
				<option value="{{$val->brand_id}}" {{$goods->brand_id==$val->brand_id?'selected':''}}>{{$val->brand_name}}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">商品主图</label>
		@if($goods->goods_img)
				<img src="{{env('UPLOAD_URL')}}{{$goods->goods_img}}" width="66">
		@endif
		<div class="col-sm-3">
			<input type="file" name="goods_img" class="form-control" id="lastname" >
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">商品相册</label>
		<div class="col-sm-10">
			<input type="file" name="goods_imgs[]" multiple class="form-control" id="lastname" >
		</div>
		@if($v->goods_imgs)
				@php $imgarr = explode('|',$v->goods_imgs);@endphp
				@foreach($imgarr as $img)
				<img src="{{env('UPLOAD_URL')}}{{$img}}" width="66">
				@endforeach
				@endif
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">是否上下架</label>
		<div class="col-sm-10">
			<input type="radio" name="is_on_sale" value="1" {{$goods->is_on_sale==1?'checked':''}}>是
			<input type="radio" name="is_on_sale" value="2" {{$goods->is_on_sale==2?'checked':''}}>否
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">是否新品</label>
		<div class="col-sm-10">
			<input type="radio" name="is_new" value="1" {{$goods->is_new==1?'checked':''}}>是
			<input type="radio" name="is_new" value="2" {{$goods->is_new==2?'checked':''}}>否
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">是否精品</label>
		<div class="col-sm-10">
			<input type="radio" name="is_best" value="1" {{$goods->is_best==1?'checked':''}}>是
			<input type="radio" name="is_best" value="2" {{$goods->is_best==2?'checked':''}}>否
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">商品描述</label>
		<div class="col-sm-10">
			<textarea type="text" name="content" class="form-control" id="lastname">{{$goods->content}}</textarea>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-default">编辑</button>
		</div>
	</div>
</form>

</body>
</html>