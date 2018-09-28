<!DOCTYPE html>
<html lang='ko'>
<head>
    <title>Youn's Kitchen</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Free HTML5 Template by FREEHTML5.CO" />
	<meta name="keywords" content="free html5, free template, free bootstrap, html5, css3, mobile first, responsive" />
	<meta name="author" content="FREEHTML5.CO" />


  	<!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link rel="shortcut icon" href="favicon.ico">

	<link href='https://fonts.googleapis.com/css?family=Playfair+Display:400,700,400italic,700italic|Merriweather:300,400italic,300italic,400,700italic' rel='stylesheet' type='text/css'>

	<!-- Animate.css -->
	<link rel="stylesheet" href="css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="css/icomoon.css">
	<!-- Simple Line Icons -->
	<link rel="stylesheet" href="css/simple-line-icons.css">
	<!-- Datetimepicker -->
	<link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">
	<!-- Flexslider -->
	<link rel="stylesheet" href="css/flexslider.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="css/bootstrap.css">

	<link rel="stylesheet" href="css/style.css">


	<!-- Modernizr JS -->
	<script src="js/modernizr-2.6.2.min.js"></script>


    </head>


<body>

<form action="menu_list.php" method="post">
    <div class='nino-navbar fixed'>
        <div class='container'>
            <a class='pull-left title' href="index.php">Youn's Kitchen</a>
            <ul class='nav navbar-nav pull-right'>

                <li class="color_white"><a href='menu_list.php?'>MENU</a></li>
                <li><a href='chef_list.php?'>CHEF</a></li>
                <?php
                  if(!$_COOKIE[cookie_id]||!$_COOKIE[cookie_name]){
                  	echo "<li><a href='login.php'>Log In</a></li>";
                  }
                  else{
                  	if($_COOKIE[cookie_admin]==0){//일반 회원
                  		echo "<li><a href='logout.php'> [$_COOKIE[cookie_name]] Log Out</a><li>";
                  	}
                  	else{//관리자=나
                  		echo"<li><a href='menu_form.php'>ADD MENU</a></li>";
                  		echo"<li><a href='chef_form.php'>ADD CHEF</a></li>";
                  		echo"<li><a href='member_list.php'>MEMBER</a></li>";
                  		echo"<li><a href='logout.php'>[Admin] Log Out</a></li>";
                  	}
                    $member_id=$_COOKIE[cookie_id];
                  	echo"<li><a href='member_view.php?member_id={$member_id}'>My kitchen</a></li>";
                  }
                  ?>
                   <li><input type="text" class="color" name="search_keyword" placeholder="Menu Search"><span class="icon icon-search"></span></li>


            </ul>
        </div>
    </div>
</form>
