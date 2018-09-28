<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);
//////수정하는 동안 이 트랜잭션에 아무도 접근할 수 없다. 가장 높은 레벨
mysqli_query("set autocommit=0",$conn);
mysqli_query("set session transaction isolation level serializable",$conn);
mysqli_query("begin",$conn);
////////////////////////

$menu_id=$_POST['m_id'];
$menu_name = $_POST['menu_name'];
$menu_desc = $_POST['menu_desc'];
$chef_id = $_POST['chef_id'];
$price = $_POST['price'];
$ingredient=$_POST['ingredient'];
$type=$_POST['type_id'];
$course=$_POST['course_name'];

$ret = mysqli_query($conn, "update menu set menu_name = '$menu_name', menu_desc = '$menu_desc', price = $price ,c_id=$chef_id,ingredient='$ingredient',t_id=$type, course_name='$course' where m_id = $menu_id");

if(!$ret)
{
	 mysqli_query("rollback",$conn);
    msg('Query Error : '.mysqli_error($conn));
}
else
{
	mysqli_query("commit",$conn);
	s_msg ('성공적으로 수정 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=menu_view.php?menu_id={$menu_id}'>";
}

?>
