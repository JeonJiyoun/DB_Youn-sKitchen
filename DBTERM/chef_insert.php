<?php
include "config.php"; //데이터베이스 연결 설정파일
include "util.php"; //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);
// insert, select .내가 입력한 정보를 정확히 보여줘야 한다.
//insert 하는 동안은 이 데이터에 대해 아무도 접근할 수 없다.
mysqli_query("set autocommit=0",$conn);
mysqli_query("set session transaction isolation level serializable",$conn);
mysqli_query("begin",$conn);
////////////////////////////
$chef_name = $_POST['chef_name'];
$star = $_POST['star'];
$career = $_POST['career'];

$ret = mysqli_query($conn, "insert into chef(chef_name, star, career) values ('$chef_name','$star','$career')");
if(!$ret)
{
mysqli_query("rollback",$conn);  // rollback
msg('요리사 입력 실패 하였습니다. Query Error : '.mysqli_error($conn));
}
else
{
	$res=mysqli_query($conn,"select * from chef where chef_name = '$chef_name' and star=$star and career='$career'");
	if(!$res){
		mysqli_query("rollback",$conn);
	}
	else{
		mysqli_query("commit",$conn);
	}
	$row = mysqli_fetch_array($res);
	$c_id=$row['c_id'];
    s_msg ('성공적으로 입력 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=chef_view.php?chef_id={$c_id}'>";
}
mysqli_close($conn);
?>
