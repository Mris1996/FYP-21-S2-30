<?php require_once("NavBar.php");?>

<style>

</style>
<?php

$ProductID = $_GET['ID'] ;
$BaseUserOBJ = new BaseUser("View Product");	
$ProductObj = new Products();

if(!$ProductObj->InitialiseProduct($ProductID)){
	echo '<script> location.replace("index.php")</script> ';
}
if(isset($_SESSION['ID'])){
$Owner = $_SESSION['Object']->getProductOwner($ProductID);
echo'
<div class="ProductPage" >
<div class="buttons">
<form method="post" >
<input type="submit" name="SendOffer" value="Send Offer">
</form>';

if($_SESSION['ID'] == $Owner){

echo'
<form method="post" action="EditProductPage.php?ID='.$ProductID.'">
<input type="submit" name="Edit" value="Edit">
</form>
<form method="post">
<input type="submit" name="Remove" value="Remove">
</form>';

}
}


echo'
<div class="card">
<img src="'.$ProductObj->Image.'" style="width:50%;margin:auto">
<h2 style="text-align:center">'.$ProductObj->ProductID.'</h2>
<hr style="background-color:white">
<p>Seller:<a href="ProfilePage.php?ID='.$ProductObj->SellerUserID.'">'.$BaseUserOBJ->getUserDisplayName($ProductObj->SellerUserID).'</a></p>
<p>Name: '.$ProductObj->ProductName.'</p>
<p>Category: '.$ProductObj->ProductCategory.'</p>
<p>Status: '.$ProductObj->Status.'</p>
<hr style="background-color:white">
<p style="text-align:center">'.$ProductObj->ProductCaption.'</p>
<p style="text-align:center">Description:'.$ProductObj->ProductDescription.'</p><hr>
<h2 style="text-align:center">Initital Cost: '.$ProductObj->ProductInitialPrice.'</h2></div>';



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
if(isset($_POST['Confirmation'])&&$_POST['Confirmation']=="Yes"){

$_SESSION['Object']->RemoveProduct($ProductID);
echo '<script> location.replace("index.php")</script> ';		
}
if(isset($_POST['SendOffer'])){
$_SESSION['Temp_Product']=$_GET['ID'];
echo '<script> location.replace("OfferPage.php")</script> ';	

}
?>
<?php require_once("Footer.php");?> 