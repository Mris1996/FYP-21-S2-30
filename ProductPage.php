<?php require_once("NavBar.php");?>

<style>
.buttons{
	width:100px;
	margin:auto;
	margin-top:50px;
}
.buttons input{
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
label,span{
	display:inline-block;
	width:200px;
	margin-right:5px;
	text-align:center;
}
</style>
<?php

$ProductID = $_GET['ID'] ;
$BaseUserOBJ = new BaseUser("View Product");	
if(isset($_SESSION['ID'])){

echo'
<div class="ProductPage">
<div class="buttons">
<form method="post">
<input type="submit" value="Chat">
</form>';

if($_SESSION['ID'] == $BaseUserOBJ->getProductOwner($ProductID)){
echo'
<form method="post" action="EditProductPage.php?ID='.$ProductID.'">
<input type="submit" name="Edit" value="Edit">
</form
<form method="post">
<input type="submit" name="Remove" value="Remove">
</form>';

}
}

echo '</form></div>';


$BaseUserOBJ->ViewProduct($ProductID);

?>

<div style="float:left;width:100%">
<hr>
<h1>Reviews</h1>
<?php $BaseUserOBJ->viewReview($ProductID,"Product");?>
</div>
</div>
<?php


if(isset($_POST['Remove'])){
	echo'<style> .ProductPage{display:none;}</style>';
	echo'
	<form method="post" >
	<b>Are you sure you want to remove this product?</b></br>
		<input type="submit" name="Confirmation" value="Yes">
		<input type="submit" name="Confirmation" value="No">
	</form>
	';
	
}

if(isset($_POST['Confirmation'])&& $_POST['Confirmation']=="No"){
exit();
header("Refresh:0");
}
if(isset($_POST['Confirmation'])&& $_POST['Confirmation']=="Cancel"){
exit();
header("Refresh:0");
}
if(isset($_POST['Confirmation'])&&$_POST['Confirmation']=="Yes"){

$_SESSION['Object']->RemoveProduct($ProductID);
echo '<script> location.replace("index.php")</script> ';		
}

?>