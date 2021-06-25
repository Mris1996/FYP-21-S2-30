<!-- 
(Controller Class)
1. Purpose of Program
It is a processing/utility class to handle data from AdvertiseProduct.php (Boundary) and Entity class

2. Author of Program
Program written by: Samuel

3. Date and time of last modified
Last Modified: 25 June 2021 8:21PM

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
	// variable can be outsourced to pull "location to store" from SQL DB 
	// private vars here to make it easier to modify settings used in the script.
	private $directoryToStoreFiles = "ads/";
	private $fileSizeLimit = 150000;
	
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
		
		$success = 0;
		$fail = 1;
		
		return (!$isItEmpty and $isItValidDate) ? $success : $fail;
	}
	
	public function checkFileIsActualImage($fileToBeChecked) {
		$canCommandBeExecuted = getimagesize($fileToBeChecked["imageForAdvertisement"]["tmp_name"]);
		return ($canCommandBeExecuted != false) ? true : false;
	}
	
	public function checkFileSize($fileToBeChecked) {
		$fileSizeLimit = $this->fileSizeLimit;
		return ($fileToBeChecked["imageForAdvertisement"]["size"] > $fileSizeLimit) ? true : false;	
	}
	
	// 2. Validate image, perform security checks
	public function verifyFileIntegrity($fileToBeChecked) {
		
		$checkFileUploadStatus = $fileToBeChecked["imageForAdvertisement"]["error"];
		$success = 0;
		$fail = 1;
		
		if ($checkFileUploadStatus == $success) {
			$directoryToStoreFiles = $this->directoryToStoreFiles;
			$directoryWhereFileWillBeStored = $directoryToStoreFiles . basename($fileToBeChecked["imageForAdvertisement"]["name"]);
			$fileExtension = strtolower(pathinfo($directoryWhereFileWillBeStored, PATHINFO_EXTENSION));
			
			$isFileAnActualImage = $this->checkFileIsActualImage($fileToBeChecked); 
			$doesFileAlreadyExist = file_exists($directoryWhereFileWillBeStored);
			$isFileTooBig = $this->checkFileSize($fileToBeChecked);
			
			// Limit File Type
			// https://www.w3schools.com/php/php_file_upload.asp
			// https://stackoverflow.com/questions/27614822/the-most-reliable-way-to-check-upload-file-is-an-image
			// https://www.php.net/manual/en/function.exif-imagetype.php
			// https://www.geeksforgeeks.org/php-exif_imagetype-function/
			// 
			
			
			if ($isFileAnActualImage and !$doesFileAlreadyExist and !$isFileTooBig) {
				//echo "File is small! YES";
				return $success;
			}
			else {
				//echo "File is TOO BIG! NO";
				return $fail;
			}
			
			
		} else {
			// File is empty or upload has failed!
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

Validating Image Files
https://www.w3schools.com/php/php_file_upload.asp
https://www.php.net/manual/en/features.file-upload.post-method.php
https://stackoverflow.com/questions/27614822/the-most-reliable-way-to-check-upload-file-is-an-image
https://www.php.net/manual/en/features.file-upload.php
https://stackoverflow.com/questions/10096977/how-to-check-if-the-file-input-field-is-empty
https://stackoverflow.com/questions/27614822/the-most-reliable-way-to-check-upload-file-is-an-image
https://www.php.net/manual/en/function.exif-imagetype.php
https://www.geeksforgeeks.org/php-exif_imagetype-function/

Why "getimagesize" alone is not enough for image validation
https://www.php.net/manual/en/function.getimagesize.php

Passing "Files" and "Post" via parameters
https://stackoverflow.com/questions/10738627/php-passing-files-and-post-as-parameters-to-function/10738823

Industry standard for advertisement banner file size (150kB)
https://blog.creatopy.com/maximum-banner-file-size/

When to use Ternary Operators 
https://softwareengineering.stackexchange.com/questions/28314/ternary-operator-considered-harmful
https://www.quora.com/Is-there-any-good-use-of-ternary-operator-that-makes-up-how-it-reduces-code-readability
https://www.geeksforgeeks.org/php-ternary-operator/
https://www.codementor.io/@sayantinideb/ternary-operator-in-php-how-to-use-the-php-ternary-operator-x0ubd3po6

Accessing Private Variables
https://www.studytonight.com/php/php-access-modifiers

-->