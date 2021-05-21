<?php require_once("NavBar.php");?>
<style>

#rating	form {
width: 400px;
margin:auto;

}

#rating button {
border: 0;
background: transparent;
font-size: 1.5em;
margin: 0;
padding: 0;
float: right;
}

#rating button:hover,
#rating button:hover + button,
#rating button:hover + button + button,
#rating button:hover + button + button + button,
#rating button:hover + button + button + button + button {
color: #faa;
}

</style>
<?php
if(!isset($_GET['ID'])){
	echo '<script> location.replace("index.php")</script> ';
}
if(!isset($_SESSION['ID'])){
	echo '<script> location.replace("index.php")</script> ';
}
$ContractsObj = new Contracts();
$ContractsObj->InitialiseContract($_GET['ID']);

if(!in_array($_SESSION['ID'],$ContractsObj->RatingToken)){
	echo '<script> location.replace("index.php")</script> ';
}
if($ContractsObj->SellerUserID!=$_SESSION['ID'] && $ContractsObj->BuyerUserID!=$_SESSION['ID']){
	echo '<script> location.replace("index.php")</script> ';
}
if($ContractsObj->SellerUserID!=$_SESSION['ID']){
	$_SESSION['OtherUser'] = $ContractsObj->SellerUserID;
	$Type = "Buyer";
}
if($ContractsObj->BuyerUserID!=$_SESSION['ID']){
	$_SESSION['OtherUser'] = $ContractsObj->BuyerUserID;
	$Type = "Seller";
}

echo'<div id="rating"><form action="" method="POST" style="margin:auto;"><h2>Rate User:'.$_SESSION['OtherUser'].'</label></h2>';
echo'
	Rating:
		<input type="hidden" name="rating[post_id]" value="3">
		<button type="submit" id ="rate5" name="rating[rating]" value="5">&#9733;</button>
		<button type="submit" id ="rate4" name="rating[rating]" value="4">&#9733;</button>
		<button type="submit" id ="rate3" name="rating[rating]" value="3">&#9733;</button>
		<button type="submit" id ="rate2" name="rating[rating]" value="2">&#9733;</button>
		<button type="submit" id ="rate1" name="rating[rating]" value="1">&#9733;</button></br></br>
	Review:
		<input type="text" name="reviewtext" style="width:1000px;height:100px;" placeholder="Review User"></br></br>';


if($Type=="Buyer"){
	echo'<h2>Review Product:'.$ContractsObj->ProductID.'</label></h2>';
	echo'<input type="text" name="reviewtextproduct" style="width:1000px;height:100px;" placeholder="Review Product"></br></br>';
	
}
echo'<input type="submit" name="submit" value="Submit review">
</form></div>';
if(isset($_POST['rating'])){
	if(isset($_POST['rating']['rating'])){
	for($x=1;$x<$_POST['rating']['rating']+1;$x++){

		echo '<style>#rate'.$x.'{color: #faa;}</style>';
	}
	$_SESSION['Rating'] =$_POST['rating']['rating'];
}
else{
$_POST['rating']['rating'] = 3;
$_SESSION['Rating'] = 3;
}	
	
}


if(isset($_POST['submit'])){
	if($Type=="Buyer"){
		$_SESSION['Object']->PostContractRateBuyer($_SESSION['Rating'],$_SESSION['OtherUser'],$_POST['reviewtext'],$_POST['reviewtextproduct'],$ContractsObj->ProductID);
	}
	if($Type=="Seller"){
			$_SESSION['Object']->PostContractRateSeller($_SESSION['Rating'],$_SESSION['OtherUser'],$_POST['reviewtext']);
	}
	unset($_SESSION['OtherUser']);
	unset($_SESSION['Rating']);
	$ContractsObj->ReduceToken($_SESSION['ID']);
	echo '<script>alert("Successfully submitted review")</script> ';
	echo '<script>location.replace("MyContractsPage.php")</script> ';
	
}
require_once("Footer.php");
?>