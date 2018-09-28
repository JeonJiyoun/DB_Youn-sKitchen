<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);
//////수정하는 동안 이 트랜잭션에 아무도 접근할 수 없다. 가장 높은 레벨
mysqli_query("set autocommit=0",$conn);
mysqli_query("set session transaction isolation level serializable",$conn);
mysqli_query("begin",$conn);
////////////////////////
$member_id=$_POST['member_id'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$pass=$_POST['pass'];
$c_pass=$_POST['c_pass'];

if(check_pass($pass,$c_pass)!=0) //PASS 조사
{
msg('패스워드가 맞지 않습니다!');
}
$ret = mysqli_query($conn, "update member set name='$name', phone='$phone', password='$pass' where member_id = '$member_id'");

if(!$ret)
{
	mysqli_query("rollback",$conn);
    msg('Query Error : '.mysqli_error($conn));
}
else
{
	mysqli_query("commit",$conn);
 	s_msg ('성공적으로 수정 되었습니다');
	echo "<meta http-equiv='refresh' content='0;url=member_view.php?member_id={$member_id}'>";
}

?>
