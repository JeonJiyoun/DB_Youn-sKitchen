<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);
//////수정하는 동안 이 트랜잭션에 아무도 접근할 수 없다. 가장 높은 레벨
mysqli_query("set autocommit=0",$conn);
mysqli_query("set session transaction isolation level serializable",$conn);
mysqli_query("begin",$conn);
////////////////////////
$chef_id=$_POST['chef_id'];
$chef_name = $_POST['chef_name'];
$career = $_POST['career'];
$star=$_POST['star'];

$ret = mysqli_query($conn, "update chef set chef_name = '$chef_name', star=$star,career='$career' where c_id = $chef_id");

if(!$ret)
{
	mysqli_query("rollback",$conn);
    msg('Query Error : '.mysqli_error($conn));
}
else
{
	mysqli_query("commit",$conn);
 	s_msg ('성공적으로 수정 되었습니다');
	echo "<meta http-equiv='refresh' content='0;url=chef_view.php?chef_id={$chef_id}'>";
}

?>
