<?
include "header.php";
include "config.php"; //데이터베이스 연결 설정파일
include "util.php"; //유틸 함수


$conn = dbconnect($host, $dbid, $dbpass, $dbname);
/////보여주기 위해 select. dirty read만 막는다.
mysqli_query("set autocommit=0",$conn);
mysqli_query("set session transaction isolation level read committed",$conn);
mysqli_query("begin",$conn);
////////////////////////
$mode = "Adding";
$action = "menu_insert.php";
if (array_key_exists("menu_id", $_GET)) {
$menu_id = $_GET["menu_id"];
$query = "select * from menu where m_id = $menu_id";
$res = mysqli_query($conn, $query);
if(!$res){
	 mysqli_query("rollback",$conn);
 die('Query Error : ' . mysqli_error());
}

$menu = mysqli_fetch_array($res);
if(!$menu) {
msg("메뉴가 존재하지 않습니다.");
}
$mode = "Modifying";
$action = "menu_modify.php";
}
$shefs = array();
$query = "select * from chef";
$res = mysqli_query($conn, $query);
if(!$res){
	 mysqli_query("rollback",$conn);
 die('Query Error : ' . mysqli_error());
}

while($row = mysqli_fetch_assoc($res)) {
$shefs[$row['c_id']] = $row['chef_name'];}

$course = array();
$query_2 = "select * from course";
$res_2 = mysqli_query($conn, $query_2);
if(!$res_2){
	 mysqli_query("rollback",$conn);
 die('Query Error : ' . mysqli_error());
}
while($row_2 = mysqli_fetch_assoc($res_2)) {
$course[$row_2['course_name']] = $row_2['course_name'];
}

$type = array();
$query_3 = "select * from menu_type";
$res_3 = mysqli_query($conn, $query_3);
if(!$res_3){
	 mysqli_query("rollback",$conn);
 die('Query Error : ' . mysqli_error());
}
else{
	mysqli_query("commit",$conn);
}
while($row_3 = mysqli_fetch_assoc($res_3)) {
$type[$row_3['t_id']] = $row_3['type_name'];}

?>
<div class="container">
	<div class="col-md-6">
		<form class="form-group" name="menu_form" action="<?=$action?>" method="post" class="fullwidth">
			<input type="hidden" name="m_id" value="<?=$menu['m_id']?>"/>
			<h2><em> Menu <?=$mode?></em></h3>
			<br></br>

				<label for="chef_id">Chef</label>
					<div class="color">
				<select name="chef_id" id="chef_id">
				<option value="-1">요리사를 선택해 주십시오.</option>
				<?
				foreach($shefs as $id => $name) {
				if($id == $menu['c_id']) {
				echo "<option value='{$id}' selected>{$name}</option>";
				} else {
				echo "<option value='{$id}'>{$name}</option>";
					}
				}
				?>
           </select>
           </div>

		<label for="course_name">Course</label>
			<div class="color">
			<select name="course_name" id="course_name">
			<option value="-1">코스를 선택해 주십시오.</option>
	<?
			foreach($course as $id => $name) {
			if($id == $menu['course_name']) {
			echo "<option value='{$id}' selected>{$name}</option>";
			} else {
			echo "<option value='{$id}'>{$name}</option>";
		}
		}
		?>
			</select>
			</div>


		<label for="type_id">Type</label>
			<div class="color">
		<select name="type_id" id="type_id">
		<option value="-1">타입을 선택해 주십시오.</option>
		<?
		foreach($type as $id => $name) {
		if($id == $menu['t_id']) {
		echo "<option value='{$id}' selected>{$name}</option>";
		} else {
			echo "<option value='{$id}'>{$name}</option>";
		}
		}
		?>
		</select>
			</div>
<p>
<label for="menu_name">Menu Name</label>
<br><input class="form-control2" type="text" placeholder="메뉴 이름 입력" id="menu_name" name="menu_name" value="<?=$menu['menu_name']?>"/></br>
</p>
<p>
<label for="menu_desc">Menu Description</label>
<br><textarea class="color" placeholder="메뉴 설명 입력" id="menu_desc" name="menu_desc" rows="5"><?=$menu['menu_desc']?></textarea></br>
</p>
<p> <label for="price">Price</label>
<br><input class="form-control2" type="number" placeholder="정수로 입력" id="price" name="price" value="<?=$menu['price']?>" /></br>
</p>
<p> <label for="ingredient">Main Ingredient</label>
<br><input class="form-control2" type="text" placeholder="메뉴 주재료 입력" id="ingredient" name="ingredient" value="<?=$menu['ingredient']?>"/></br>
</p>
<p align="center"><button class="button primary large" onclick="javascript:return validate();"><?=$mode?></button></p>
<script>
function validate() {
if(document.getElementById("chef_id").value == -1) {
alert ("요리사를 선택해 주십시오"); return false;
}
else if(document.getElementById("type_id").value == -1) {
alert ("타입을 선택해 주십시오"); return false;
}
else if(document.getElementById("course_name").value == -1) {
alert ("코스를 선택해 주십시오"); return false;
}
else if(document.getElementById("menu_name").value == "") {
alert ("메뉴명을 입력해 주십시오"); return false;
}
else if(document.getElementById("menu_desc").value == "") {
alert ("메뉴설명을 입력해 주십시오"); return false;
}
else if(document.getElementById("price").value == ""||document.getElementById("price").value <=0) {
alert ("가격을 제대로 입력해 주십시오"); return false;
}
else if(document.getElementById("ingredient").value == "") {
alert ("주재료를 입력해 주십시오"); return false;
}
return true;
}
</script>
</form>
</div>
</div>
<? include("footer.php") ?>
