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
$mode = "Adding";
$action = "chef_insert.php";

if (array_key_exists("chef_id", $_GET)) {
    $chef_id = $_GET["chef_id"];
    $query =  "select * from chef where c_id = $chef_id";
    $res = mysqli_query($conn, $query);
    if(!$res){
    	mysqli_query("rollback",$conn);
    }
    else{
    	mysqli_query("commit",$conn);
    }
    $chef = mysqli_fetch_array($res);
    if(!$chef) {
        msg("존재하지 않는 요리사입니다.");
    }
    $mode = "Modifying";
    $action = "chef_modify.php";
}


?>
<div class="container">
   <div class="col-md-6">
        <form class="form-group" name="chef_form" action="<?=$action?>" method="post" class="fullwidth">
            <input type="hidden" name="chef_id" value="<?=$chef['c_id']?>"/>
            <h2><em>Chef Information <?=$mode?></em></h2>
            <br></br>
            <div class="form-group">
                <label for="chef_name">Name</label>
                <br><input class="form-control2" type="text" placeholder="요리사 이름 입력" id="chef_name" name="chef_name" value="<?=$chef['chef_name']?>"/></br>
            </div>
            <div class="form-group">
                <label for="star">Star</label>
				<br><input class="form-control2" type="number" placeholder="요리사 등급 입력(0~5)" id="star" name="star" value="<?=$chef['star']?>"/></br>
			</div>
            <div class="form-group">
                <label for="career">Career</label>
                <br><input class="form-control2" type="text" placeholder="요리사 경력 입력" id="career" name="career" value="<?=$chef['career']?>"/></br>
            </div>

            <div align="right"><button class="brn btn-primary" onclick="javascript:return validate();"><?=$mode?></button></div>

            <script>
                function validate() {
                    if(document.getElementById("chef_name").value == "") {
                        alert ("이름을 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("star").value == ""||document.getElementById("star").value <=0) {
                        alert ("등급을 제대로 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("career").value == "") {
                        alert ("경력을 입력해 주십시오"); return false;
                    }

                    return true;
                }
            </script>

        </form>
    </div>
    </div>

<?
mysqli_close($conn);
include("footer.php") ?>
