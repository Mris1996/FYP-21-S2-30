<?php
	require_once("NavBar.php");
	
	redirectUsersToIndexIfTheyAreLoggedIn();
	
	function redirectUsersToIndexIfTheyAreLoggedIn() {
		if(isset($_SESSION['ID'])) {
			echo '<script> location.replace("index.php")</script> ';
		}
	}
	
?>

<!doctype html>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<style>
			label {
				display:inline-block;
				width:200px;
				margin-right:30px;
				text-align:center;
			}
			
			input[name="LoginButton"] {
				margin-left:auto;
				margin-right:auto;
				font-size:20px;
				color:white;
				background-color:black;
			}

			fieldset {
				border:none;
				width:500px;
				margin:0px auto;
			}
			
			span{
				color:blue;
			}
			
			input[type="text"],[type="password"] {
				width:200px;
			}
			
			#container {
				margin-top:5%;
				width:1000px;
				height:700px;
				border-radius:20px;
				border:2px solid purple;
				margin-left:25%;
				overflow: hidden;
				box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
			}
			
			#innercontainer {	
				background-repeat: no-repeat; /* Do not repeat the image */
				background-size: cover;       /* Resize the background image to cover the entire container */
				background-image: url('ads/LoginAds.jpg');
				width:498px;
				height:100%;
				background-color:#4b0082;
				float: right;
			}
			
			#Login_GUI {	
				margin-top:15%;
				width:498px;
				height:400px;
				float: left;
				font-size:20px;
			}
			
			#Login_GUI input {
				height:40px;
			}
			
			#Login_GUI input[type=submit] {
				display:inline-block;
				border:none;
				font-family: 'Roboto';
				background-color:purple;
				color:white;
				height:50px;
				font-size:30px;
				width:400px;
				margin-top:5px;
				border-radius:40px;
				margin-right:10px;
			}
			
			#Login_GUI input[type=submit]:hover {
				outline:60%;
				filter: drop-shadow(0 0 5px purple);
			}
		</style>
		
		<title>Login Page</title>
		
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
		
	</head>

	<body>
		<?php
			// Event Listeners
			redirectUsersToSignUpIfButtonIsClicked();
			
			$systemMessage = "";
			try {
				processFormSubmission();
			} catch (Exception $e) {
				$systemMessage = $e->getMessage() . "\n";
			}
		?>
		
		<div id="container">
			<div id="Login_GUI">
				<form method="post" style="text-align:center;">
					
					<a href="index.php">
						<img src="systemimages/STIClogo.jpg" class="image" style="object-fit:cover;width:200px;height:100px;border-radius:10px">
					</a>
					
					<br>
					<br>
					
					<label for="Login_LoginID">User ID:</label>
					<input type="text" name="Login_LoginID" id="Login_LoginID">

					<br>
					<br>
					
					<label for="Login_Password">Password:</label>
					<input type="password" name="Login_Password" id="Login_Password">
					
					<br>
					<br>
					
					<div name="g-recaptcha" id="g-recaptcha" class="g-recaptcha" style="display: inline-block;" data-sitekey="6LcDyJEbAAAAAC_bjYEO7omDdzl84cHUVsUTWEOf"></div>
	
					<br>
					
					<span class="error">
						<?php 
							echo $systemMessage; 
						?>
					</span>
					
					<br>
					
					<input type="Submit" name="LoginButton" value="Login">
					<input type = "Submit" name="SignupButton" value ="Sign Up"> 
					
					<br>
					
					<a href="ForgetPasswordPage.php" style="text-align:center;">Forgot password?</a>
				</form>
			</div>
			
			<div id="innercontainer">
			</div>
		
		</div>
		
	</body>
</html>

<?php 
	function redirectUsersToSignUpIfButtonIsClicked() {
		if(isset($_POST['SignupButton'])) {
			echo '<script> location.replace("SignUpPage.php")</script> ';	
		}
	}
	
	function processFormSubmission() {
		
		$processingOutcome = false;
		$processingOutcome = validateFormFields();
		
		if($processingOutcome) {	
			$BaseUserOBJ = new BaseUser("Login");
			
			if(userCredentialsAreValid($BaseUserOBJ)) {
				if(statusOfAccountIsSuspended($BaseUserOBJ)) {
					if(accountIsNoLongerSuspended($BaseUserOBJ)) {
						removeSuspensionRecordFromDatabase($BaseUserOBJ);
						setSessionVariables($BaseUserOBJ);
						redirectUserToIndexPage();	
					}
				} else if(statusOfAccountIsBanned($BaseUserOBJ)) {
					throw new Exception("Account has been banned!");
				} else {
					setSessionVariables($BaseUserOBJ);
					redirectUserToIndexPage();
				}
			}
		}		
	}
	
	function validateFormFields() {
		if(postAndLoginButtonAreSelected()) {
			if(recaptchaIsNotEmpty()) {
				if(recaptchaIsValid()) {
					if(userIdFieldIsNotEmpty()) {
						if(loginPasswordFieldIsNotEmpty()) {
							return true;
						}
					}
				}
			}	
		}
		return false;
	}
	
	function postAndLoginButtonAreSelected() {
		if($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['LoginButton'])) {
			return true;
		} else {
			return false;
		}
	}
	
	function recaptchaIsNotEmpty() {
		if(isset($_POST["g-recaptcha-response"])) {
			return true;
		} else {
			throw new Exception("reCAPTCHA verification is empty! Please try again!");
			return false;
		}
	}
	
	function recaptchaIsValid() {
		
		$queryRecaptchaUrl = constructRecaptchaQuery();
		$resultOfRecaptcha = getRecaptchaResults($queryRecaptchaUrl);		
		$recaptchaResponse = processRecaptchaResults($resultOfRecaptcha);

		if ($recaptchaResponse->success) {
			return true;
		} else {
			throw new Exception("reCAPTCHA verification Failed! Please try again!");
			return false;
		}
	}
	
	function constructRecaptchaQuery() {
		$secretKey = "6LcDyJEbAAAAAHe9yoguZglIch89VbhUsZVQEMdQ";
		$token = $_POST["g-recaptcha-response"];
		$ip = $_SERVER["REMOTE_ADDR"];
		$url = "https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$token."&remoteip=".$ip;

		return $url;
	}
	
	function getRecaptchaResults($queryRecaptchaUrl) {
		return file_get_contents($queryRecaptchaUrl);
	}
	
	function processRecaptchaResults($resultOfRecaptcha) {
		return json_decode($resultOfRecaptcha);
	}
	
	function userIdFieldIsNotEmpty() {
		if(!empty($_POST["Login_LoginID"])) {
			return true;
		} else {
			throw new Exception("UserID is required!");
			return false;
		}
	}
	
	function loginPasswordFieldIsNotEmpty() {
		if(!empty($_POST["Login_Password"])) {
			return true;
		} else {
			throw new Exception("Password is required!");
			return false;
		}
	}
	
	function userCredentialsAreValid(&$BaseUserOBJ) {
		if($BaseUserOBJ->LoginValidate($_POST["Login_LoginID"],$_POST["Login_Password"])) {
			return true;
		} else {
			throw new Exception("UserID/Password is wrong!");
			return false;
		}
	}
	
	function statusOfAccountIsSuspended(&$BaseUserOBJ) {
		if (json_decode($BaseUserOBJ->Status)[0]=="Suspended") {
			return true;
		} else {
			return false;
		}
	}
	
	function accountIsNoLongerSuspended(&$BaseUserOBJ) {
		
		$currentDateTime = getCurrentDateTime();
		$banDeadline = getBanDeadline($BaseUserOBJ);
		
		if($currentDateTime > $banDeadline) {
			return true;
		} else {
			$formattedBanDeadlne = formatDate($banDeadline);
			throw new Exception("Account has been suspended till ".$formattedBanDeadlne."");
			return false;
		}
	}
	
	function getCurrentDateTime() {
		return strtotime("now");
	}
	
	function getBanDeadline(&$BaseUserOBJ) {
		return strtotime(json_decode($BaseUserOBJ->Status)[1]);
	}
	
	function formatDate(&$banDeadline) {
		return date("d/m/Y", $banDeadline);
	}
	
	function removeSuspensionRecordFromDatabase(&$BaseUserOBJ) {
		$AdminObj = new Admin($BaseUserOBJ);
		$AdminObj ->RemoveStatus($BaseUserOBJ->getUID());
	}
		
	function statusOfAccountIsBanned(&$BaseUserOBJ) {
		if (json_decode($BaseUserOBJ->Status)[0]=="Banned") {
			return true;
		} else {
			return false;
		}
	}
	
	function setSessionVariables(&$BaseUserOBJ) {
		setSessionId($BaseUserOBJ);
		setSessionType($BaseUserOBJ);
		
		addNewLineToSessionVariable();
		
		setSessionObjectAccordingToType($BaseUserOBJ); 
	}
	
	function setSessionId(&$BaseUserOBJ) {
		$_SESSION['ID'] = $BaseUserOBJ->getUID();
	}
	
	function setSessionType(&$BaseUserOBJ) {
		$_SESSION['Type'] = $BaseUserOBJ->getAccountType();
	}
	
	function addNewLineToSessionVariable() {
		echo'<script>history.pushState({}, "", "")</script>';
	}
	
	function setSessionObjectAccordingToType(&$BaseUserOBJ) {
		if($_SESSION['Type']=="Standard") {
			setSessionObjectToStandardUser($BaseUserOBJ);
		}
		
		if($_SESSION['Type']=="Administrator") {
			setSessionObjectToAdministratorUser($BaseUserOBJ);
		}
	}
	
	function setSessionObjectToStandardUser(&$BaseUserOBJ) {
		$UserObj = new StandardUser($BaseUserOBJ); // Downcasting to child class 
		$_SESSION['Object'] = $UserObj; 
	}
	
	function setSessionObjectToAdministratorUser(&$BaseUserOBJ) {
		$AdminObj = new Admin($BaseUserOBJ); // Downcasting to child class 
		$_SESSION['Object'] = $AdminObj;
	}
	
	function redirectUserToIndexPage() {
		echo '<script> location.replace("index.php")</script> ';
		exit();
	}
	
?>


<!--Links Used:-->
<!-- 
Base Structure of a HTML Page
https://www.w3schools.com/html/html5_syntax.asp

Pass by reference
https://www.php.net/manual/en/language.references.pass.php

History.pushState
https://developer.mozilla.org/en-US/docs/Web/API/History/pushState

"Center" tag is deprecated
https://www.w3schools.com/tags/tag_center.asp

Alternatives to "Center" tag
https://developer.mozilla.org/en-US/docs/Web/HTML/Element/center

Setting up ReCAPTCHA V3
https://www.youtube.com/watch?v=s8oe8RpVWJg&ab_channel=Learn-and-Share
https://developers.google.com/recaptcha/docs/v3      // Client Side Integration
https://developers.google.com/recaptcha/docs/verify  // Server Side Integration

Debug ReCAPTCHA V3
https://developers.google.com/recaptcha/docs/faq#localhost_support
https://stackoverflow.com/questions/3232904/using-recaptcha-on-localhost

<pre> tag
https://www.w3schools.com/tags/tag_pre.asp

Setting up ReCAPTCHA V2 (Similar to V3 setup)
https://www.youtube.com/watch?v=5o7Q4qvimWM
https://developers.google.com/recaptcha/docs/display // Client Side Integration
https://developers.google.com/recaptcha/docs/verify  // Server Side Integration
https://developers.google.com/recaptcha/docs/faq    

How to style the ReCAPTCHA V2 box using CSS
https://ourcodeworld.com/articles/read/781/how-to-center-recaptcha-element-with-css

-->
