
<html lang="en">
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<style>

 .navbar{
	background-color:purple;
	height:120px;
	color:black;
	font-size:30px;
	border-radius:10px;
	
}

 .dropdown-content {
	width:100%;
  display: none;
  position: absolute;
  z-index: 1;
}
 .dropdown-content input not(#reload){
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
 .dropdown-content{
	width:300px;
	
}
 .dropbtn{
	margin-left:100px;
	border-radius: 50%;
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
 a:hover{
	border: 5px;
	outline: none;
	opacity:1;	
	transform: scale(1.1);
	cursor:pointer;
}

</style>

</head>
<div class="topnavbg">
	<nav class="navbar">
	<a href="index.php">
<img src="systemimages/CompanyLogo.jpg" style="border-radius:20px" width="80" height="80">
</a>	
<?php 
date_default_timezone_set("Singapore");
require_once("Users.php");
require_once("Products.php");
require_once("Contracts.php");
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

 echo '<input type="hidden" id="PubKey" value="'.$_SESSION['Object']->getPubKey().'">'; 
echo'
<form method="post">
	<div class="dropdown">
	<img class="dropbtn" src="'.$_SESSION['Object']->ProfilePic.'" height="80" width="80">
	<div class="dropdown-content">
	<a>'.$_SESSION['ID'].'</a>
	<a href="ProfilePage.php?ID='.$_SESSION['ID'].'">Profile</a>
	<a href="ListPage.php">List a product</a>
	<a href="MyContractsPage.php">My Contracts</a>
	<a href="MyTransactionsPage.php">My Transactions</a>
	<a href="SettingsPage.php">Settings</a>
	<a href="ConvertPage.php">Top-Up</a>';
if($_SESSION['Object']->getAccountType()=="Administrator"){
	echo'<a href="ReportManagementPage.php">Manage reports</a>';
	echo'<a href="EscrowManagementPage.php">Manage escrows</a>';
	echo'<a href="UserManagementPage.php">Manage accounts</a>';
	echo'<a href="ContractManagementPage.php">Manage contracts</a>';
}

echo '<a id="Account_Balance"></a>';
?>
<script>
var ajax = new XMLHttpRequest();
ajax.open("POST", "RealTimeBalance.php", true);
ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
ajax.send();
setInterval(function() {
var ajax = new XMLHttpRequest();
	ajax.open("POST", "RealTimeBalance.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send();
	}, 1000);
window.WebSocket = window.WebSocket || window.MozWebSocket;
var connection =  new WebSocket('ws://localhost:3030');
connection.onmessage = function (message) {
	var data = JSON.parse(message.data);
	if(data.PubKey==document.getElementById("PubKey").value){
		document.getElementById("Account_Balance").innerHTML = "Balance"+"</br>"+"SGD$"+data.Balance;
	}
}
</script>
<?php
echo'
	<input type="submit" name="Nav_LogOut"  value="Log Out"/>
	</div>
</div>
</form>';


$BaseUserOBJ = new BaseUser("check status");
$BaseUserOBJ->setUID_Admin($_SESSION["ID"]);
if(json_decode($BaseUserOBJ->Status)[0]=="Suspended"){
echo'<script>alert("You have been suspended till,'.json_decode($BaseUserOBJ->Status)[1].'")</script>';	
$_SESSION["Object"]->LogOut();
}
if(json_decode($BaseUserOBJ->Status)[0]=="Banned"){
echo'<script>alert("You have been banned")</script>';	
$_SESSION["Object"]->LogOut();
}
}
else{
	echo'<style> input[name="Nav_LogOut"]{display:none;}</style>';
}
if(isset($_POST['Nav_LogOut'])){
$_SESSION["Object"]->LogOut();
}
if(isset($_POST['Refresh'])){

$_SESSION["Object"]->UpdateBalance();
}

if(isset($_POST['searchfunction'])){
	echo '<script> location.replace("SearchPage.php?query='.$_POST['SearchBar'].'")</script> ';
}
if (!file_exists('Categories.txt')) 
{
	fopen("Categories.txt", "w");
}
$myfile = fopen("Categories.txt", "r") or die("Unable to open file!");
while(($line = fgets($myfile)) !== false) {
$arr = explode(":",$line);
//$arr[0] ->name
//$arr[1] ->file location
echo'<a href="CategoryPage.php?Category='.$arr[0].'">
<img src="'.$arr[1].'" title="'.$arr[0].'"; width="80" height="80">
</a>';
}
fclose($myfile);
?>	

<form method="post">
			<input type="submit" class="btn btn-white"   name="Nav_Login"  value="Login"/>
			<input type="submit" class="btn btn-white"  name="Nav_SignUp"  value="SignUp"/>		
		</form>
	</nav>


<div class="SearchBar">
	<form  method="post">
		<input type="text"   aria-label="Search" id="SearchBar" style="width:500px;height:50px;background:white;opacity:0.9; border-radius:5px;color:black" name="SearchBar" placeholder="Search">
	<input type="hidden" name="searchfunction" value="">
	</form>
</div>
	<hr>
</div>
