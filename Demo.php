<?php require_once("NavBar.php");

$ContractID = "asdas";
$InitialOffer = 1;	
$Offer = 1;
$DateRequired = '14/07/2021';
$UID = 'asdasdsadas';
$SellerID  = 'asdaasdsdsadas';
$ProductID = 'adqa1e21312dasdqas';
$sql = "INSERT INTO `contracts`(`ContractID`) VALUES ('".$ContractID."')";
		$result = $_SESSION['Object']->connect()->query($sql) or die($_SESSION['Object']->connect()->error); 
echo "asd";

?>