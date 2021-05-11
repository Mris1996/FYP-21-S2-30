<?php 
$ContractID = "asdas";
$InitialOffer = 1;	
$Offer = 1;
$DateRequired = '14/07/2021';
$UID = 'asdasdsadas';
$SellerID  = 'asdaasdsdsadas';
$ProductID = 'adqa1e21312dasdqas';
$sql = "INSERT INTO `contracts`(`ContractID`,`InitialOffer`) VALUES ('".$ContractID."','".$InitialOffer."','".$Offer."','".$DateRequired."','".$UID."','".$SellerID."','".$ProductID."')";
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
echo "asd";

?>