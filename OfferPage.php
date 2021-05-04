<?php require_once("NavBar.php");

if(!isset($_SESSION['ID'])){
	echo '<script> location.replace("index.php")</script> ';
}
$submit = true;
$ProductID = $_SESSION['Temp_Product'];
$DateRequiredError = $OfferError = "";
$Owner = $_SESSION['Object']->getProductOwner($ProductID);
$ProductObj = new Products();
$ProductObj->InitialiseProduct($ProductID);

if(isset($_POST['submit'])){


if (strlen(strtotime($_POST["DateRequired"]))<1){
	
	$DateRequiredError = "Date product is required by is required";	
	$submit = false;
}
else{
	if (strtotime($_POST["DateRequired"])<=strtotime('Today')){
		$DateRequiredError = "Invalid date, date should be after today ";	
		$submit = false;
	}
}



if (empty($_POST["Offer"])){
	$OfferError= "Offer is required";	
	$submit = false;
}


	
}
	

?>
<style>

label,span{
	display:inline-block;
	width:200px;
	margin-right:5px;
	text-align:center;
}
.Insert_GUI input[type="submit"]{
	font-size:30px;
	color:white;
	background-color:black;
}
span{
	color:red;
		width:200px;
}
hr{
	background-color:white;
}
input[type="text"]{
	font-family: arial;
	width:200px;
}
.Post_Insert_GUI{
	margin-left:auto;
	margin-right:auto;
	margin-bottom:20px;
	width:500px;
	height:300px;
	text-align:center;
	opacity:0.8;
	font-size:30px;

}
.ConfirmList_GUI{
	margin-left:auto;
	margin-right:auto;
	margin-bottom:20px;
	width:500px;
	height:300px;
	text-align:left;
	opacity:0.8;
	font-size:30px;
	
}
</style>
<div class="Offer_GUI">
<h1 style="font-size:70px"><center>Offer for <?php echo $ProductID;?></center></h1>	
    <form method="post" enctype="multipart/form-data">  
	
	<h2>Product Information</h2>
		<div style="width:1000px;margin:auto">
		<img src="<?php echo $ProductObj->Image;?>" style="width:50%;margin:auto"></br>
	
		<label>Product Name:</label><b><?php echo $ProductObj->ProductName;?></b></br>
		<label>Product Owner:</label><b><?php echo $_SESSION['Object']->getUserDisplayName($ProductObj->SellerUserID)?></b></br>
		<label>Product Caption:</label><b><?php echo $ProductObj->ProductCaption?></b></br>
		<label>Product Description:</label><b><?php echo $ProductObj->ProductDescription?></b></br>
		<label>Product Initial Price:</label><b><?php echo $ProductObj->ProductInitialPrice?></b></br>
		</div>
	<hr>
		<h2>Your Offer</h2>
		<label>Date product is required by:</label>
		<input type="date" name="DateRequired" >
		<span class="error">&nbsp;&nbsp;<?php echo $DateRequiredError;?></span><br /><br />
	
		
		<label>Offer(STICoins):</label>
		<input type="number" id="Offer" name="Offer" min="0.00" step="any">
		<span class="error"><?php echo $OfferError;?></span><br />
		<br />
		<label>Offer will be rounded up to whole number</label><br /><br />
		
		<input type="submit" name="submit" value="Submit">
    </form>
</div>

<?php
if(isset($_POST['submit'])&& $submit){
	
	
	echo'<style> .Offer_GUI{display:none;}</style>';
	
	$ContractID = $_SESSION['Object']->NewOffer($_POST["Offer"],$_POST["DateRequired"],$ProductObj->SellerUserID,$ProductObj->ProductID,$ProductObj->ProductInitialPrice);
	echo'<script>history.pushState({}, "", "")</script>';
	echo'<div class="Post_Offer_GUI">
			</br>
			<center>Successfully sent Offer!</center>
			<center>Check the status of your offer in the page below</center>
			<center><a href="ContractPage.php?ID='.$ContractID.'">ContractPage.php?ID='.$ContractID.'</a><center>
		</div>';
	echo'<script>history.pushState({}, "", "")</script>';
	exit();
	
	

}

 require_once("Footer.php");?> 
