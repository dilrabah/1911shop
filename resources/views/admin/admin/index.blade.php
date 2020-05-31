<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>微商城后台-商品品牌</title>
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
				<li class="active"><a href="{{url('/admin')}}">管理员管理</a></li>
				<li><a>欢迎【<font color=red>{{session('admin')->admin_name}}</font>】登录</a></li>
				<li><a href="{{url('/quit')}}">退出</a></li>
			</ul>
		</div>
		</div>
	</nav>
<center>
	<h2>管理员
		<span style="float:right"><a class="btn btn-primary" href="{{'/admin/create'}}">添加</a></span>
	</h2>
</center><hr/>
<table class="table">
	<thead>
		<tr>
			<th>管理员id</th>
			<th>管理员名称</th>
			<th>管理员头像</th>
			<th>管理员电话</th>
			<th>管理员邮箱</th>
			<th>添加时间</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($admin as $k => $v)
		<tr @if($k%2==0) class="active" @else class="success" @endif>
			<td>{{$v->admin_id}}</td>
			<td>{{$v->admin_name}}</td>
			<td>
				@if($v->admin_img)
				<img src="{{env('UPLOAD_URL')}}{{$v->admin_img}}" width="66">
				@endif
			</td>
			<td>{{$v->admin_tel}}</td>
			<td>{{$v->admin_email}}</td>
			<td>{{date('Y-m-d H:i:s',$v->add_time)}}</td>
			<td>
				<a class="btn btn-primary" href="{{url('/admin/edit/'.$v->admin_id)}}">编辑</a>
				<a class="btn btn-danger" id="{{$v->admin_id}}" href="javascript:void;">删除</a>
			</td>
		</tr>
		@endforeach
		<tr>
			<td colspan="7" align="center">{{$admin->links()}}</td>
		</tr>
	</tbody>
</table>
	<script>
		$('.btn-danger').click(function(){
			var id = $(this).attr('id');
			if(confirm('你确定要删除此条数据?')){
				$.get('/admin/destroy/'+id,function(res){
					if(res.code==1){
						location.href="/admin";
					}
				},'json')
			}
			
		})
	</script>

</body>
</html>