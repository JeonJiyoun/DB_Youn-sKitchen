<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>
<div id="fh5co-container">
	<div id="fh5co-contact" data-section="reservation">
   	  <div class="container">
   	  	<div class="row text-center fh5co-heading row-padded">
   	  		<div class="col-md-8 col-md-offset-2">
   	  			<h2 class="heading">My Reservation</h2>
   	  			<p class="sub-heading">Make sure to visit our kitchen</p>
   	  			</div>
   	  			</div>
    <?
     $conn = dbconnect($host, $dbid, $dbpass, $dbname);
      ///읽어와서 보여주기만 하므로 dirty read만 막는다.
			 mysqli_query("set autocommit=0",$conn);
			mysqli_query("set session transaction isolation level read committed",$conn);
			mysqli_query("begin",$conn);
             //////////////////
    if (array_key_exists("member_id", $_GET)) {
    $member_id = $_GET["member_id"];
    $query = "select * from reservation where member_id='$member_id'";
    $res = mysqli_query($conn, $query);

    	if (!$res) {
    		 mysqli_query("rollback",$conn);
    		msg('Query Error : '.mysqli_error($conn));

    	}
        else{
    	if (array_key_exists("number", $_GET)) {
    		$number = $_GET["number"];
			$query = "select * from reservation where member_id='$member_id' and number=$number";
    		$res = mysqli_query($conn, $query);
    			if (!$res) {
    		          mysqli_query("rollback",$conn);
    				  msg('Query Error : '.mysqli_error($conn));
    			}
    	     }
               		mysqli_query("commit",$conn);
        }

    }

    ?>


   	    <table class="table">

        <thead>
        <tr>
            <th>No.</th>
            <th>Reservation_Number</th>
            <th>Date</th>
            <th>Coure</th>
            <th>People_Num</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?
    	$res2 = mysqli_query($conn, $query);
    	$row_2=mysqli_fetch_array($res2);
        if(!$row_2){
        	msg("예약이 존재하지 않습니다.") ;
        }
        else{
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td>{$row_index}</td>";
            echo "<td><a href='reservation_view.php?number={$row['number']}'>{$row['number']}</a></td>";
            echo "<td>{$row['date']}</td>";
            echo "<td>{$row['course_name']}</td>";
            echo "<td>{$row['people_num']}</td>";
            echo "<td width='17%'>
                <a href='reservation_form.php?member_id={$row['member_id']}&number={$row['number']}'><button class='brn'>예약수정</button></a>
                 <button onclick='javascript:deleteConfirm({$row['number']})' class='btn-primary'>예약취소</button>
                </td>";
            echo "</tr>";
            $row_index++;
        }}
        ?>
        </tbody>
    </table>
    <script>
        function deleteConfirm(number) {
            if (confirm("정말 삭제하시겠습니까?") == true){    //확인
                window.location = "reservation_delete.php?number=" +number;
            }else{   //취소
                return;
            }
        }
    </script>
    </div>
</div>
</div>
<? include("footer.php") ?>
