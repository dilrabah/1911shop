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
		<span style="float:right"><a class="btn btn-info" href="{{'/article/create'}}">添加</a></span>
	</h2><hr/>
</center>
<center>
<form>
	<input type="text" name="name" value="{{$name}}" placeholder="请输入文章标题">
	<select name="t_id">
		<option value="">--请选择文章分类--</option>
		@foreach ($type as $vo)
		<option value="{{$vo->t_id}}" {{$t_id==$vo->t_id ?'selected':''}}>{{$vo->t_name}}</option>
		@endforeach
	</select>
	<button>搜索</button>
</form>
</center>
<table class="table">
	<thead>
		<tr>
			<th>编号</th>
			<th>文章标题</th>
			<th>文章分类</th>
			<th>文章重要性</th>
			<th>是否显示</th>
			<th>文章图片</th>
			<th>添加日期</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($data as $k => $v)
		<tr @if($k%2==0) class="active" @alse class="danger"@endif>
			<td>{{$v->article_id}}</td>
			<td>{{$v->name}}</td>
			<td>{{$v->t_name}}</td>
			<td>{{$v->is_zy==1 ? '普通':'重要'}}</td>
			<td>{{$v->is_show==1 ? '√':'×'}}</td>
			<td>
				@if($v->img)
				<img src="{{env('UPLOAD_URL')}}{{$v->img}}" width="66">
				@endif
			</td>
			<td>{{date('Y-m-d H:i:s',$v->add_time)}}</td>
			<td>
				<a class="btn btn-primary" href="{{url('/article/edit/'.$v->article_id)}}">编辑</a>
				<a class="btn btn-danger" href="{{url('/article/destroy/'.$v->article_id)}}">删除</a>
			</td>
		</tr>
		@endforeach
		<tr>
			<td colspan="8" align="center">{{$data->appends(['name'=>$name,'t_id'=>$t_id])->links()}}</td>
		</tr>
	</tbody>
</table>

</body>
</html>