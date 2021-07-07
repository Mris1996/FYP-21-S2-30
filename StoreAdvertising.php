<!-- 
(Entity Class)
1. Purpose of Program
Is an Entity class which is called by ProcessAdvertising.php (Controller). Used to store data.

2. Author of Program
Program written by: Samuel

3. Date and time of last modified
Last Modified:  2 July 2021 9:42PM

User Story:
#246 As a seller, I want to advertise my product on the front page by paying a fee, so that I can promote my product
Boundary: AdvertiseProduct.php
Controller: ProcessAdvertising.php
Entity: StoreAdvertising.php

To see page:
http://localhost/AdvertiseProduct.php
-->
<?php
require_once("Users.php");

class StoreAdvertising
{	
	private $doesUserIdExist = false; 
	private $didQuerySucceed = false;

	public function __construct() {}

	public function getresult() { return $this->doesUserIdExist; }
	public function getInsertAdvertisingDetailsResult() { return $this->didQuerySucceed; }

	public function checkIfUserIdIsInDatabase($userIDToBeVerified) {
		$connectionToDatabase = $this->getConnectionToSqlDatabase();
		$sqlQueryToExecute    = $this->constructSelectUserIdQuery($userIDToBeVerified);
		$resultOfQuery        = $this->queryUserIdInDatabase($connectionToDatabase, $sqlQueryToExecute);
		$this->processResultOfQuery($resultOfQuery);
	}
	
	public function getConnectionToSqlDatabase() {
		$temporaryInstanceOfUser = new BaseUser("temporary");
		return $temporaryInstanceOfUser->connect();
	}
	
	public function constructSelectUserIdQuery($userIDToBeVerified) {
		return "SELECT * FROM users WHERE UserID='".$userIDToBeVerified."'" ;
	}
	
	public function queryUserIdInDatabase($connectionToDatabase, $sqlQueryToExecute) {
		$result = "";
		if ($result = $connectionToDatabase->query($sqlQueryToExecute)) {
			$connectionToDatabase->close();
			return $result;
		} else {
			$connectionToDatabase->close();
			throw new Exception("Query Failed to Execute.");
		} 
	}
	
	public function processResultOfQuery($resultOfQuery) {
		if ($resultOfQuery->num_rows == 1) {
			$this->doesUserIdExist = true;
		} else {
			$this->doesUserIdExist = false;
		}
	}
		
	// 5. Can have a method for storing the advertisement to be displayed.
	public function saveFileOnServer($fileToBeStored, $locationToStoreFiles) {
		$didFileStoreProperly = $this->storeTheFileInSpecifiedDirectory($fileToBeStored, $locationToStoreFiles);	

		$success = true;
		if ($didFileStoreProperly == $success) {
			$nameOfFile = $this->getNameOfFile($fileToBeStored);
			echo "The file ". $nameOfFile . " has been uploaded.";
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	}
	
	public function storeTheFileInSpecifiedDirectory($fileToBeStored, $locationToStoreFiles) {
		return move_uploaded_file($fileToBeStored["imageForAdvertisement"]["tmp_name"], $locationToStoreFiles);
	}

	public function getNameOfFile($fileToBeStored) {
		return htmlspecialchars(basename($fileToBeStored["imageForAdvertisement"]["name"]));
	}
	
	// 1. SQL Database to store bookings (userID, start date, end date, image name)
	public function insertInToSqlDatabase($userID, $startDate, $endDate, $fileName) {

		$connectionToDatabase = $this->getConnectionToSqlDatabase();
		$sqlQueryToExecute    = $this->constructQueryForInsertingAdvertisingDetails($userID, $startDate, $endDate, $fileName);
		
		$this->exeuteQueryToInsertAdvertisingDetails($connectionToDatabase, $sqlQueryToExecute);
	}
	
	// 4. Can have a method for inserting date into a new table
	public function constructQueryForInsertingAdvertisingDetails($userID, $startDate, $endDate, $fileName) {
		// DATETIME Object needs to be converted to string before it can be inserted into database
		$stringStartDate = $startDate->format('Y-m-d H:i:s');
		$stringEndDate   = $endDate->format('Y-m-d H:i:s');
		return  "INSERT INTO advertising (UserID, StartDate, EndDate, adImage) VALUES ('".$userID."', '".$stringStartDate."', '".$stringEndDate."', '".$fileName."')";
	}
	
	// 5. Can have a method for storing the advertisement to be displayed
	public function exeuteQueryToInsertAdvertisingDetails($connectionToDatabase, $sqlQueryToExecute) {
		if ($connectionToDatabase->query($sqlQueryToExecute)) {
			$connectionToDatabase->close();
			$this->didQuerySucceed = true;
		} else {
			$connectionToDatabase->close();
			throw new Exception("Query Failed to Execute.");
		} 
	}
}
?>
<!--Links Used-->
<!-- 
Main design of entity class
https://www.w3schools.com/php/php_file_upload.asp

Uploading files 
https://www.php.net/manual/en/function.move-uploaded-file.php

Connect to mySQL Database
https://www.w3schools.com/php/func_mysqli_multi_query.asp
https://www.w3schools.com/php/func_mysqli_query.asp
https://www.w3schools.com/php/php_mysql_select.asp
https://www.php.net/manual/en/function.mysql-connect.php
https://www.php.net/manual/en/mysqli.connect-errno.php

Try Catch blocks
https://www.w3schools.com/php/php_exception.asp
https://www.w3schools.com/php/php_exceptions.asp

Convert DATETIME to string
https://stackoverflow.com/questions/10569053/convert-datetime-to-string-php
https://www.php.net/manual/en/datetime.format.php
https://www.mysqltutorial.org/mysql-datetime/

-->