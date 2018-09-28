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
$menu_id = $_GET['m_id'];
$res = mysqli_query($conn, "select * from menu where m_id = $menu_id");
if(!$res){
	 mysqli_query("rollback",$conn);
}
$row = mysqli_fetch_array($res);
$menu_name=$row['menu_name'];
$ret = mysqli_query($conn, "delete from menu where m_id = $menu_id");

if(!$ret)
{
	 mysqli_query("rollback",$conn);
    msg('Query Error : '.mysqli_error($conn));
}
else
{
	mysqli_query("commit",$conn);
    s_msg ($menu_name.' 메뉴가 성공적으로 삭제 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=menu_list.php'>";
}

?>
