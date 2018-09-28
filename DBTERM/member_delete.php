<?php
include "config.php"; //데이터베이스 연결 설정파일
include "util.php"; //유틸 함수
$conn = dbconnect($host,$dbid,$dbpass,$dbname);

//프라이머리 키 조건으로 지우기 때문에(primary key 바꿀일 없다.)
//제일 낮은 레벨을 주었다.
//read uncommitted
mysqli_query("set autocommit=0",$conn);
mysqli_query("set session transaction isolation level read uncommitted",$conn);
mysqli_query("begin",$conn);
/////////////////////
$member_id = $_GET['member_id'];
$ret = mysqli_query($conn, "delete from member where member_id = '$member_id'");
if(!$ret)
{
	 mysqli_query("rollback",$conn);
msg('Query Error : '.mysqli_error($conn));
}
else
{
mysqli_query("commit",$conn);
s_msg ($member_id.' 멤버가 성공적으로 탈퇴 되었습니다');

if($_COOKIE['cookie_admin']==1){
	echo "<meta http-equiv='refresh' content='0;url=member_list.php'>";
}
else{
SetCookie("cookie_id","",time(),"/");
SetCookie("cookie_name","",time(),"/");
SetCookie("cookie_sid","",time(),"/");
echo "<meta http-equiv='refresh' content='0;url=login.php'>";}

}


include "footer.php";
?>
