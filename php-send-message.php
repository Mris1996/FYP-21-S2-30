<?php
require_once("Users.php");
require_once("Products.php");
session_start();
$ch = curl_init('http://localhost:3030');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

// get the input
$User1 = trim(htmlspecialchars($_POST['User1'] ?? ''));
$User2 = trim(htmlspecialchars($_POST['User2'] ?? ''));
$message = trim(htmlspecialchars($_POST['message'] ?? ''));


//#############################################################
if(isset($_POST['offer'])){
	
$_SESSION['Object']->UpdateContract($_POST['offer'],$_POST['daterequired'],$_POST['paymentmode'],$_POST['contractid'],$_POST['usertype']);

$jsonData = json_encode([
	'User1' => $User1,
	'User2' => $User2,
	'offer' => $_POST['offer'],
	'daterequired' => $_POST['daterequired'],
	'paymentmode' => $_POST['paymentmode'],
	'ContractID' => $_POST['contractid']
]);	
$query = http_build_query(['data' => $jsonData]);	

}


//#############################################################
if(isset($_POST['Accept'])&&$_POST['Accept']==$User1){
$_SESSION['Object']->AcceptContract($_POST['contractid'],$_POST['usertype']);
}


//#############################################################
if(isset($_POST['AcceptService'])&&$_POST['AcceptService']==$User1){

$_SESSION['Object']->AcceptService($_POST['contractid'],$_POST['usertype']);

$jsonData = json_encode([
	'REPLY'=>'AcceptService',
	'Type' => $_POST['usertype'],
	'ContractID' => $_POST['contractid']
]);
$query = http_build_query(['data' => $jsonData]);
}


//#############################################################
if(isset($_POST['Reject'])&& $_POST['Reject']==$User1){
	
$_SESSION['Object']->RejectContract($_POST['contractid']);
$jsonData = json_encode([
	'REPLY'=>'DeclineContract',
	'Declined' => "set",
	'ContractID' => $_POST['contractid']
]);

$query = http_build_query(['data' => $jsonData]);
echo $query;
}


//#############################################################
if(isset($_POST['Refund'])){
	
$_SESSION['Object']->RequestRefund($_POST['contractid']);
}


//#############################################################
if(isset($message) && strlen($message)!=0){

$_SESSION['Object']->InsertChat($User1,$User2,$message);

	
$jsonData = json_encode([
	'REPLY'=>'ChatSystem',
	'User1' => $User1,
	'User2' => $User2,
	'message' => $message,
	'ContractID' => $_POST['contractid']
]);
$query = http_build_query(['data' => $jsonData]);

}


//#############################################################
if(isset($_POST['CheckAccepted'])){
	
if($_SESSION['Object']->CheckAccepted($_POST['CheckAccepted'])==2){
	
$jsonData = json_encode([
	'REPLY'=>'CheckAccepted',
	'Deal' => "set",
	'ContractID' => $_POST['CheckAccepted']
]);	

}
else{
	$jsonData = json_encode([
	'REPLY'=>'CheckAccepted',
	'Deal' => "notset",
	'ContractID' => $_POST['CheckAccepted']
]);
	
}
$query = http_build_query(['data' => $jsonData]);	
}


//#############################################################
if(isset($_POST['CheckServiceAccepted'])){
	
if($_SESSION['Object']->CheckServiceAccepted($_POST['CheckServiceAccepted'])==2){
	
$jsonData = json_encode([
	'REPLY'=>'CheckServiceAccepted',
	'DealComplete' => "set",
	'Type' => $_POST['usertype'],
	'ContractID' => $_POST['CheckServiceAccepted']
]);	

}
else{
	$jsonData = json_encode([
	'REPLY'=>'CheckServiceAccepted',
	'DealComplete' => "notset",
	'ContractID' => $_POST['CheckServiceAccepted']
]);
	
}
$query = http_build_query(['data' => $jsonData]);	
}


//#############################################################
if(isset($_POST['Transfer'])&&$_POST['Transfer']==$_SESSION['ContractID']){
	
	if($_SESSION['Object']->ToTransfer($_POST['Transfer'])){
		$_SESSION['Object']->TransferAmount($_POST['Transfer'],$_SESSION['Object']->AmountToTransfer($_POST['Transfer']));
	}
}



//#############################################################
if(isset($query)){
curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
// Just return the transfer
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// execute
$response = curl_exec($ch);
 // close
curl_close($ch);
}
