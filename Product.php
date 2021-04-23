<?php require_once("NavBar.php");
$ProductID = $_GET['ID'] ;

if(isset($_SESSION['ID'])){

echo'
<div class="chatbtn">
<form method="post">
<input type="submit" value="Chat">
</form></div>';


}
$BaseUserOBJ = new BaseUser("View Product");	
$BaseUserOBJ->ViewProduct($ProductID);


?>
<p></p></br>
<style>
.chatbtn{
	width:100px;
	margin:auto;
	margin-top:50px;
}
.chatbtn input{
	width:90px;
	
}
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 1000PX;
  margin-bottom:10px;
  margin: auto;

  color:white;
  font-size: 20px;
   background-color: black;
   opacity:0.9;
}

.price {
  color: grey;
  font-size: 22px;
}

.card input[type="submit"] {
  padding: 12px;
  color: black;
  background-color: white;
  text-align: center;
  cursor: pointer;
  width: 100%;
  font-size: 20px;
}

.card input:hover {
  transform: scale(1);
}

</style>

