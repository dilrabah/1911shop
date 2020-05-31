<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>微商城后台-登录</title>
	<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
	<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<center>
	<h2>微商城后台-登录 </h2>
</center><hr/>
<b>{{session('msg')}}</b>
<form class="form-horizontal" role="form" method="post" action="{{url('/loginDo')}}">
	@csrf
	<div class="form-group">
		<label for="firstname" class="col-sm-4 control-label">用户名</label>
		<div class="col-sm-5">
			<input type="text" name="admin_name" class="form-control" id="firstname" 
				   placeholder="请输入用户名">
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-sm-4 control-label">密码</label>
		<div class="col-sm-5">
			<input type="password" name="admin_pwd" class="form-control" id="firstname" >
		</div>
	</div>
	<div class="form-group">
    <div class="col-sm-offset-4 col-sm-5">
      <div class="checkbox">
        <label>
          <input type="checkbox"  name="remember_me">7天免登陆
        </label>
      </div>
    </div>
  </div>
	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-10">
			<button type="submit" class="btn btn-default">登录</button>
		</div>
	</div>
</form>

</body>
</html>