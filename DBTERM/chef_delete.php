<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);
///////////////select -> delete
//프라이머리 키 조건으로 지우기 때문에(primary key 바꿀일 없다.) 제일 낮은 레벨을 주었다.
//read uncommitted
mysqli_query("set autocommit=0",$conn);
mysqli_query("set session transaction isolation level read uncommitted",$conn);
mysqli_query("begin",$conn);
/////////////////////
$chef_id = $_GET['c_id'];
$res = mysqli_query($conn, "select * from chef where c_id = $chef_id");
$row = mysqli_fetch_array($res);
$chef_name=$row['chef_name'];
$ret = mysqli_query($conn, "delete from chef where c_id = $chef_id");


if(!$ret)
{
	mysqli_query("rollback",$conn);
    msg('Query Error : '.mysqli_error($conn));
}
else
{

	mysqli_query("commit",$conn);

    s_msg ($chef_name.' 요리사가 성공적으로 삭제 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=chef_list.php'>";
}
mysqli_close($conn);
?>
