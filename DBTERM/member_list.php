<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>



	<div id="fh5co-container">

		<div id="fh5co-menus" data-section="menus">
			<div class="container">
				<div class="row text-center fh5co-heading row-padded">
					<div class="col-md-8 col-md-offset-2">
						<h2 class="heading">Members</h2>
						<p class="sub-heading">Our precious customers</p>
					</div>
				</div>
				<?
			 $conn = dbconnect($host, $dbid, $dbpass, $dbname);
			  ///읽어와서 보여주기만 하므로 dirty read만 막는다.
			 mysqli_query("set autocommit=0",$conn);
			mysqli_query("set session transaction isolation level read committed",$conn);
			mysqli_query("begin",$conn);
             //////////////////
			  $query = "select * from member";

			 $res = mysqli_query($conn, $query);
			 if (!$res) {
			 	mysqli_query("rollback",$conn);
    			  die('Query Error : ' . mysqli_error());
			  }
			else{mysqli_query("commit",$conn);}
			 ?>

    			<table class="table" id="font_color">
    		    <thead>
    		    <tr>
    	       <th>No.</th>
        	    <th>Name</th>
        	    <th>ID</th>
        	    <th>Phone Number</th>
        	    <th>Type</th>
        		</tr>
               </thead>
    	 	 <tbody>
        		<?
        		$row_index = 1;
        			while ($row = mysqli_fetch_array($res)) {
            		echo "<tr>";
            		echo "<td>{$row_index}</td>";
            		echo "<td><a href='member_view.php?member_id={$row['member_id']}'>{$row['name']}</a></td>";
                    echo "<td>{$row['member_id']}</td>";
                    echo "<td>{$row['phone']}</td>";
                     if($row['admin']==1){
                     	$ad="administrator";
                     }
                     else{
                     	$ad="general";
                     }
                     echo "<td>{$ad}</td>";

            		if($_COOKIE[cookie_admin]==1){

        			 echo "<td width='17%'>
                	  <a href='member_delete.php?member_id={$row['member_id']}'><button class='btn-primary'>삭제</button>
                		</td>";}
            		echo "</tr>";
        			 $row_index++;
        			}
        		?>
        	</tbody>
    	</table>

			</div>
		</div>


	</div>



<? include("footer.php") ?>
