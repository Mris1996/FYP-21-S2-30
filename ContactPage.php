<!--
User Story: #72 
As a base user , I want to view the contact page, 
so that I can contact the administrator or the company to assist me with any queries.
 -->

<!--
Blue Print
1. Contruct Basic Layout [DONE]
2. Get page working      [DONE]
3. Do basic CSS          [DONE]
4. Do Security Hardening [DONE]
 - Validate inputs - HTML                             [DONE]
 - Ensure input fields are not allowed to leave blank [DONE]
 - strip special characters - PHP                     [DONE]
 - Prevent form resubmission                          [DONE]
5. Add instructions how to configure php.ini and sendmail.ini [DONE]
 -->

<!--This page is Called using Footer.php -->

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<style>
			.center {
				margin: auto;
				width: 20%;
				border: 3px solid blue; 
				padding: 10px;
			}
		</style>
		<?php
			// Include the navigation bar
			require_once("NavBar.php"); 
		
			// Define Variables
			$header = $recipient = $subject = $user_email = $user_message = $user_name = $message = "";
			
			// strip special characters
			function clean_input($data)
			{
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);
				return $data;
			}
		
			// If Submit button is clicked (Event Listener)
			if(isset($_POST['submit']))
			{
				$header       = "From: test@email.com";
				$recipient    = "fyp21s230@gmail.com";
				$subject      = "User Feedback";
				$user_email   = clean_input($_POST["email"]);
				$user_message = clean_input($_POST["message"]); // Gets the "Name" of the field
				$user_name    = clean_input($_POST["name"]);
				
				$message = "Feedback is from: ".$user_name.
				           "\nEmail: ".$user_email.
						   "\n\nMessage: \n".$user_message; 
				
				// Using try-catch block to catch for errors
				try 
				{
					mail($recipient, $subject, $message, $header);
					echo "<script type='text/javascript'>alert('Feedback sent!');</script>";
				}
				// catch exception
				catch (Exception $e)
				{
					echo 'Message: ' . $e->getMessage();
				}
			}
		?>	
	</head>
	
	<body>
		<div class="center">
			<form method="POST" name="EmailForm">
				<!--Label is tied to "id" -->
				<label for="name">Name:</label><br> 
				<input id="name" type="text" name="name" size="20"  placeholder="JohnDoeAnderson" autocomplete="off" required><br><br>
				
				<label for="email">Enter your email:</label><br>
				<input type="email" id="email" name="email" placeholder="abc@gmail.com" autocomplete="off" required><br><br> 
				
				<label for="message">Message:</label><br>
				<!--Careful for textarea, as closing tag needs to be on same line if not there will be some whitespace -->
				<textarea id="message" name="message" rows="6" cols="30" placeholder="Type Message Here..." autocomplete="off" required></textarea><br><br> 
				<input type="submit" value="Submit" name="submit">
			</form>
		</div>
		<!--Include the footer -->
		<?php require_once 'Footer.php';?>
		
		<!--Prevent form resubmission -->
		<script>
			if ( window.history.replaceState ) 
			{
				window.history.replaceState( null, null, window.location.href );
			}
		</script>
	</body>
</html>

<!--In order to work, php.ini and sendmail.ini need to be configured -->
<!-- 
1. Go to XAMPP directory
2. Go to C:\xampp\php and open the php.ini file.
3. Find [mail function] by pressing ctrl + f.
4. Search and pass the following values:

SMTP=smtp.gmail.com
smtp_port=587
sendmail_from = YourGmailId@gmail.com
sendmail_path = "\"C:\xampp\sendmail\sendmail.exe\" -t"

5. Go to C:\xampp\sendmail and open sendmail.ini file.
6. Find [sendmail] by pressing ctrl + f.
7. Search and pass the following values:

smtp_server=smtp.gmail.com
smtp_port=587
error_logfile=error.log
debug_logfile=debug.log
auth_username=YourGmailId@gmail.com
auth_password=Your-Gmail-Password
force_sender=YourGmailId@gmail.com

-->
<!--How to configure php.ini and sendmail.ini -->
<!--https://meetanshi.com/blog/send-mail-from-localhost-xampp-using-gmail/ -->

<!--Links used: -->
<!--https://getbootstrap.com/docs/5.0/getting-started/download/ -->
<!--https://thisinterestsme.com/php-best-practises/ -->
<!--https://www.geeksforgeeks.org/how-to-call-php-function-on-the-click-of-a-button/ -->
<!--https://stackoverflow.com/questions/15965376/how-to-configure-xampp-to-send-mail-from-localhost -->
<!--https://www.w3schools.com/php/php_exception.asp -->
<!--https://blog.hubspot.com/marketing/html-form-email -->
<!--https://stackoverflow.com/questions/15965376/how-to-configure-xampp-to-send-mail-from-localhost -->
<!--https://www.w3schools.com/php/keyword_require_once.asp -->
<!--https://www.tutorialrepublic.com/php-tutorial/php-include-files.php -->
<!--https://www.w3schools.com/tags/att_textarea_required.asp -->
<!--https://www.w3schools.com/tags/att_input_required.asp -->
<!--https://stackoverflow.com/questions/2202999/why-is-textarea-filled-with-mysterious-white-spaces -->
<!--https://stackoverflow.com/questions/26599276/value-vs-placeholder-attributes-in-html -->
<!--https://www.w3schools.com/tags/att_input_placeholder.asp -->
<!--https://www.w3schools.com/php/php_form_validation.asp -->
<!--https://www.geeksforgeeks.org/concatenation-two-string-php/ -->

<!--Prevent form resubmission -->
<!--https://www.webtrickshome.com/faq/how-to-stop-form-resubmission-on-page-refresh -->

<!--CSS -->
<!--https://www.w3schools.com/css/css_align.asp -->



