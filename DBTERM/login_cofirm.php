<?php
include "config.php"; //데이터베이스 연결 설정파일
include "util.php"; //유틸 함수
$connect = dbconnect($host,$dbid,$dbpass,$dbname);
//////로그인 하는동안 다른사람이 접근하기 못하게 한다.
mysqli_query("set autocommit=0",$conn);
mysqli_query("set session transaction isolation level serializable",$conn);
mysqli_query("begin",$conn);
/////////////////////
$id = $_POST['txt_ID'];
$pass = $_POST['passwd'];
$mem_ret = mysqli_query($connect,"select * from member where member_id = '$id'");
if(!$mem_ret){
	mysqli_query("rollback",$conn);
 die('Query Error : ' . mysqli_error());

}
else{
	mysqli_query("commit",$conn);
}
$mem_num = mysqli_num_rows($mem_ret);
if(!$mem_num) // id로 검색된 회원이 없을 경우
{
msg('잘못된 아이디 입니다!');
}
else
{
$mem_array = mysqli_fetch_array($mem_ret);
$db_name = $mem_array['name'];
$db_pass = $mem_array['password'];
$db_admin = $mem_array['admin'];
if($db_pass == $pass)
{
SetCookie("cookie_id", $id,0,"/"); // 0 : browser lifetime – 0 or omitted : end of session
SetCookie("cookie_name", $db_name,0, "/");
SetCookie("cookie_admin", $db_admin,0, "/");

echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
msg('잘못된 패스워드 입니다!');
}
}
mysqli_close($connect);
?>
