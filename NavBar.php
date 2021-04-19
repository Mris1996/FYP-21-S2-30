
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


.dropdown-content {
  display: none;
  position: absolute;

  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #ddd;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {background-color: #3e8e41;}

</style>
</head>
<div class="topnavbg">
	<nav class="navbar">
		<form method="post">
		<input type="submit" class="btn btn-white"  name="Nav_Main" id="Main"  value=""/>
		</form>
<?php 
if (!file_exists('Categories.txt')) 
{
	fopen("Categories.txt", "w");
}
$myfile = fopen("Categories.txt", "r") or die("Unable to open file!");
while(($line = fgets($myfile)) !== false) {
echo 
"<form method='post' action='".$line.".php'>
<input type='submit' class='btn btn-white' id='Main'  value='".$line."'/>
</form>";
}
fclose($myfile);








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

echo'<style> input[name="Nav_SignUp"]{display:none;}</style>';
echo'<style> input[name="Nav_Login"]{display:none;}</style>';
echo'<style> input[name="Nav_LogOut"]{display:visible;}</style>';
echo '<h2>STICOIN BALANCE: '.$_SESSION['Object']->AccountBalance.'</h2>';
echo'
<form method="post">
	<div class="dropdown">
	<button class="dropbtn"><h2>'.$_SESSION['ID'].'</h2></button>
	<div class="dropdown-content">
	<a href="#">Profile</a>
	<a href="#">Settings</a>
	<a href="Convert.php">Convert STICoins</a>
	<input type="submit" name="Nav_LogOut"  value="Log Out"/>
	</div>
</div>
</form>';
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
			
		</form>
</nav>
</div>
