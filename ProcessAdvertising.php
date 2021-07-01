<!-- 
(Controller Class)
1. Purpose of Program
It is a processing/utility class to handle data from AdvertiseProduct.php (Boundary) and StoreAdvertising.php (Entity)

2. Author of Program
Program written by: Samuel

3. Date and time of last modified
Last Modified: 30 June 2021 11:40PM

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
	
	private $processingResult   = false;
	private $isUserIdCorrect    = false;
	private $isDateCorrect      = false;
	private $isImageFileCorrect = false;

	private $userIDToBeVerified = "";
	private $dateToBeVerified   = "";
	private $fileToBeVerified   = "";
	
	public function __construct($userID, $advertisingStartDate, $fileForProcessing) {
		$this->userIDToBeVerified = $userID;
		$this->dateToBeVerified   = $advertisingStartDate;
		$this->fileToBeVerified   = $fileForProcessing;
	}
	
	public function getProcessingResult()   { return $this->processingResult;   }
	public function getIsUserIdCorrect()    { return $this->isUserIdCorrect;    }
	public function getIsDateCorrect()      { return $this->isDateCorrect;      }
	public function getIsImageFileCorrect() { return $this->isImageFileCorrect; }
	
	// WIP
	public function processForm() {
		
		$this->isUserIdCorrect    = $this->verifyUserID(); 
		$this->isDateCorrect      = $this->verifyDate();
		$this->isImageFileCorrect = $this->verifyFileIntegrity(); 
		
		$yes = true;
		$no = false;
		if ($this->isUserIdCorrect    == $yes and 
			$this->isDateCorrect      == $yes and 
			$this->isImageFileCorrect == $yes) {
		
			$this->sendFileForStoring();
			$this->sendDateForStoring();
			
			// WIP
			
			$this->processingResult = true;
		} else {
			$this->processingResult = false;
		}	
	}

	public function verifyUserID() {
		$accessDatabase = new StoreAdvertising();
		$accessDatabase->checkIfUserIdIsInDatabase($this->userIDToBeVerified);	
		$isUserIdInDatabase = $accessDatabase->getresult();
		return $isUserIdInDatabase;
		// Can have further Validation and Sanitization of the field.
		// Refer to "forget password" system for the validation and sanitization code		
	}

	// 1. Do input validation and sanitization for date
	public function verifyDate() {
		$isItEmpty     = $this->checkIfDateIsEmpty();
		$isItValidDate = $this->checkValidDate();
		
		$success = true;
		$fail = false;
		return (!$isItEmpty and $isItValidDate) ? $success : $fail;
	}
	
	public function checkIfDateIsEmpty() {
		return empty($this->dateToBeVerified); 
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
		
		$yes = 0;
		$no = 1;
		if ($isFileUploadSuccessful == $yes) {
			$directoryWhereFileWillBeStored = $this->getWhereToStoreFiles();
			$fileExtensionToBeVerified      = $this->getFileExtension($directoryWhereFileWillBeStored);
			
			$isFileAnActualImage      = $this->checkFileIsActualImage(); 
			$isFileAlreadyInDirectory = $this->checkForFileInDirecory($directoryWhereFileWillBeStored);
			$isFileTooBigInSize       = $this->checkFileSize();
			$isFileExtensionCorrect   = $this->checkFileExtension($fileExtensionToBeVerified);
			
			if ($isFileAnActualImage and !$isFileAlreadyInDirectory and 
				!$isFileTooBigInSize and $isFileExtensionCorrect) {
				return true;
			}
			else {
				return false;
			}
		} else {
			// File is empty or upload has failed!
			return false; 
		}
	}

	public function checkFileUploadStatus() {
		return  $this->fileToBeVerified["imageForAdvertisement"]["error"];
	}
	
	public function getWhereToStoreFiles() {
		return $this->folderToStoreFiles . basename($this->fileToBeVerified["imageForAdvertisement"]["name"]);
	}
	
	public function getFileExtension($directoryWhereFileWillBeStored) {
		return strtolower(pathinfo($directoryWhereFileWillBeStored, PATHINFO_EXTENSION));
	}
	
	public function checkFileIsActualImage() {
		$canCommandBeExecuted = getimagesize($this->fileToBeVerified["imageForAdvertisement"]["tmp_name"]);
		return ($canCommandBeExecuted != false) ? true : false;
	}
	
	public function checkForFileInDirecory($directoryWhereFileWillBeStored) {
		return file_exists($directoryWhereFileWillBeStored);
	}
	
	public function checkFileSize() {
		return ($this->fileToBeVerified["imageForAdvertisement"]["size"] > $this->fileSizeLimit) ? true : false;	
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
	public function sendFileForStoring() {
		$verifiedFileToBeStored = $this->fileToBeVerified;
		$directoryWhereFileWillBeStored = $this->getWhereToStoreFiles();
		
		$storageProcessing = new StoreAdvertising();
		$storageProcessing->saveFileOnServer($verifiedFileToBeStored, $directoryWhereFileWillBeStored);
	}
	
	// WIP
	public function sendDateForStoring() {
		//https://techone.in/how-to-insert-date-in-mysql-using-php/
		//https://www.php.net/manual/en/class.datetime.php
		// stopped here
		//echo "Hello World!";
	}
	
}
?>
<!--Links Used-->
<!--
Base format for a class
https://dzone.com/articles/learn-php-how-write-class-php

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

Validating date range
https://www.php.net/manual/en/class.datetime.php
https://www.codegrepper.com/code-examples/php/check+if+date+is+within+range+php
https://www.plus2net.com/sql_tutorial/between-date.php
https://www.php.net/manual/en/class.dateperiod.php
https://www.nicesnippets.com/blog/how-to-check-current-date-between-two-dates-in-php
https://techone.in/how-to-insert-date-in-mysql-using-php/

Constructors
https://www.php.net/manual/en/language.oop5.decon.php

-->