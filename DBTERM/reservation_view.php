<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
/////보여주기 위해 select. dirty read만 막는다.
mysqli_query("set autocommit=0",$conn);
mysqli_query("set session transaction isolation level read committed",$conn);
mysqli_query("begin",$conn);
////////////////////////
if (array_key_exists("number", $_GET)) {
    $number = $_GET["number"];
    $query = "select * from reservation natural join course where number = $number";
    $res = mysqli_query($conn, $query);
    if(!$res){
    	 mysqli_query("rollback",$conn);
 die('Query Error : ' . mysqli_error());
    }
    else{
    	mysqli_query("commit",$conn);
    }
    $reserv = mysqli_fetch_assoc($res);
    if (!$reserv) {
        msg("예약이 존재하지 않습니다.");
    }
}
?>
    <div class="container">

        <h2>Reservation Details</h2>
        <br></br>

        <p>
            <label for="no">Reservation No.</label>
            <br><input class="form-control" readonly type="text" id="no" name="no" value="<?= $reserv['number'] ?>"/></br>
        </p>

        <p>
            <label for="date">Date</label>
            <br><input class="form-control" readonly type="text" id="day" name="day" value="<?= $reserv['date'] ?>"/></br>
        </p>
        <p>
            <label for="people">People#</label>
            <br><input class="form-control" readonly type="number" id="people" name="people" value="<?= $reserv['people_num'] ?>"/></br>
        </p>
        <p>
            <label for="course">Course</label>
            <br><input class="form-control" readonly type="text" id="course" name="course" value="<?= $reserv['course_name'] ?>"/></br>

        </p>
         <p>
            <label for="course">Price (won)</label>
            <br><input class="form-control" readonly type="number" id="price" name="price" value="<?= $reserv['course_price'] * $reserv['people_num']?>"/></br>

        </p>
        <p>
            <label for="time">AddedTime</label>
            <br><input class="form-control" readonly type="text" id="time" name="time" value="<?= $reserv['added_datetime'] ?>"/></br>
        </p>



    </div>
<? include("footer.php") ?>
