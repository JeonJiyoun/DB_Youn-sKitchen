<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
///읽어와서 보여주기만 하므로 dirty read만 막는다.
 mysqli_query("set autocommit=0",$conn);
 mysqli_query("set session transaction isolation level read committed",$conn);
 mysqli_query("begin",$conn);
 //////////////////
if (array_key_exists("course_name", $_GET)) {
    $course_name = $_GET["course_name"];
    $query = "select * from menu natural join menu_type natural join course where course_name = '$course_name'";
    $res = mysqli_query($conn, $query);
    if(!$res){mysqli_query("rollback",$conn);
    die('Query Error : ' . mysqli_error());}
    else{mysqli_query("commit",$conn);}
    $menu = mysqli_fetch_assoc($res);
    if (!$menu) {
        msg("메뉴가 존재하지 않습니다.");
    }
}
?>
    <div class="container">

        <h2>Course <?=$course_name?> menus</h2>
        <br></br>
        <span>Price : <?=$menu['course_price']?>원</span>
        <table class="table">
        	<thead>
        	<th>No.</th>
        	<th>Menu</th>
        	<th>Type</th>
        	</thead>
        	<tbody>
       	<?
       	  $ret = mysqli_query($conn, $query);
        $row_index = 1;
        	while ($row = mysqli_fetch_array($ret)) {
            	echo "<tr>";
            	echo "<td>{$row_index}</td>";
            	echo "<td><a href='menu_view.php?menu_id={$row['m_id']}'</a>{$row['menu_name']}</td>";
                echo "<td>{$row['type_name']}</td>";
                echo "</tr>";
        			 $row_index++;
        			}
        		?>
            </tbody>
        </table>

    </div>
<? include("footer.php") ?>
