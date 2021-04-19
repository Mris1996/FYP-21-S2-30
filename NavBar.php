
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Architects+Daughter&display=swap" rel="stylesheet">

<style>

.navbar{
	background-color:grey;
	height:100px;
	color:black;
	font-size:30px;
	margin-bottom:100px;
}


</style>
<div class="topnavbg">
	<nav class="navbar">
		<form method="post">
		<input type="submit" class="btn btn-white"  style="background: url(SystemImages/Logo.png) no-repeat center;height:70px;width:350px;background-size: 350px 100px;border:none;"name="Nav_Main" id="Main"  value=""/>
		</form>
	
		
		



</head>
<?php
date_default_timezone_set("Singapore");
require_once("Users.php");
session_start();
if(isset($_POST['Nav_Main'])){
header("Location:index.php");
exit;
}
if(isset($_POST['Nav_Login'])){
header("Location:LoginPage.php");
exit;
}
if(isset($_POST['Nav_SignUp'])){
header("Location:SignUpPage.php");
exit;
}

if(isset($_SESSION['ID'])){
echo'<h2>Hello '.$_SESSION['ID'].'</h2>

<form action="Profile.php" method="post">
	<input type="submit" style="background: url(SystemImages/ProfileIcon.png) no-repeat center;width:90px; height:90px; background-size: 90px 90px; cursor: pointer;border:none;" value="" title ="Profile Page"/>
</form>';
echo'<style> input[name="Nav_SignUp"]{display:none;}</style>';
echo'<style> input[name="Nav_Login"]{display:none;}</style>';
echo'<style> input[name="Nav_LogOut"]{display:visible;}</style>';
echo '<h2>STICOIN BALANCE: '.$_SESSION['Object']->AccountBalance.'</h2>';
}
else{
	echo'<style> input[name="Nav_LogOut"]{display:none;}</style>';
}
if(isset($_POST['Nav_LogOut'])){
echo'<style> input[name="Nav_Login"]{display:visible;}</style>';
$_SESSION['ID']=NULL;
session_destroy();
echo '<script> location.replace("index.php")</script> ';
exit();
}

?>	
<form method="post">
			<input type="submit" class="btn btn-white"   name="Nav_Login"  value="Login"/>
			<input type="submit" class="btn btn-white"  name="Nav_SignUp"  value="SignUp"/>
			<input type="submit" class="btn btn-white"    name="Nav_LogOut"  value="Log Out"/>
		</form>
</nav>
</div>
