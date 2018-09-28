<? include ("header.php") ?>
<div class="container">
	<div class="col-md-10">
	<form class="form-group" name ="form" action="join_insert.php" method="post">
		<div align="center"><h3>[ JOIN ]</h3></div>
		<br></br>
	<table class="table color_white" width="440" border="1">
	<tr><th width="192" scope="row">ID</th>
	<td><input class="form-control2" type="text" name="txt_ID"/></td></tr>
	<tr><th scope="row">PASSWORD</th>
	<td><input class="form-control2" type="password" name="passwd"/></td></tr>
	<tr><th scope="row">PASSWORD 확인</th>
	<td><input class="form-control2" type="password" name="c_passwd"/></td></tr>
	<tr> <th scope="row">이름</th>
	<td><input class="form-control2" type="text" name="txt_name"/></td></tr>
	<tr><th scope="row">전화번호 (-포함해서 입력해주세요)</th>
	<td><input class="form-control2" type="text" name="txt_phone"/></td></tr>
	</table>


<div align="right">
<input class= "btn btn-warning" type="submit" name="send" value="가입하기" />
</div>

</form>
</div>
</div>
<? include ("footer.php") ?>
