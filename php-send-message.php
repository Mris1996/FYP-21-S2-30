<?php
require_once("Users.php");
require_once("Products.php");
session_start();

// get the input
$User1 = trim(htmlspecialchars($_POST['User1'] ?? ''));
$User2 = trim(htmlspecialchars($_POST['User2'] ?? ''));
$message = trim(htmlspecialchars($_POST['message'] ?? ''));

if (!$User1 || !$message || !$User2)
	die;

$_SESSION['Object']->InsertChat($User1,$User2,$message);

	
// Send the HTTP request to the websockets server (it runs both  HTTP and Websockets)
// (change the URL accordingly)
$ch = curl_init('http://localhost:3030');
// It's POST
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

// we send JSON encoded data to the client
$jsonData = json_encode([
	'User1' => $User1,
	'User2' => $User2,
	'message' => $message
]);
$query = http_build_query(['data' => $jsonData]);
curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
// Just return the transfer
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// execute
$response = curl_exec($ch);
 // close
curl_close($ch);


// Now real time notification should be sent to all the users


