<form action="add" method="post">
	@csrf
	<input type="text" name="name">
	<input type="text" name="pwd">
	<button>提交</button>
</form>