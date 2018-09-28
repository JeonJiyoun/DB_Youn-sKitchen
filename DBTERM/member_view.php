<?
include "header.php";
include "config.php";
include "util.php";


$conn=dbconnect($host,$dbid,$dbpass,$dbname);
///읽어와서 보여주기만 하므로 dirty read만 막는다.
 mysqli_query("set autocommit=0",$conn);
 mysqli_query("set session transaction isolation level read committed",$conn);
 mysqli_query("begin",$conn);
 //////////////////
if(array_key_exists("member_id",$_GET)){
	$mem_id=$_GET["member_id"];
	$query="select * from member where member_id='$mem_id'";
	$res=mysqli_query($conn, $query);
	if(!$res){
		 mysqli_query("rollback",$conn);
	}
	else{
		mysqli_query("commit",$conn);
	}
	$member=mysqli_fetch_array($res);
	if(!$member){
		msg("회원정보가 없습니다.");
	}
}?>
<div class="container">
	<h2>My Kitchen</h2>
	<br></br>
	<p>
		<label for="member_id">ID</label>

		<br><input class="form-control2" readonly type="text" id="member_id" name="member_id" value="<?= $member['member_id'] ?>"/></br>

	</p>
	<p>
		<label for="name">이름</label>
	   <br>	<input class="form-control2" readonly type="text" id="name" name="name" value="<?= $member['name'] ?>"/></br>
	</p>
	<p>
		<label for="phone_num">전화번호</label>
		<br><input class="form-control2" readonly type="text" id="phone_num" name="phone_num" value="<?= $member['phone'] ?>"/></br>
	</p>
	<p>
		<?
         $reserv=$member['member_id'];
         echo"<a href='reservation_list.php?member_id={$reserv}'><button class='btn'>예약내역</button></a>";

         echo"<a href='reservation_form.php?member_id={$reserv}'><button class='btn btn-warning'>예약하기</button></a>";
        ?>
    </p>
    <div align="right">
    	<?
    	echo "<a href='member_delete.php?member_id={$member['member_id']}'><button class='btn btn-danger btn-sm'>회원탈퇴</button></a>";
    	echo "<a href='member_modiform.php?member_id={$member['member_id']}'><button class='btn btn-info btn-sm'>회원정보수정</button></a>";
    	?>
    </div>


</div>
<? include("footer.php") ?>
