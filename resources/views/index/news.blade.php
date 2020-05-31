<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>新闻列表</title>
	<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
	<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	
<center>
	<h2>新闻列表
		<span style="float:right"><a class="btn btn-default" href="{{'/brand/create'}}">添加</a></span>
	</h2>
</center><hr/>
<form>
	<input type="text" name="title" value="{{$title}}" placeholder="请输入关键字">
	<button>搜索</button>
</form>
<table class="table">
	<thead>
		<tr>
			<th>ID</th>
			<th>新闻标题</th>
			<th>作者</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($news as $k => $v)
		<tr @if($k%2==0) class="active" @else class="success" @endif>
			<td>{{$v->n_id}}</td>
			<td>{{$v->title}}</td>
			<td>{{$v->man}}</td>
			<td>
				<a class="btn btn-primary" href="#">编辑</a>
				<a class="btn btn-danger" href="#">删除</a>
			</td>
		</tr>
		@endforeach
		
		<tr><td colspan=5 align="center">{{$news->appends(['title'=>$title])->links()}}</td></tr>
	</tbody>
</table>
	
</body>
</html>