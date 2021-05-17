<?php 
	// Include the navigation bar
	require_once("NavBar.php"); 
?>

<!-- 
User Story: 
#71 As a base user, I want to retrieve or change my password 
as I have lost my password.

Basic Function:
1) User keys in temporary password, username and new password (twice)             [DONE]
2) Temporary password is verified in the database with username                   [DONE in Users.php]
3) If matches, new password is hashed and overwrites                              [DONE in Users.php]
4) All temporary passwords associated with the username are cleared from database [DONE in Users.php]
5) Shows password reset success and user then redirected to login page            [DONE]

Design Goals:
- Should have basic html structure                                 [DONE]
- Should have form fields for keying in information                [DONE]
	UserID               [DONE]
	Temporary Password   [DONE]
	New Password         [DONE]
	Confirm New Password [DONE]
	
- Username can be stored in session so user need not re-key
- As used input is required, input validation is needed
  Do validation for User ID                                               [DONE]                                                
  Do validation for new password if its strong enough                     [DONE]
  Do validation if new password matches confirm new password              [DONE]
  
- Can only be accessed by non-login users                                 [DONE]
- Validate if "UserID" keyed in exists in database (users) when inserting [DONE in Users.php]
- User SHOULD NOT be able to "refresh" page to re-submit form             [DONE]
- Can only be accessed by non-login user                                  [DONE]
- Basic CSS Styling                                                       [DONE]
- Validate if UserID and hashed temporary password matches in database    [DONE in Users.php]
- Page can only be accessed by re-direct from "ForgetPasswordPage"
- Maybe upon successful execution, redirect user to "Login page"          [DONE]
-->

<!--This page is called from ForgetPasswordPage.php and from user email-->

<!--Php Code -->
<?php
	// Check if the user is logged in.
	// Only NON-logged in users are allowed to view this page
	if(isset($_SESSION['ID']))
	{
		echo '<script type="text/javascript"> location.replace("index.php")</script> ';
		die("Redirecting to index.php");
	}
	
	// Define Variables
	$error                     = "";
	$submit                    = "";
	$user_userid               = "";
	$user_temporary_password   = "";
	$user_new_password         = "";
	$user_confirm_new_password = "";
	$password_long_enough      = "";
	$password_has_number       = "";
	$password_has_uppercase    = "";
	$password_has_lowercase    = "";
	
	
	// Event Listener for submit button
	if (isset($_POST['ResetPasswordButton']))
	{
		$submit = false;
		
		// Checks if all of the fields are filled
		if(!empty($_POST["userid"]) and 
		   !empty($_POST["temporary_password"]) and
		   !empty($_POST["new_password"]) and
		   !empty($_POST["confirm_new_password"])
		  )
		{                          
			// Sanitize user's userid input
			$user_userid = filter_var($_POST["userid"], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			
			// No need to sanitize password fields as they are stored as hashes in database.
			
			// Extract variables from POST 
			$user_temporary_password   = $_POST["temporary_password"];
			$user_new_password         = $_POST["new_password"];
			$user_confirm_new_password = $_POST["confirm_new_password"];
			
			// Check if new password is strong enough
			$password_long_enough   = strlen($user_new_password) >= 8;
			$password_has_number    = preg_match('@[0-9]@', $user_new_password);
			$password_has_uppercase = preg_match('@[A-Z]@', $user_new_password);
			$password_has_lowercase = preg_match('@[a-z]@', $user_new_password);
			
			if($password_long_enough and 
			   $password_has_number and 
			   $password_has_uppercase and 
			   $password_has_lowercase
			  )
			{
				// Check if new password matches confirm new password
				if ($user_new_password == $user_confirm_new_password)
				{
					// Only when all checks are passed, then validation is successful
					$submit = true;
				}
				else { $error = "Passwords do not match!"; }
			}
			else { $error = "Password must be at least <b>8 characters in length </b>and must contain  at <b>least one number, at least one upper case letter and one lower case letter</b>"; }
		}
		elseif (empty($_POST["userid"]))               { $error = "UserID is required"; }               // Checks if UserID field is blank
		elseif (empty($_POST["temporary_password"]))   { $error = "Temporary Password is required"; }   // Checks if Temporary Password field is blank		
		elseif (empty($_POST["new_password"]))         { $error = "New Password is required"; }         // Checks if New Password field is blank
		elseif (empty($_POST["confirm_new_password"])) { $error = "Confirm New Password is required"; } // Checks of Confirm New Password field is blank
		else { $error = "Something broke, please re-enter details"; }
		
		// If validation is successful 
		if($submit)
		{
			// STOPPED HERE
			// DO MEETING MINUTES
			
			// Create new base user object
			$BaseUserObj = new BaseUser("Reset Password");
			
			// Call the method "ResetPassword" 
			$reset_password_result = $BaseUserObj->ResetPassword($user_userid, $user_temporary_password, $user_new_password);
			
			// Check if password reset was successful
			if($reset_password_result=="SUCCESS")
			{
				echo'<style> .ResetPassword_GUI{display:none;}</style>';
				echo "<script type='text/javascript'>alert('Password Successfully reset! Please try logging in.');</script>";

				// Redirect users to the next page.
				echo "<script type='text/javascript'> location.replace('LoginPage.php')</script> ";	
			}
			else { $error = "Error occured! Please retry!"; }
		}
	}
	else
	{
		// Reset variables
		$_POST["userid"]               = '';
		$_POST["temporary_password"]   = '';
		$_POST["new_password"]         = '';
		$_POST["confirm_new_password"] = '';
		$error                         = '';
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<style type="text/css">
			.input{
				width:200px;
			}
			.ResetPassword_GUI{
				margin: auto;
				width: 30%;
				border: 3px solid pink; 
				padding: 10px;
			}
		</style>
	</head>
	
	<body>
		<div class="ResetPassword_GUI">
			<!--Form-->
			<form method="post" name="resetPasswordForm">
			
				<p>Please key in your UserID and New Password.</p>
				<p>Do key in the Temporary password sent to your email.</p>
			
				<!--UserID-->
				<!--Label is tied to "id" -->
				<label for="userid">UserID:</label><br> 
				<input class="input" id="userid" type="text" name="userid" size="20"  placeholder="JohnDoeAnderson" autocomplete="off" required><br><br>
						
				<!--Temporary new password-->
				<label for="temporary_password">Temporary Password</label><br>
				<input class="input" id="temporary_password" type="password" name="temporary_password" placeholder="Enter Temporary Password" autocomplete="off" required><br><br>
				
				<!--New Password-->
				<label for="new_password">New Password</label><br>
				<input class="input" id="new_password" type="password" name="new_password" placeholder="Enter New Password" autocomplete="off" required><br><br>
				
				<!--Confirm New Password-->
				<label for="confirm_new_password">Confirm New Password</label><br>
				<input class="input" id="confirm_new_password" type="password" name="confirm_new_password" placeholder="Confirm New Password" autocomplete="off" required><br><br>
				
				<!--Submit Button-->
				<input type="submit" name="ResetPasswordButton" value="submit" name="submit" style="float:left;"/><br><br> 
				
				<!--Display Error message box-->
				<span class="error">&nbsp;&nbsp;<?php echo $error;?></span><br><br>
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

<!-- 
Links used:
PHP Logical Operators:
https://www.w3schools.com/php/php_operators.asp

Preventing SQL injection via PHP Data Objects (PDO):
https://dev.to/anastasionico/good-practices-how-to-sanitize-validate-and-escape-in-php-3-methods-139b
https://www.w3schools.com/php/php_mysql_prepared_statements.asp
https://www.php.net/manual/en/pdo.prepare.php
https://www.php.net/manual/en/pdo.prepared-statements.php

Sanitizing input fields:
https://stackoverflow.com/questions/4223980/the-ultimate-clean-secure-function/4224002#4224002
https://dev.to/anastasionico/good-practices-how-to-sanitize-validate-and-escape-in-php-3-methods-139b
https://www.geeksforgeeks.org/how-to-validate-and-sanitize-user-input-with-php/
https://www.w3schools.com/php/php_filter_advanced.asp

No need to sanitize password input fields:
https://stackoverflow.com/questions/45538138/is-it-advisable-to-clean-password-input-too

Validate password strength:
https://www.codexworld.com/how-to/validate-password-strength-in-php/
https://www.cluemediator.com/how-to-validate-password-strength-in-php
https://www.coding.academy/blog/how-to-use-regular-expressions-to-check-password-strength

CSS:
https://www.w3schools.com/howto/howto_css_login_form.asp
https://www.w3schools.com/css/css_form.asp
https://stackoverflow.com/questions/3381659/how-to-fix-the-size-of-password-input-field
https://stackoverflow.com/questions/33983718/adding-height-to-a-password-box-input/51709868


-->
