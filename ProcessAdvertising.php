<!-- 
(Controller Class)
1. Purpose of Program
It is a processing/utility class to handle data from AdvertiseProduct.php (Boundary) and Entity class

2. Author of Program
Program written by: Samuel

3. Date and time of last modified
Last Modified: 25 June 2021 12:43AM

User Story:
#246 As a seller, I want to advertise my product on the front page by paying a fee, so that I can promote my product
Boundary: AdvertiseProduct.php
Controller: ProcessAdvertising.php
Entity:

To see page:
http://localhost/AdvertiseProduct.php
-->
<?php 
class ProcessAdvertising
{
	public function __construct() {
	}
	
	public function checkIfSellerIsLoggedIn() {
		if(!isset($_SESSION['ID'])) {
			echo '<script type="text/javascript"> location.replace("index.php")</script> ';
			die("Redirecting to index.php");
		}
	}
	
	public function checkValidDate($dateToBeVerified) {
		try {
			$validDate = new DateTime($dateToBeVerified);
			return true;
		} catch (Exception $e) {
			return false;
		}
	}
	
	// 1. Do input validation and sanitization for date
	public function verifyDate($dateToBeVerified) {
		$isItEmpty = empty($dateToBeVerified);
		$isItValidDate = $this->checkValidDate($dateToBeVerified);
		
		if (!$isItEmpty and $isItValidDate) {
			$success = 0;
			return $success;
		}
		else {
			$fail = 1;
			return $fail;
		}
	}
	
}
?>
<!--Links Used -->
<!--
Base format for a class
https://dzone.com/articles/learn-php-how-write-class-php
https://www.w3schools.com/php/php_oop_classes_objects.asp
https://stackoverflow.com/questions/3032808/purpose-of-php-constructors

Validate Date Input
https://www.codexworld.com/how-to/validate-date-input-string-in-php/
https://www.php.net/manual/en/datetime.construct.php

How to call parent function from a child class 
https://www.php.net/manual/en/ref.classobj.php

String Concatenation with Echo
https://riptutorial.com/php/example/22787/string-concatenation-with-echo

Operators in php
https://www.w3schools.com/php/php_operators.asp

-->