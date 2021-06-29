<!-- 
(Controller Class)
1. Purpose of Program
It is a processing/utility class to handle data from AdvertiseProduct.php (Boundary) and StoreAdvertising.php (Entity)

2. Author of Program
Program written by: Samuel

3. Date and time of last modified
Last Modified: 30 June 2021 1:00AM

User Story:
#246 As a seller, I want to advertise my product on the front page by paying a fee, so that I can promote my product
Boundary: AdvertiseProduct.php
Controller: ProcessAdvertising.php
Entity: StoreAdvertising.php

To see page:
http://localhost/AdvertiseProduct.php
-->
<?php 
require_once("StoreAdvertising.php");

class ProcessAdvertising
{
	// Settings for script. Variable can be outsourced to pull "location to store" from SQL DB 
	private $folderToStoreFiles = "ads/";
	private $fileSizeLimit = 150000; //150kB
	
	private $processingResult = false;
	private $isDateCorrect = 1;
	private $isImageFileCorrect = 1;

	private $dateToBeVerified = "";
	private $fileToBeChecked = "";
	
	public function __construct() {}
	
	// Accessors
	public function getProcessingResult() { return $this->processingResult; }
	public function getIsDateCorrect() { return $this->isDateCorrect; }
	public function getIsImageFileCorrect() { return $this->isImageFileCorrect; }
	
	public function checkIfSellerIsLoggedIn() {
		if(!isset($_SESSION['ID'])) {
			echo '<script type="text/javascript"> location.replace("index.php")</script> ';
			die("Redirecting to index.php");
		}
	}
	
	// WIP
	public function processForm($advertisingStartDate, $file) {
		$this->dateToBeVerified = $advertisingStartDate;
		$this->fileToBeChecked = $file;
		
		$this->isDateCorrect = $this->verifyDate();
		$this->isImageFileCorrect = $this->verifyFileIntegrity();
		
		$yes = 0;
		
		if ($this->isDateCorrect == $yes and $this->isImageFileCorrect == $yes) {
			$this->sendFileForStoring();
			//$this->sendDateForStoring();
			
			
			
			
			
			
			$this->processingResult = true;
		} else {
			$this->processingResult = false;
		}	
	}

	// 1. Do input validation and sanitization for date
	public function verifyDate() {
		$dateToBeVerified = $this->dateToBeVerified;
		$isItEmpty = empty($dateToBeVerified); 
		$isItValidDate = $this->checkValidDate();
		
		$success = 0;
		$fail = 1;
		return (!$isItEmpty and $isItValidDate) ? $success : $fail;
	}
	
	public function checkValidDate() {
		$dateToBeVerified = $this->dateToBeVerified;
		try {
			$validDate = new DateTime($dateToBeVerified);
			return true;
		} catch (Exception $e) {
			return false;
		}
	}
		
	// 2. Validate image, perform security checks
	// Future Implementation: Secure File Upload according to OWASP standard
	public function verifyFileIntegrity() {
		$isFileUploadSuccessful = $this->checkFileUploadStatus();
		$success = 0;
		$fail = 1;
		
		if ($isFileUploadSuccessful == $success) {
			$directoryWhereFileWillBeStored = $this->getWhereToStoreFiles();
			$fileExtensionToBeVerified      = $this->getFileExtension($directoryWhereFileWillBeStored);
			
			$isFileAnActualImage    = $this->checkFileIsActualImage(); 
			$doesFileAlreadyExist   = file_exists($directoryWhereFileWillBeStored); 
			$isFileTooBigInSize     = $this->checkFileSize();
			$isFileExtensionCorrect = $this->checkFileExtension($fileExtensionToBeVerified);
			
			if ($isFileAnActualImage and !$doesFileAlreadyExist and 
				!$isFileTooBigInSize and $isFileExtensionCorrect) {
				return $success;
			}
			else {
				return $fail;
			}
		} else {
			// File is empty or upload has failed!
			return $fail; 
		}
	}

	public function checkFileUploadStatus() {
		return  $this->fileToBeChecked["imageForAdvertisement"]["error"];
	}
	
	public function getWhereToStoreFiles() {
		return $this->folderToStoreFiles . basename($this->fileToBeChecked["imageForAdvertisement"]["name"]);
	}
	
	public function getFileExtension($directoryWhereFileWillBeStored) {
		return strtolower(pathinfo($directoryWhereFileWillBeStored, PATHINFO_EXTENSION));
	}
	
	public function checkFileIsActualImage() {
		$canCommandBeExecuted = getimagesize($this->fileToBeChecked["imageForAdvertisement"]["tmp_name"]);
		return ($canCommandBeExecuted != false) ? true : false;
	}
	
	public function checkFileSize() {
		return ($this->fileToBeChecked["imageForAdvertisement"]["size"] > $this->fileSizeLimit) ? true : false;	
	}
	
	public function checkFileExtension($fileExtensionToBeVerified) {
		if ($fileExtensionToBeVerified == "jpg" or 
		    $fileExtensionToBeVerified == "png" or
			$fileExtensionToBeVerified == "jpeg" or
			$fileExtensionToBeVerified == "gif") {
			
			$validFileExtension = true;
			return $validFileExtension;
		} else {
			$invalidFileExtension = false;
			return $invalidFileExtension;
		}
	}
	
	// 5. If date and image is valid, it will send both to corresponding entity class for storing
	// Finish the base function at this link.
	// https://www.w3schools.com/php/php_file_upload.asp
	public function sendFileForStoring() {
		$verifiedFileToBeStored = $this->fileToBeChecked;
		$directoryWhereFileWillBeStored = $this->getWhereToStoreFiles();
		
		$storageProcessing = new StoreAdvertising();
		$storageProcessing->saveFileOnServer($verifiedFileToBeStored, $directoryWhereFileWillBeStored);
	}
	
	public function sendDateForStoring() {
		//echo "Hello World!";
	}
	
}
?>
<!--Links Used-->
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

Securing File Upload from OWASP 
https://cheatsheetseries.owasp.org/cheatsheets/File_Upload_Cheat_Sheet.html
https://www.opswat.com/blog/file-upload-protection-best-practices
https://www.sans.org/blog/8-basic-rules-to-implement-secure-file-uploads/


-->