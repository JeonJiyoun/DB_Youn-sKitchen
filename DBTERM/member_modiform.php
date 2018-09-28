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
if (array_key_exists("member_id", $_GET)) {
    $member_id = $_GET["member_id"];
    $query = "select * from member where member_id = '$member_id'";
    $res = mysqli_query($conn, $query);
    if(!$res){
     mysqli_query("rollback",$conn);
 die('Query Error : ' . mysqli_error());
    }
    else{
    mysqli_query("commit",$conn);
    }
    $member = mysqli_fetch_array($res);
    if(!$member) {
        msg("존재하지 않는 회원입니다.");
    }
    $mode = "Modifying";
    $action = "member_modify.php";
}


?>
<div class="container">
   <div class="col-md-6">
        <form class="form-group" name="member_form" action="<?=$action?>" method="post" class="fullwidth">
            <input type="hidden" name="member_id" value="<?=$member['member_id']?>"/>
            <h2><em>Chef Information <?=$mode?></em></h2>
            <br></br>
            <div class="form-goup">
                <label for="phone">ID (cannot modify)</label>
				<br><input class="form-control2" readonly type="text" id="id" name="id" value="<?=$member['member_id']?>"/></br>
			</div>
            <div class="form-group">
                <label for="name">Name</label>
                <br><input class="form-control2" type="text" id="name" name="name" value="<?=$member['name']?>"/></br>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
				<br><input class="form-control2" type="text" id="phone" name="phone" value="<?=$member['phone']?>"/></br>
			</div>
            <div class="form-group">
                <label for="password">Password</label>
                <br><input class="form-control2" type="password" id="pass" name="pass" value="<?=$member['password']?>"/></br>
            </div>
            <div class="form-group">
                <label for="password">Password Check</label>
                <br><input class="form-control2" type="password" placeholder="다시한번입력해주세요" id="c_pass" name="c_pass"/></br>
            </div>


            <div align="right"><button class="brn btn-primary" onclick="javascript:return validate();"><?=$mode?></button></div>

            <script>
                function validate() {
                    if(document.getElementById("name").value == "") {
                        alert ("이름을 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("phone").value == "") {
                        alert ("번호를 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("pass").value == "") {
                        alert ("비밀번호를 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("c_pass").value == "") {
                        alert ("비밀번호확인을 입력해 주십시오"); return false;
                    }
                    return true;
                }
            </script>

        </form>
    </div>
    </div>
<? include("footer.php") ?>
