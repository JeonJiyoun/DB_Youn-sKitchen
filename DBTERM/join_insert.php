<?php
include "config.php"; //데이터베이스 연결 설정파일
include "util.php"; //유틸 함수
$connect = dbconnect($host,$dbid,$dbpass,$dbname);
////select, insert 회원 등록 하는 동안 아무도 접근할 수 없게 하기 위해
//가장 높은 레벨을 주었다.
mysqli_query("set autocommit=0",$conn);
mysqli_query("set session transaction isolation level serializable",$conn);
mysqli_query("begin",$conn);
///////////////////
$id = $_POST['txt_ID'];
$pass = $_POST['passwd'];
$c_pass = $_POST['c_passwd'];
$name = $_POST['txt_name'];
$phone = $_POST['txt_phone'];
$ret = mysqli_query($connect,"select member_id from member where member_id='$id'");
if(!$ret){
	mysqli_query("rollback",$conn);
}
else{
//ID 조사
$num = mysqli_num_rows($ret);
if($num)
{
msg('이미 존재하는 회원ID입니다!');
}
else if(check_pass($pass,$c_pass)!=0) //PASS 조사
{
msg('패스워드가 맞지 않습니다!');
}
else if($id==''||$pass==''||$c_pass==''||$name==''||$phone==''){
	msg('빠짐없이 입력해주세요');
}
else
{
$insert_query = "insert into member (member_id, password, name, phone,admin) values ('$id','$pass','$name','$phone', 0 )";
$insert_ret = mysqli_query($connect,$insert_query);
if(!$insert_ret)
{
	mysqli_query("rollback",$conn);
	msg('DB에 에러가 발생!'); }
else
{
	mysqli_query("commit",$conn);
	s_msg('가입되었습니다');
echo "<meta http-equiv='refresh' content='0;url=login.php'>"; }
}}
mysqli_close($connect);
?>
