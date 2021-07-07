<?php
header('Access-Control-Allow-Origin: *');
require_once("Users.php");
session_start();


if(isset($_POST['CreditCardIn'])){
echo $_POST['UID'];
	$BaseUserOBJ = new BaseUser("TopUp");
	$BaseUserOBJ->setUID($_POST['UID']);
	$UserObj = new StandardUser($BaseUserOBJ);
	$UserObj->TopUpToSTICoin($_POST['Amount'],$_POST['TxID']);

		
}
?>