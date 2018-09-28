<?
include "header.php";
include "config.php";
include "util.php";


$conn=dbconnect($host,$dbid,$dbpass,$dbname);
///읽어와서 보여주기만 하므로 dirty read만 막는다.
 mysqli_query("set autocommit=0",$conn);
 mysqli_query("set session transaction isolation level read committed",$conn);
 mysqli_query("begin",$conn);
 //////////////////

if (array_key_exists("chef_id", $_GET)) {
    $chef_id = $_GET["chef_id"];
    $query = "select * from chef where c_id = $chef_id";
    $query_2 = "select * from chef natural join menu where c_id = $chef_id";
    $res = mysqli_query($conn, $query);
    if(!$res){
       mysqli_query("rollback",$conn);
       die('Query Error : ' . mysqli_error());
    }
    else{


    $res_2 = mysqli_query($conn, $query_2);
     if(!$res){
       mysqli_query("rollback",$conn);
       die('Query Error : ' . mysqli_error());
    }

       mysqli_query("commit",$conn);
    }
    $chef = mysqli_fetch_assoc($res);
    $chef_2 = mysqli_fetch_assoc($res_2);

    if (!$chef) {
        msg("Chef가 존재하지 않습니다.");
    }

}?>
 <div class="container">

        <h2>Chef Details</h2>
        <br></br>
        <p class="form-group">
            <label for="chef_id">Chef Code</label>
            <input class="form-control" readonly type="text" id="chef_id" name="chef_id" value="<?= $chef['c_id'] ?>"/>
        </p>

        <p class="form-group">
            <label for="chef_name">Chef Name</label>
            <input class="form-control" readonly type="text" id="chef_name" name="chef_name" value="<?= $chef['chef_name'] ?>"/>
        </p>
       <p class="form-group">
            <label for="star">Star</label>
           <br>
            <? if($chef['star'] == 0){
            	echo "<span class='icon icon-star-empty'></span>";
            }
            else if($chef['star'] == 1){
            	echo "<span class ='icon icon-star'></span>";
            }
            else if($chef['star'] == 2){
            	echo "<span class ='icon icon-star'></span>";
            	echo "<span class ='icon icon-star'></span>";
            }
            else if($chef['star'] == 3){
            	echo "<span class ='icon icon-star'></span>";
            	echo "<span class ='icon icon-star'></span>";
            	echo "<span class ='icon icon-star'></span>";
            }
             else if($chef['star'] == 4){
            	echo "<span class ='icon icon-star'></span>";
            	echo "<span class ='icon icon-star'></span>";
            	echo "<span class ='icon icon-star'></span>";
            	echo "<span class ='icon icon-star'></span>";
            }
             else if($chef['star'] == 5){
            	echo "<span class ='icon icon-star'></span>";
            	echo "<span class ='icon icon-star'></span>";
            	echo "<span class ='icon icon-star'></span>";
            	echo "<span class ='icon icon-star'></span>";
            	echo "<span class ='icon icon-star'></span>";
            }?></br>

        </p>
       <p class="form-group">
           <label for="menu">Dish</label>
           <?if ($chef_2['menu_name']==""){
           	echo "<input class='form-control' readonly type='text' id='menu' name='menu' value='없음'";
           }?>
             <input class="form-control" readonly type="text" id="menu" name="menu" value="<?= $chef_2['menu_name']?><?
        	$row_index = 1;
        	 while ($row = mysqli_fetch_array($res_2)) {
            	 echo "& {$row['menu_name']}";
        			 $row_index++;
        			}
        		?>
        		"/>

       </p>
       <p class="form-group">
            <label for="career">Career</label>
            <input class="form-control"  readonly type="text" id="career" name="career" value="<?= $chef['career'] ?>"/>

        </p>

    </div>
<? include("footer.php") ?>
