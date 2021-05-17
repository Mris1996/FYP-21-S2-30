<?php 
	// Include the navigation bar
	require_once("NavBar.php"); 
	// Use require_once over include so that if the NavBar has been added 
	// previously, it will not add it in again.
	
	// The session_start() function must be the very first thing in 
	// your document. Before any HTML tags.
	// Since session_start is in NavBar.php,
	// it has to be the first thing in the file before any html
?>
<!-- 
User Story: 
#71 As a base user, I want to retrieve or change my password 
as I have lost my password.

Basic Function:
1) It is a page where user can key in username and email                           [DONE]
2) Will generate temporary password and salt                                       [DONE in Users.php]
3) Store username and hashed temporary password in database                        [DONE in Users.php]
   - Before storing, can validate if temporary password table has rows with 
     the corresponding user ID, this to prevent duplicate records.                 [DONE in Users.php]
   - If have duplicate can delete that one off first then add in new record        [DONE in Users.php]
4) Send temporary password to specified email address                              [DONE in Users.php]  
5) Redirect user to password reset page.

Design Goals:
- Should have form fields for keying in UserID and email                           [DONE]
- Should have basic html structure                                                 [DONE]
- As user input is required; input validation is needed                            [DONE]
  Do validation for User ID                                                        [DONE]
  Do validation for Email                                                          [Already there; added extra layer]
- Can only be accessed by non-login users                                          [DONE]
- basic CSS Styling                                                                [DONE]
- Validate if "UserID" keyed in exists in database (users)                         [DONE in Users.php]
- User SHOULD NOT be able to "refresh" page to resubmit form                       [DONE]
- Should only be accessible when redirected from "login page"
- Upon successful execution, redirect user to "password reset page"                [DONE]
-->

<!--This page is called from LoginPage.php-->

<!--Php Code -->
<?php
	// Check if the user is logged in.
	// Only NON-logged in users are allowed to view this page
	if(isset($_SESSION['ID']))
	{
		echo '<script> location.replace("index.php")</script> ';
		// "header" is preferred to "echo" JavaScript
		// That said because header has been set by session_start in NavBar.php
		// Therefore, we have to use "location.replace" instead.
		// If "header" is used, it will generate errors.
		
		// "die" is important, so to exit the current script 
		die("Redirecting to index.php");
	}

	// Define Variables
	$BaseUserObj = "";
	$EmailErr    = "";
	$mailResult  = "";
	$submit      = "";
	$user_email  = "";
	$user_userid = "";
	
	// Event Listener for submit button
	if(isset($_POST['ForgetButton']))
	{
		$submit = false;
		
		// Re-coded based on "On Default Deny" secure design
		if (!empty($_POST["userid"]) and !empty($_POST["ForgetPassEmail"]))
		{
			// Sanitize user's userid input
			$user_userid = filter_var($_POST["userid"], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			
			// Sanitize user's email input
			$user_email = filter_var($_POST["ForgetPassEmail"], FILTER_SANITIZE_EMAIL);
			
			// Re-design to "On Default Deny" secure design
			if(filter_var($user_email, FILTER_VALIDATE_EMAIL)) // Validate email address
			{
				// Only when all checks are passed, then validation is successful
				$submit = true;
			}
			else { $EmailErr = "Invalid Email format"; }
		}
		elseif (empty($_POST["userid"]))          { $EmailErr = "UserID is required"; } // Checks if the UserID field is blank
		elseif (empty($_POST["ForgetPassEmail"])) { $EmailErr = "Email is required";  } // Checks if email field is blank 
		else { $EmailErr = "Something broke, please re-enter details"; }
		
		// If validation is successful 
		if($submit)
		{
			// Create new base user object 
			$BaseUserObj = new BaseUser("Forget Password");
			// Cannot use default constructor as it is not set in "Users.php".
			// Also PHP does not support overloading as well as Java even though it is an OOP language.
			
			// Code has been re-done so it only executes once and not twice so 
			// it saves memory space and prevents sending email twice
			$mailResult = $BaseUserObj->ForgetPassword($user_userid, $user_email);
			// Call the method "ForgetPassword" ^^

			// Check if Mail was sent successfully
			if($mailResult=="SUCCESS")
			{
				echo'<style> .ForgetPassword_GUI{display:none;}</style>';
				echo "<script type='text/javascript'>alert('Please check your email to reset your password');</script>";

				// Redirect users to the next page.
				echo "<script type='text/javascript'> location.replace('PasswordResetPage.php')</script> ";	
			}
			else { $EmailErr = "Error occured! Please retry!"; }
		}		
	}
	else
	{
		// Reset variables
		$_POST["userid"] = '';
		$_POST["ForgetPassEmail"] = '';
		$EmailErr = '';
	}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<style type="text/css">
			.center {
				margin: auto;
				width: 30%;
				border: 3px solid blue; 
				padding: 10px;
			}
		</style>
	</head>
	
	<body>
		<!--Div class here is turned "off" later to display email sent message -->
		<div class="ForgetPassword_GUI center">
			<form method="post" name="recoverPasswordForm">
			
				<p>Please key in your UserID and email address.</p>
				<p>We will send you an email to reset your password.</p>
			
				<!--UserID-->
				<!--Label is tied to "id" -->
				<label for="userid">UserID:</label><br> 
				<input id="userid" type="text" name="userid" size="20"  placeholder="JohnDoeAnderson" autocomplete="off" required><br><br>
				
				<!--Email-->
				<label for="email">Email:</label><br>
				<input type="email" id="email" name="ForgetPassEmail" placeholder="abc@gmail.com" autocomplete="off" required><br><br>
				
				<!--Submit Button-->
				<input type="submit" name="ForgetButton" value="submit" name="submit" style="float:left;"/><br><br> 
				
				<!--Display Error message box-->
				<span class="error">&nbsp;&nbsp;<?php echo $EmailErr;?></span><br><br>
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
https://blog.tbhcreative.com/2015/08/10-best-practices-in-html.html
https://developer.mozilla.org/en-US/docs/Learn/CSS/Howto/CSS_FAQ

Secure Design:
https://wiki.sei.cmu.edu/confluence/display/seccode/Top+10+Secure+Coding+Practices
https://www.sitepoint.com/community/t/if-not-logged-in-redirect/27902
https://www.geeksforgeeks.org/how-to-redirect-a-user-to-the-registration-if-he-has-not-logged-in/
https://www.geeksforgeeks.org/php-die-sleep-functions/
https://www.w3schools.com/jsref/met_loc_replace.asp

Sanitization of input fields:
https://magemastery.net/courses/user-registration-with-php-mysql/form-validation
https://www.w3schools.com/php/filter_sanitize_string.asp
https://www.w3schools.com/php/php_form_validation.asp
https://www.php.net/manual/en/filter.filters.sanitize.php
https://forums.phpfreaks.com/topic/275315-htmlspecialchars-vs-filter_sanitize_special_chars/
https://www.w3schools.com/php/func_filter_var.asp
https://www.w3schools.com/php/func_var_unset.asp

Constructors and Overloading:
https://www.geeksforgeeks.org/php-constructors-and-destructors/
https://www.amitmerchant.com/multiple-constructors-php/
https://www.geeksforgeeks.org/function-overloading-and-overriding-in-php/

Sending mail:
https://www.w3schools.com/php/func_mail_mail.asp
-->

<!-- 
Extra un-used code:

// strip special characters (May be deprecated, so delete off if not in use)
// Use "filter_var" instead for validation
/*
function clean_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
*/
-->