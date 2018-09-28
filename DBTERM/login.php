<?php include "header.php"; ?>
<br></br>

<h2 align="center">LOGIN <span class="icon icon-user"></span></h2>



<div class="container">
<form class="form-group"name ="form" action="login_confirm.php" method="post">

<div>
<font color="#ECE0F8" size="5">ID </font>
<div align="center"><input class="form-control2" name="txt_ID" type="text" /></div>
</div>

<div>
<font color="#ECE0F8" size="5">Password </font>
<div align="center"><input class="form-control2" name="passwd" type="password" />
</div>
</div>
<br></br>

<div align="center">
<input class="btn btn-warning" type="submit" name="button2" value="로그인" />
<br>아직 회원이 아니신가요?</br>
<a href="join.php">회원가입</a>
</div>

</form>
</div>
<?php include "footer.php"; ?>
