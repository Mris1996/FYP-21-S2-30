
<html lang="en">
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<style>

.navbar{
	background-color:grey;
	height:100px;
	color:black;
	font-size:30px;
	
}

.dropdown-content {
	width:100%;
  display: none;
  position: absolute;
  z-index: 1;
}
.dropdown-content input {
  width:100%;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  background-color:white;
   margin:auto;
}
.dropdown-content a {
  width:100%;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  background-color:white;
   margin:auto;
}
.dropbtn{
	width:300px;
	
}
.dropdown-content a:hover {background-color: #ddd;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {background-color: #3e8e41;}
.SearchBar{
	 display: block;
  width: 500px;
  margin: 10px auto;
  padding: 3px;
}
.pagination{
	clear: both;
    position: relative;
    height:10px;
    margin-top: 300px;
	width:0px;
	margin:auto;
	text-align:center;
}
.pagination a{
	
	margin-left:10px;
	
}
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
"<form method='post' action='CategoryPage.php?Category=".$line."'>
<input type='submit' class='btn btn-white' id='Main'  value='".$line."'/>
</form>";
}
fclose($myfile);








date_default_timezone_set("Singapore");
require_once("Users.php");
require_once("Products.php");
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
echo '<h2>STICOIN BALANCE: '.$_SESSION['Object']->GetAccountBalanceFromServer($_SESSION['Object']->getPubKey()).'</h2>';
echo'
<form action="ListPage.php">
<input type="submit" value="List a product"/>
</form>';
echo'
<form action="NegotiationsPage.php">
<input type="submit" value="Chats"/>
</form>';
echo'
<form method="post">
	<div class="dropdown">
	<button class="dropbtn"><h2>'.$_SESSION['ID'].'</h2></button>
	<div class="dropdown-content">
	<a href="ProfilePage.php?ID='.$_SESSION['ID'].'">Profile</a>
	<a href="SettingsPage.php">Settings</a>
	<a href="ConvertSCPage.php">Convert to STICoin</a>
	<a href="ConvertETHPage.php">Convert to ETH</a>
	<a href="ContractsPage.php">My Contracts</a>';
if($_SESSION['Object']->getAccountType()=="Administrator"){
	echo'<a href="AdministratorPage.php">Manage accounts</a>';
}
echo'
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


<div class="SearchBar">
	<form action="SearchPage.php" method="post">
		<input type="text"   aria-label="Search" id="SearchBar" style="width:500px;height:50px;background:white;opacity:0.9; border-radius:5px;color:black" name="SearchBar" placeholder="Search">
	<input type="hidden" name="searchfunction" value="">
	</form>
</div>
	<hr>
</div>
