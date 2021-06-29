<!-- 
(Entity Class)
1. Purpose of Program
Is an Entity class which is called by ProcessAdvertising.php (Controller). Used to store data.

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
class StoreAdvertising
{
	// WIP
	// Can have a private variable here to store the success result of the file storing function
	// Similar to Controller class

	public function __construct() {}
	
	// 5. Can have a method for storing the advertisement to be displayed.
	public function saveFileOnServer($fileToBeStored, $locationToStoreFiles) {
		if (move_uploaded_file($fileToBeStored["imageForAdvertisement"]["tmp_name"], $locationToStoreFiles)) {
			echo "The file ". htmlspecialchars(basename($fileToBeStored["imageForAdvertisement"]["name"])). " has been uploaded.";
		} else {
			echo "Sorry, there was an error uploading your file.";
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
-->