<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>



	<div id="fh5co-container">

		<div id="fh5co-events" data-section="events">
			<div class="container">
				<div class="row text-center fh5co-heading row-padded">
					<div class="col-md-8 col-md-offset-2">
						<h2 class="heading">Our Chef</h2>
						<p class="sub-heading">we have great chefs</p>
					</div>
				</div>
				<?
			 $conn = dbconnect($host, $dbid, $dbpass, $dbname);
			 ///읽어와서 보여주기만 하므로 dirty read만 막는다.
			 mysqli_query("set autocommit=0",$conn);
			mysqli_query("set session transaction isolation level read committed",$conn);
			mysqli_query("begin",$conn);
             //////////////////
			  $query = "select * from chef";

			 $res = mysqli_query($conn, $query);
			 if (!$res) {
			 	  mysqli_query("rollback",$conn);
    			  die('Query Error : ' . mysqli_error());
			  }
			  else{
			 mysqli_query("commit",$conn);	}
			 ?>

    			<table class="table" id="font_color">
    		    <thead>
    		    <tr>
    	       <th>No.</th>
        	    <th>ChefName</th>
        		</tr>
               </thead>
    	 	 <tbody>
        		<?
        		$row_index = 1;
        			while ($row = mysqli_fetch_array($res)) {
            		echo "<tr>";
            		echo "<td>{$row_index}</td>";
            		echo "<td><a href='chef_view.php?chef_id={$row['c_id']}'>{$row['chef_name']}</a></td>";

            		if($_COOKIE[cookie_admin]==1){

        			 echo "<td width='17%'>
                		<a href='chef_form.php?chef_id={$row['c_id']}'><button class='brn'>수정</button></a>
                		<button onclick='javascript:deleteConfirm({$row['c_id']})' class='btn-primary'>삭제</button>
                		</td>";}
            		echo "</tr>";
        			 $row_index++;
        			}
        		?>
        	</tbody>
    	</table>
    	<script>
        function deleteConfirm(chef_id) {
            if (confirm("정말 삭제하시겠습니까?") == true){    //확인
                window.location = "chef_delete.php?c_id=" + chef_id;
            }else{   //취소
                return;
            }
        }
	    </script>
			</div>
		</div>


	</div>



<? include("footer.php") ?>
