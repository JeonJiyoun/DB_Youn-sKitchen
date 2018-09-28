<?php
include "config.php"; //데이터베이스 연결 설정파일
include "util.php"; //유틸 함수
$conn = dbconnect($host,$dbid,$dbpass,$dbname);
/////insert하는동안 다른 트랜잭션이 접근할 수 없다. 가장 높은 레벨
mysqli_query("set autocommit=0",$conn);
mysqli_query("set session transaction isolation level serializable",$conn);
mysqli_query("begin",$conn);
///////////////////////////
$menu_name = $_POST['menu_name'];
$menu_desc = $_POST['menu_desc'];
$chef_id = $_POST['chef_id'];
$price = $_POST['price'];
$ingredient=$_POST['ingredient'];
$type=$_POST['type_id'];
$course=$_POST['course_name'];
$ret = mysqli_query($conn, "insert into menu (menu_name, price, ingredient, menu_desc,c_id,added_datetime,course_name,t_id) values('$menu_name', '$price','$ingredient','$menu_desc', '$chef_id',NOW(),'$course','$type')");

if(!$ret){
	mysqli_query("rollback",$conn);
    msg('Query Error : '.mysqli_error($conn));
}
else{
$res=mysqli_query($conn,"select * from menu where menu_name = '$menu_name' and menu_desc = '$menu_desc' and price = $price and c_id=$chef_id and ingredient='$ingredient' and t_id=$type and course_name='$course'");
$row = mysqli_fetch_array($res);
$m_id=$row['m_id'];


if(!$res)
{
mysqli_query("rollback",$conn);
msg('Query Error : '.mysqli_error($conn));
}
else
{
    mysqli_query("commit",$conn);
    s_msg ('성공적으로 입력 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=menu_view.php?menu_id={$m_id}'>";
}}
?>
