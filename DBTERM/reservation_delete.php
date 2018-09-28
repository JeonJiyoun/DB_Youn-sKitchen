<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);
//프라이머리 키 조건으로 지우기 때문에(primary key 바꿀일 없다.)
//제일 낮은 레벨을 주었다.
//read uncommitted
mysqli_query("set autocommit=0",$conn);
mysqli_query("set session transaction isolation level read uncommitted",$conn);
mysqli_query("begin",$conn);
/////////////////////
$number = $_GET['number'];
$query = "select * from reservation where number='$number'";
$res = mysqli_query($conn, $query);
if(!$res){
		 mysqli_query("rollback",$conn);
}
$row = mysqli_fetch_array($res);
$member_id=$row['member_id'];
$ret = mysqli_query($conn, "delete from reservation where number = $number");

if(!$ret)
{
	 mysqli_query("rollback",$conn);
    msg('Query Error : '.mysqli_error($conn));
}
else
{
	mysqli_query("commit",$conn);
    s_msg ($member_id.'회원의'.$number.'번 예약이 성공적으로 삭제 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=reservation_list.php?member_id={$member_id}'>";}

?>
