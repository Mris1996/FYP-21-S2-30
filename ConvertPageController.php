<?php
require_once("Users.php");
require_once("Products.php");
session_start();
$ch = curl_init('http://localhost:3030');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");


//#############################################################
if(isset($_POST['OTP'])){

$msg = $_SESSION['Object']->VerifyOTP($_POST['OTP']);

if($msg=="Success"){
$_SESSION['VerifiedUser'] = true;
$jsonData = json_encode([
'REPLY'=>'OTPResult',
'Result' =>'Success',
'User' => $_SESSION['Object']->getUID()
]);
}
if($msg=="Wrong OTP"){
		
$jsonData = json_encode([
'REPLY'=>'OTPResult',
'Result' =>'Failed',
'User' => $_SESSION['Object']->getUID()
]);
}

if($msg=="Max Attempt"){

$jsonData = json_encode([
'REPLY'=>'OTPResult',
'Result' =>'LogOut',
'User' => $_SESSION['Object']->getUID()
]);

}

$query = http_build_query(['data' => $jsonData]);
}
/*
if(isset($_POST['Amount'])){

$_SESSION['UploadNow'] = $_POST['Amount'];
$_SESSION['PaymentOption'] = $_POST['Option'];
$jsonData = json_encode([
'REPLY'=>'ProductIDreturn',
'User' => $_SESSION['Object']->getUID()
]);

$query = http_build_query(['data' => $jsonData]);
}
*/
if(isset($_POST['Email'])){
	$_SESSION['Object']->SendVerfication($_POST['Email']);
		
}

if(isset($_POST['Logout'])){
	$_SESSION['Object']->LogOut();
}
//#############################################################
if(isset($query)){
	
curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// execute
$response = curl_exec($ch);
 // close
 $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//echo $response;
curl_close($ch);
}
