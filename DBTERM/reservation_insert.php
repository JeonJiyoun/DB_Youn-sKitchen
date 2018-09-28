<?php
include "config.php"; //데이터베이스 연결 설정파일
include "util.php"; //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);
/////insert하는동안 다른 트랜잭션이 접근할 수 없다. 가장 높은 레벨
mysqli_query("set autocommit=0",$conn);
mysqli_query("set session transaction isolation level serializable",$conn);
mysqli_query("begin",$conn);
///////////////////////////
$member_id = $_POST['member_id'];
$date = $_POST['day'];
$people = $_POST['people'];
$course=$_POST['course'];

$ret = mysqli_query($conn, "insert into reservation(date, people_num, member_id,course_name,added_datetime) values ('$date',$people,'$member_id','$course',NOW())");
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

s_msg ('성공적으로 입력 되었습니다');
 echo "<meta http-equiv='refresh' content='0;url=reservation_view.php?number={$number}'>";
}
?>
