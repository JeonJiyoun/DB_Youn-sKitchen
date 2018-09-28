<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>
	<div id="fh5co-container">

		<div id="fh5co-featured" data-section="features">
			<div class="container">
				<div class="row text-center fh5co-heading row-padded">
					<div class="col-md-8 col-md-offset-2">
						<h2 class="heading">Youn's Menu</h2>
						<p class="sub-heading">Our special dishes</p>
					</div>
				</div>
				<?
				 $conn = dbconnect($host, $dbid, $dbpass, $dbname);
				 ///읽어와서 보여주기만 하므로 dirty read만 막는다.
			 mysqli_query("set autocommit=0",$conn);
			mysqli_query("set session transaction isolation level read committed",$conn);
			mysqli_query("begin",$conn);
             //////////////////
				 $query = "select * from menu natural join chef natural join course natural join menu_type";
				 if (array_key_exists("search_keyword", $_POST)) {  // array_key_exists() : Checks if the specified key exists in the array
    				 $search_keyword = $_POST["search_keyword"];
    				 $query =  $query . " where menu_name like '%$search_keyword%' or chef_name like '%$search_keyword%' or course_name like '%$search_keyword%'";

					 }
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
        		  <th>MenuName</th>
        		  <th>Chef</th>
        		  <th>Course</th>
        		 <th>Type</th>
        		 <th>AddedDate</th>
    			 </tr>
    		 </thead>
    		 <tbody>
        		<?
    			 $row_index = 1;
    			 while ($row = mysqli_fetch_array($res)) {
    			   echo "<tr>";
        		   echo "<td>{$row_index}</td>";
        		   echo "<td><a href='menu_view.php?menu_id={$row['m_id']}'>{$row['menu_name']}</a></td>";
        		   echo "<td>{$row['chef_name']}</td>";
        		   echo "<td>{$row['course_name']}</td>";
        		   echo "<td>{$row['type_name']}</td>";
        		   echo "<td>{$row['added_datetime']}</td>";
        		   if($_COOKIE[cookie_admin]==1){
        		    echo "<td width='17%'>
                	<a href='menu_form.php?menu_id={$row['m_id']}'><button class='brn'>수정</button></a>
                	<button onclick='javascript:deleteConfirm({$row['m_id']})' class='btn-primary'>삭제</button>
                	</td>";}
            		echo "</tr>";
        			 $row_index++;
    					 }
        			?>
        		</tbody>
    	</table>

    	<script>
        function deleteConfirm(menu_id) {
            if (confirm("정말 삭제하시겠습니까?") == true){    //확인
                window.location = "menu_delete.php?m_id=" + menu_id;
            }else{   //취소
                return;
            }
        }
		</script>

			</div>
		</div>


	</div>


<? include("footer.php") ?>
