<?php require_once("NavBar.php");?>

<style>
#confirmation{
	
	position:fixed;
    padding:0;
    margin:auto;
    top:0;
    left:0;

    width: 100%;
    height: 100%;
    background:rgba(255,255,255,0.8);
}
#confirmationtext{
	width:200px;
    margin:auto;
	margin-top:20%;
   
}
</style>
<?php

$ProductID = $_GET['ID'] ;
$BaseUserOBJ = new BaseUser("View Product");	
$ProductObj = new Products();

if(!$ProductObj->InitialiseProduct($ProductID)){
	echo '<script> location.replace("index.php")</script> ';
}
echo'
<div class="ProductPage" >
<div class="buttons">';



if(isset($_SESSION['ID'])){
$Owner = $_SESSION['Object']->getProductOwner($ProductID);
if($ProductObj->Reported>0 && $_SESSION['Object']->getAccountType()=="Administrator"&& $_SESSION['ID'] != $Owner ){
	echo'
<form method="post">
<input type="submit" name="Unreport" value="Unreport">
</form>';
}
if($ProductObj->Reported==0&& $_SESSION['Object']->getAccountType()!="Administrator" && $_SESSION['ID'] != $Owner ){
echo'
<form method="post">
<input type="submit" name="Report" value="Report">
</form>';	
}
if($_SESSION['ID'] == $Owner || $_SESSION['Object']->getAccountType()=="Administrator"){

echo'
<form method="post" action="EditProductPage.php?ID='.$ProductID.'">
<input type="submit" name="Edit" value="Edit">
</form>
<form method="post">
<input type="submit" name="Remove" value="Remove">
</form>';
if($ProductObj->Status=="Available"){
echo'
<form method="post">
<input type="submit" name="Unlist" value="Unlist">
</form>';
}
}
else{
if($ProductObj->Status=="Available"){
echo'
<form method="post" >
<input type="submit" name="SendOffer" value="Send Offer">
</form>';
}
}
echo'<h1>Product Expiry:'.$ProductObj->DateOfExpiry.'</h1>';
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
<?php $BaseUserOBJ->viewReview($ProductID,"Product");
if(isset($_SESSION['ID'])){
if($_SESSION['ID'] != $Owner){
?>
<form method="post" style="text-align:center;">
<input type="text" name="reviewtext" style="width:1000px;height:100px;" placeholder="Review Product">
<input type="hidden" name="reviewtextsubmit">
</form>
</div>
</div>
</div>
<?php
}
}
if(isset($_POST['reviewtextsubmit'])){
	
	$_SESSION['Object']->addNewReview($_POST['reviewtext'],$ProductID);
	echo'<script>history.pushState({}, "", "")</script>';
	echo '<script> location.reload()</script> ';
	exit();	
}
if(isset($_POST['Remove'])){
	

	echo'
	<form method="post" >
	<div id="confirmation">
	<div id="confirmationtext">
	<b>Are you sure you want to remove this product?</b></br>
		<input type="submit" name="Confirmation" value="Yes">
		<input type="submit" name="Confirmation" value="No">
	</form>
	</div>
	</div>
	';
	
}
if(isset($_POST['Report'])){
	

	echo'
	<form method="post" >
	<div id="confirmation">
	<div id="confirmationtext">
	<b>Are you sure you want to report this product?</b></br>
		<input type="submit" name="Confirmationreport" value="Yes">
		<input type="submit" name="Confirmationreport" value="No">
	</form>
	</div>
	</div>
	';
	
}
if(isset($_POST['Unreport'])){
	

	echo'
	<form method="post" >
	<div id="confirmation">
	<div id="confirmationtext">
	<b>Are you sure you want to unreport this product?</b></br>
		<input type="submit" name="Confirmationunreport" value="Yes">
		<input type="submit" name="Confirmationunreport" value="No">
	</form>
	</div>
	</div>
	';
	
}
if(isset($_POST['Unlist'])){


	echo'
	<form method="post" >
	<div id="confirmation">
	<div id="confirmationtext">
	<b>Are you sure you want to unlist this product?</b></br>
		<input type="submit" name="ConfirmationUnlist" value="Yes">
		<input type="submit" name="ConfirmationUnlist" value="No">
	</form>
	</div>
	</div>
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
if(isset($_POST['Confirmationreport'])&& $_POST['Confirmationreport']=="No"){
exit();
header("Refresh:0");
}
if(isset($_POST['Confirmationreport'])&&$_POST['Confirmationreport']=="Yes"){

$_SESSION['Object']->ReportProduct($ProductID);
echo '<script> alert("Thank you for your vigilance,rest assured, the administrators will look into the matter");</script> ';		
echo '<script> location.replace("index.php")</script> ';	

}
if(isset($_POST['Confirmationunreport'])&& $_POST['Confirmationunreport']=="No"){
exit();
header("Refresh:0");
}
if(isset($_POST['Confirmationunreport'])&&$_POST['Confirmationunreport']=="Yes"){
$_SESSION['Object']->UnreportProduct($ProductID);
echo '<script> alert("Product unreported");</script> ';
echo '<script> location.replace("index.php")</script> ';		
}
if(isset($_POST['ConfirmationUnlist'])&& $_POST['ConfirmationUnlist']=="No"){
exit();
header("Refresh:0");
}
if(isset($_POST['ConfirmationUnlist'])&&$_POST['ConfirmationUnlist']=="Yes"){
$_SESSION['Object']->UnlistProduct($ProductID);
exit();
header("Refresh:0");	
}
if(isset($_POST['SendOffer'])){
$_SESSION['Temp_Product']=$_GET['ID'];
echo '<script> location.replace("OfferPage.php")</script> ';	

}
if(isset($_SESSION['Object'])){
$Owner = $_SESSION['Object']->getProductOwner($ProductID);
if($_SESSION['ID']!=$Owner){
$TagArray = array();
$split = preg_split("/[^\w]*([\s]+[^\w]*|$)/", $ProductObj->ProductName, -1, PREG_SPLIT_NO_EMPTY);
$TagArray = array_merge($split,$TagArray);
array_push($TagArray,$ProductObj->ProductCategory);
$split = preg_split("/[^\w]*([\s]+[^\w]*|$)/", $ProductObj->ProductCaption, -1, PREG_SPLIT_NO_EMPTY);
$TagArray = array_merge($split,$TagArray);
$TagArray = array_unique($TagArray);
foreach ($TagArray as $Val){
	
	$_SESSION['Object']->AddUserTags($Val);
}
}
}
?>
<?php require_once("Footer.php");?> 