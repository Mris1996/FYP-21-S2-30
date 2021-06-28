<!-- 
(Boundary Class/Webpage)
1. Purpose of Program
Is an interface for Sellers to list their products 

2. Author of Program
Program written by: Samuel

3. Date and time of last modified
Last Modified: 28 June 2021 10:54PM

User Story:
#246 As a seller, I want to advertise my product on the front page by paying a fee, so that I can promote my product
Boundary: AdvertiseProduct.php
Controller: ProcessAdvertising.php
Entity:

To see page:
http://localhost/AdvertiseProduct.php
-->
<?php 
	require_once("NavBar.php");
	require_once("ProcessAdvertising.php");

	$testing = new ProcessAdvertising();
	$testing->checkIfSellerIsLoggedIn();

	$systemMessage = "";
	
	// Event Listener 
	if (isset($_POST['submitAdvertiseProductForm'])) {
		
		try {
			$testing->processForm($_POST["advertisingStartDate"], $_FILES);
		} catch (Exception $e) {
			$systemMessage = "Processing Error, please try again!";
		}
		
		if ($testing->getProcessingResult()) {
			$systemMessage = "Form processed successfully.";
		} else {
			$systemMessage = whatIsTheError($testing);
		}
	}
	else {
		// Reset
		$systemMessage = "";
	}
	
	function whatIsTheError($testing) {
		$yes = 0;
		if ($testing->getIsDateCorrect() == $yes) {} 
		else {
			return "Invalid Date!";
		}
		if ($testing->getIsImageFileCorrect() == $yes) {}
		else {
			return "Invalid image! Only jpg, png, jpeg, gif are allowed. File size must be 150kB.";
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<style type="text/css">
		</style>
	</head>
	
	<body>
		<p>This is where you can advertise products.</p>
		
		<form autocomplete="off" method="post" name="advertiseProductForm" enctype="multipart/form-data">
			<!--1. Asks for when/what starting date should advertisement will be put up(Can have basic validation)-->
			<label for="advertisingStartDate">Start Date for Advertising:</label>
			<input type="date" id="advertisingStartDate" name="advertisingStartDate" required>
			<br>
			
			<!--2. Asks for image to be advertised-->
			<label for="imageForAdvertisement">Select image to be uploaded for advertisement:</label>
			<input type="file" name="imageForAdvertisement" id="imageForAdvertisement" required>
			
			<br>
			<input type="submit" value="Submit" name="submitAdvertiseProductForm">
			<br>
			
			<span>&nbsp;&nbsp;<?php echo $systemMessage;?></span>
		</form>
		<?php require_once("Footer.php");?>
		
		<!--Prevent form resubmission -->
		<script>
			if ( window.history.replaceState ) {
				window.history.replaceState( null, null, window.location.href );
			}
		</script>
	</body>
</html>

<!--Links Used -->
<!-- 
Base Layout of website:
https://www.sitepoint.com/a-basic-html5-template/

Creating a Form
https://www.w3schools.com/tags/tag_form.asp

Date Input field
https://www.w3schools.com/tags/att_input_type_date.asp

Submission of Form (Submit Button)
https://www.w3schools.com/tags/tag_input.asp
https://www.w3schools.com/html/html_forms.asp

File upload
https://www.w3schools.com/php/php_file_upload.asp
https://www.php.net/manual/en/features.file-upload.post-method.php
https://learnwebtutorials.com/file-upload-in-php-tutorial
https://phppot.com/php/php-image-upload-with-size-type-dimension-validation/
https://documentation.concrete5.org/developers/security/validating-file-uploads

What is $_FILES?
https://www.w3resource.com/php/super-variables/$_FILES.php
https://www.php.net/manual/en/features.file-upload.post-method.php

Difference between "require" and "require_once"
https://stackoverflow.com/questions/2418473/difference-between-require-include-require-once-and-include-once

-->