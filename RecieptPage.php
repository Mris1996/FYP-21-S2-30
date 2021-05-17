<?php
require_once("NavBar.php");
if(!isset($_SESSION['ID'])){
	echo '<script> location.replace("index.php")</script> ';
}
$ContractID = $_GET['ID'] ;
$_SESSION["ContractID"] = $_GET['ID'];
$ContractObj = new Contracts();
if(!$ContractObj->initialiseContract($ContractID)){
	echo '<script> location.replace("index.php")</script> ';
}
if($ContractObj->BuyerUserID!=$_SESSION['ID']&&$ContractObj->SellerUserID!=$_SESSION['ID']){
	if($_SESSION['Object']->getAccountType()!="Administrator"){
	echo '<script> location.replace("index.php")</script> ';
}
}
$TransactionsArr = json_decode($ContractObj->TransactionID,true);


echo '<center><h1>Invoice</h1></center><hr>';
for($x=0;$x<sizeof($TransactionsArr);$x++) {

?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.card {
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
  transition: 0.3s;
  width: 70%;
  margin:auto;
}

.card:hover {
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}

.container {
  padding: 2px 16px;
}
</style>
<div class="card">
<h2>TransactionID:<?php echo  $TransactionsArr[$x][0] ?></h2><hr>
<b>ContractID:<?php echo   $ContractObj->ContractID; ?></b>
<b>ProductID:<?php echo   $ContractObj->ProductID; ?></b>
<b>Amount:<?php echo  $TransactionsArr[$x][2] ?></b>
<b>Sender:<?php echo  $TransactionsArr[$x][3] ?></b>
<b>Reciever:<?php echo $TransactionsArr[$x][4] ?></b>
<b>Transaction Date:<?php  echo $TransactionsArr[$x][1]?></b>
</div></br>
<?php
}
?>