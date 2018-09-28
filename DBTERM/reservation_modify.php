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
$number=$_POST['number'];
$date = $_POST['day'];
$people = $_POST['people'];
$course = $_POST['course'];

$ret = mysqli_query($conn, "update reservation set date = '$date', people_num = $people, course_name='$course',added_datetime=NOW() where number = $number");

if(!$ret)
{
	mysqli_query("rollback",$conn);
    msg('Query Error : '.mysqli_error($conn));
}
else
{
	$res=mysqli_query($conn,"select * from reservation where date='$date' and people_num='$people' and course_name='$course' and member_id='$member_id'");
	if(!$res){
		mysqli_query("rollback",$conn);
 die('Query Error : ' . mysqli_error());
	}
	mysqli_query("commit",$conn);
	$row = mysqli_fetch_array($res);
	$number=$row['number'];
    s_msg ('성공적으로 수정 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=reservation_view.php?number={$number}'>";
}

?>
