
<html lang="en">
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<style>

 .navbar{
	  background-color: purple;
	height:100px;
	color:black;
	font-size:30px;
	border-radius:10px;
	
}
.dropdown{
	width:500px;
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
  
}
.dropdown-content a {
  width:60%;
  margin:auto;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  background-color:white;
   
}
 .dropdown-content{
	width:300px;
	 margin-right:200px;
}
.dropbtn{
margin-left:100px;
border-color: purple;
border-style: solid;
width:80px;
height:80px;
border-radius: 50%;
}
.dropbtn2{
margin-left:100px;
width:80px;
height:80px;
}
.dropdown-content a:hover {background-color: #ddd;}

.dropdown:hover .dropdown-content {display: block;}

 .dropdown:hover .dropbtn {background-color: #3e8e41;}
 .SearchBar{

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
 input[type="submit"]:hover{
	cursor:pointer;
}
#caticons:hover{
	
   outline:60%;
    filter: drop-shadow(0 0 6px white);
  
	
}

#homebtn:hover{
   outline:60%;
    filter: drop-shadow(0 0 5px purple);
 
}
.input-group{
	width:100%;
	margin-top:20px;
}
.close {
  cursor: pointer;
  position: absolute;
  color:white;
  top: 25%;
  right: 0%;
  padding: 12px 16px;
  transform: translate(0%, -10%);
}
#notifications{
	 max-height:250px;
    overflow:auto;
	overflow-x: hidden;
}
#notifications::-webkit-scrollbar {
    width: 0.2em;

}
 
#notifications:-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
}
 
#notifications::-webkit-scrollbar-thumb {
  background-color: black;
  outline: 1px solid black;
  
}
</style>
<script>
//webportconfig = 'ws://8.tcp.ngrok.io:10810';
webportconfig = 'ws://localhost:3030';
window.WebSocket = window.WebSocket || window.MozWebSocket;
function deletenotification(ID){
	alert(ID);
var ajax = new XMLHttpRequest();
ajax.open("POST", "RealTimeNotification.php", true);
ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
ajax.send("Delete="+ID);
}
</script>
</head>
<div class="topnavbg">
	<nav class="navbar">
	
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
 if (!file_exists('Categories.txt')) 
{
	fopen("Categories.txt", "w");
}
$myfile = fopen("Categories.txt", "r") or die("Unable to open file!");
while(($line = fgets($myfile)) !== false) {
$arr = explode(":",$line);
//$arr[0] ->name
//$arr[1] ->file location
echo'<a id="caticons" href="CategoryPage.php?Category='.$arr[0].'">
<img src="'.$arr[1].'" title="'.$arr[0].'"; width="80" height="80">
</a>';
}
fclose($myfile);
if(isset($_SESSION['ID'])){

echo'<style> input[name="Nav_SignUp"]{display:none;}</style>';
echo'<style> input[name="Nav_Login"]{display:none;}</style>';
echo'<style> input[name="Nav_LogOut"]{display:visible;}</style>';
 echo '<input type="hidden" id="User" value="'.$_SESSION['Object']->getUID().'">'; 
 echo '<input type="hidden" id="PubKey" value="'.$_SESSION['Object']->getPubKey().'">'; 
}
echo'
</nav>

<div class="input-group">
<a href="index.php">
<img src="systemimages/CompanyLogo.jpg" id="homebtn" style="border-radius:20px;margin-left:10px;"  width="150" height="70">
</a>

<div class="SearchBar">
	<form  method="post">
		<input type="text"   aria-label="Search" id="SearchBar" style="width:500px;height:50px;background:white;opacity:0.9; border-radius:5px;color:black" name="SearchBar" placeholder="Search">
	<input type="hidden" name="searchfunction" value="">
	</form>
</div>';

if(isset($_SESSION['ID'])){
echo'
<div class="dropdown">
	<img class="dropbtn2" src="systemimages/Notification.png" height="80" width="80">
	<div id="notifications" class="dropdown-content">';
	$NotificationArr = $_SESSION['Object']->getNotification();
	sort($NotificationArr);
	foreach($NotificationArr as $val){
		
		$NotificationMessageArr = $_SESSION['Object']->getNotificationMessage($val);
		 echo '<a  id="'.$val.'" style="background-color:purple;color:white;width:300px" onclick="deletenotification(this.id)" href="'.$NotificationMessageArr['hreflink'].'">'.$NotificationMessageArr['msg'].'</a>';
	}
	if(empty($NotificationArr)){
		
		 echo '<a id="nonotification" style="background-color:purple;color:white;width:300px">You have no notification</a>';
	}
	
	echo'
	</div>
	</div>';
	
echo'
<form method="post">
	<div class="dropdown">
	<img class="dropbtn" src="'.$_SESSION['Object']->ProfilePic.'" height="80" width="80">
	<div class="dropdown-content">
	<a>Hello, '.$_SESSION['ID'].'</a>
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

echo '<a style="background-color:purple;color:white" id="Account_Balance">Please wait for balance</a>';
?>
<script>


Currency = "SGD$";

var ajax = new XMLHttpRequest();
ajax.open("POST", "RealTimeBalance.php", true);
ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
ajax.send("UpdateBalance=1");

setInterval(function() {
var ajax = new XMLHttpRequest();
	ajax.open("POST", "RealTimeBalance.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send();
	}, 100000);

var connection =  new WebSocket(webportconfig);

connection.onmessage = function (message) {
	var data = message.data;
	data = JSON.parse(data);
	console.log(data);

	if(data.PubKey==document.getElementById("PubKey").value){
		if(data.Balance!=undefined){
			document.getElementById("Account_Balance").innerHTML = "Balance"+"</br>"+Currency+data.Balance.toFixed(2);
			ajax.open("POST", "RealTimeBalance.php", true);
			ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			ajax.send("ServerBalance=" + data.Balance);
		}
	
		
	}
	if(data.NotificationUserID!=undefined){
	  if(data.NotificationUserID==document.getElementById("User").value){
		  
			var newnotification = document.createElement("a");
			newnotification.innerHTML = data.NotificationMessage;  
			newnotification.href = data.NotificationHyperlink;  
			newnotification.id = data.NotificationID;  
			newnotification.onclick = deletenotification(newnotification.id);
			newnotification.style = "background-color:purple;color:white;width:300px";
			document.getElementById("notifications").appendChild(newnotification);  

		}
		if(document.getElementById("nonotification")!=undefined){
			document.getElementById("nonotification").remove();
		}
	}
	
}

</script>
<?php
echo'
<a style="background-color:black" ><input type="submit" style="width:100%;height:100%"name="Nav_LogOut"  value="Log Out"/></a>
</div>
</div>
</form>
</div>
	<hr>
';


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

?>	

<form method="post">
	<input type="submit" class="btn btn-white"   name="Nav_Login"  value="Login"/>
	<input type="submit" class="btn btn-white"  name="Nav_SignUp"  value="SignUp"/>		
</form>



</div>
</div>
