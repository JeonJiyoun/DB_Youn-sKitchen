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
if (array_key_exists("menu_id", $_GET)) {
    $menu_id = $_GET["menu_id"];
    $query = "select * from menu natural join chef natural join course natural join menu_type where m_id = $menu_id";
    $res = mysqli_query($conn, $query);
    if(!$res){
    	mysqli_query("rollback",$conn);
    	die('Query Error : ' . mysqli_error());
    }
    else{
    mysqli_query("commit",$conn);

    }
    $menu = mysqli_fetch_assoc($res);
    if (!$menu) {
        msg("메뉴가 존재하지 않습니다.");
    }
}
?>
    <div class="container">

        <h2>Menu Details</h2>
        <br></br>
        <p class="form-group">
            <label for="menu_id">Menu Code</label>
            <input class="form-control" readonly type="text" id="menu_id" name="menu_id" value="<?= $menu['m_id'] ?>"/>
        </p>

        <p class="form-group">
            <label for="menu_name">Menu Name</label>
            <input class="form-control" readonly type="text" id="menu_name" name="menu_name" value="<?= $menu['menu_name'] ?>"/>
        </p>
        <p class="form-group">
            <label for="chef">Chef</label>
            <input class="form-control" readonly type="text" id="chef" name="chef" value="<?= $menu['chef_name'] ?>"/>
            <?
            $chef=$menu['c_id'];
            echo"<a href='chef_view.php?chef_id={$chef}'><button class='brn btn'>상세보기</button></a>";
            ?>
        </p>
        <p class="form-group">
            <label for="type">Type</label>
            <input class="form-control" readonly type="text" id="type" name="type" value="<?= $menu['type_name'] ?>"/>

        </p>
        <p class="form-group">
            <label for="ingredient">Main Ingredient</label>
            <input class="form-control" readonly type="text" id="ingredient" name="ingredient" value="<?= $menu['ingredient'] ?>"/>
        </p>

        <p class="form-group">
            <label for="course">Course</label>
            <input class="form-control" readonly type="text" id="course" name="course" value="<?= $menu['course_name'] ?>"/>
             <?
            $course=$menu['course_name'];
            echo"<a href='course_view.php?course_name={$course}'><button class='brn btn'>상세보기</button></a>";
            ?>
        </p>
        <p class="form-group">
            <label for="price">Price</label>
            <input class="form-control" readonly type="number" id="price" name="price" value="<?= $menu['price'] ?>"/>
        </p>
        <p class="form-group">
            <label for="menu_desc">Menu Description</label>
            <textarea class="form-control" readonly id="menu_desc" name="menu_desc" rows="10"><?= $menu['menu_desc'] ?></textarea>
        </p>


    </div>
<? include("footer.php") ?>
