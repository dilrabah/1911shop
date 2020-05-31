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
				<li class="active"><a href="{{url('/goods')}}">商品管理</a></li>
				<li><a href="{{url('/admin')}}">管理员管理</a></li>
				<li><a>欢迎【<font color=red>{{session('admin')->admin_name}}</font>】登录</a></li>
				<li><a href="{{url('/quit')}}">退出</a></li>
			</ul>
		</div>
		</div>
	</nav>
<center>
	<h2>商品
		<span style="float:right"><a class="btn btn-info" href="{{'/goods/create'}}">添加</a></span>
	</h2><hr/>
</center>
<center>
<form>
	<input type="text" name="name" value="{{$name}}" placeholder="输入商品名称关键字">
	<select name="cate_id">
		<option value="">--请选择商品分类--</option>
		@foreach($cateInfo as $key => $val)
		<option value="{{$val->cate_id}}" @if($cate_id==$val->cate_id) selected="selected" @endif>
			{{str_repeat("|——",$val->level)}}{{$val->cate_name}}
		</option>
		@endforeach
	</select>
	<input type="text" name="min" value="{{$min}}" placeholder="请输入区间价">——
	<input type="text" name="max" value="{{$max}}" placeholder="请输入区间价">
	<button>搜索</button>
</form>
</center>
<table class="table">
	<thead>
		<tr>
			<th>商品id</th>
			<th>商品名称</th>
			<th>商品货号</th>
			<th>商品价格</th>
			<th>商品库存</th>
			<th>商品分类</th>
			<th>商品品牌</th>
			<th>是否上架</th>
			<th>是否新品</th>
			<th>是否精品</th>
			<th>商品相册</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($goodsInfo as $k => $v)
		<tr @if($k%2==0) class="active" @else class="danger"@endif>
			<td>{{$v->goods_id}}</td>
			<td>
				{{$v->goods_name}}
				@if($v->goods_img)
				<img src="{{env('UPLOAD_URL')}}{{$v->goods_img}}" width="66">
				@endif
			</td>
			<td>{{$v->goods_sn}}</td>
			<td>{{$v->goods_price}}</td>
			<td>{{$v->goods_num}}</td>
			<td>{{$v->cate_name}}</td>
			<td>{{$v->brand_name}}</td>
			<td>{{$v->is_on_sale==1 ? '√':'×'}}</td>
			<td>@if($v->is_new==1)√@endif @if($v->is_new==2)×@endif</td>
			<td>{{$v->is_best==1 ?'√':'×'}}</td>
			<td>
				@if($v->goods_imgs)
				@php $imgarr = explode('|',$v->goods_imgs);@endphp
				@foreach($imgarr as $img)
				<img src="{{env('UPLOAD_URL')}}{{$img}}" width="66">
				@endforeach
				@endif
			</td>
			<td>
				<a class="btn btn-primary" href="{{url('/goods/edit/'.$v->goods_id)}}">编辑</a>
				<a class="btn btn-danger" id="{{$v->goods_id}}" href="javascript:void;">删除</a>
			</td>
		</tr>
		@endforeach
		<tr>
			<td colspan='12' align="center">{{$goodsInfo ->appends(['name'=>$name,'cate_id'=>$cate_id,'min'=>$min,'max'=>$max])->links()}}</td>
		</tr>
	</tbody>
</table>
<script>
	$('.btn-danger').click(function(){
		var id = $(this).attr('id');
		if(confirm('你确定要删除吗？')){
				$.get('/goods/destroy/'+id,function(res){
				if(res.code==1){
					location.href="/goods";
				}
			},'json')
		}

		
	})
</script>
</body>
</html>