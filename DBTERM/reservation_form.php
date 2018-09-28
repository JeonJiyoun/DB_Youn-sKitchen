<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
$mode = "Adding";
$action = "reservation_insert.php";

/////보여주기 위해 select. dirty read만 막는다.
mysqli_query("set autocommit=0",$conn);
mysqli_query("set session transaction isolation level read committed",$conn);
mysqli_query("begin",$conn);
////////////////////////
if (array_key_exists("member_id", $_GET)) {
    $member_id = $_GET["member_id"];
    $number=$_GET["number"];
    $query =  "select * from reservation where number = $number";
    $res = mysqli_query($conn, $query);
    if(!$res){
    	 mysqli_query("rollback",$conn);
    }
    $reserv = mysqli_fetch_array($res);
    if($reserv) {
       $mode = "Modifying";
       $action = "reservation_modify.php";
    }

}
?>
    <div class="container">
        <form class="form group" name="reservation_form" action="<?=$action?>" method="post" class="fullwidth">
            <input type="hidden" name="member_id" value="<?=$member_id?>"/>
             <input type="hidden" name="number" value="<?=$number?>"/>
            <h2><em>Reservation <?=$mode?></em></h2>
            <p>
                <label for="day">Date</label>
                <br><input class="form-control2" type="text" placeholder="예약날짜 입력" id="day" name="day" value="<?=$reserv['date']?>"/></br>
            </p>
            <p>
                <label for="people">People#</label>
			  	<br><input class="form-control2" type="number" placeholder="방문 인원 입력" id="people" name="people" value="<?=$reserv['people_num']?>"/></br>
			</p>
			<?
			$course = array();
			$query = "select * from course";
			$res = mysqli_query($conn, $query);
			 if(!$res){
    			 mysqli_query("rollback",$conn);
				die('Query Error : ' . mysqli_error());
			  }
			 else{
    			mysqli_query("commit",$conn);
				  }
			while($row = mysqli_fetch_assoc($res)) {
			$course[$row['course_name']] = $row['course_name'];}?>


			<label for="course">Course</label>
			<div class="color">
			<select name="course" id="course">
			<option value="-1">코스는 하나만 예약가능합니다.</option>
			<?
				foreach($course as $id => $name) {
				if($id == $reserv['course_name']) {
				echo "<option value='{$id}' selected>{$name}</option>";
				} else {
				echo "<option value='{$id}'>{$name}</option>";
					}
				}
			?>
			</select>
            </div>
            <p align="center"><button class="btn btn-warning" onclick="javascript:return validate();"><?=$mode?></button></p>

            <script>
                function validate() {
                    if(document.getElementById("day").value == "") {
                        alert ("날짜를 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("people").value == ""||document.getElementById("people").value <=0) {
                        alert ("인원을 제대로 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("course").value == -1) {
                        alert ("코스를 입력해 주십시오"); return false;
                    }

                    return true;
                }
            </script>

        </form>
    </div>
<? include("footer.php") ?>
