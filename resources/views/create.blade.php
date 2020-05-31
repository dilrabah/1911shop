<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<center>
		<h2>学生添加</h2>
		<form action="store" method="post">
			@csrf
			<tr>
				<td>姓名</td>
				<td><input type="text" name="name"></td>
			</tr>
			<tr>
				<td>班级</td>
				<td><input type="text" name="class"></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<button>添加</button>
				</td>
			</tr>
		</form>
	</center>
</body>
</html>