<?php require_once("NavBar.php");

if(!isset($_SESSION['ID'])){
	echo '<script> location.replace("index.php")</script> ';
}



?>
<style>
span{
	width:200px;
	color:red;
}
.SignUpForm * {
  vertical-align: middle;
}

.centerBox {
	margin: auto;
	width: 40%;
	/* border: 3px solid #73AD21; */
	padding: 10px;
}

label, input, textarea {	
	display: inline-block; /* In order to define widths */
}

label {
	width: 30%;
	text-align: right;    /* Positions the label text beside the input */
}

label+input+textarea {
	width: 30%;
	
	/* Large margin-right to force the next element to the new-line
    and margin-left to create a gutter between the label and input */
		
	/* Margin: 0% for top, 30% for right, 0% for bottom, 4% for left */
	margin: 0 30% 0 4%;
}



</style>
<button class="EditProfile">Edit Profile</button>
<button class="ChangePassword">Change Password</button>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $(".EditProfile").click(function(){
    $(".EditProfile_GUI").show();
	$(".ChangePassword_GUI").hide();
  });
  $(".ChangePassword").click(function(){
    $(".EditProfile_GUI").hide();
	$(".ChangePassword_GUI").show();
  });

});
</script>
<hr>
<?php 
$submit = true;
$EditProfileFirstNameError = $EditProfileContactError = $EditProfileLastNameError  =  $EditProfileEmailError =  $EditProfileAddressError = $EditProfileDisplayNameError  = ""; 

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['EditProfileButton'])){
	$EditProfile  = true;
	if(empty($_POST["EditProfileFirstName"]))
	{
		$EditProfileFirstNameError = "First name is required";
		$submit = false;
	}
	else{
		if(!preg_match("/^[a-zA-Z]*$/", $_POST["EditProfileFirstName"])){
			$EditProfileFirstNameError = "First name is invalid";
			$submit = false;
		}
	}
	if(empty($_POST["EditProfileLastName"]))
	{
		$EditProfileLastNameError = "Last name is required";
		$submit = false;
	}
	else{
		if(!preg_match("/^[a-zA-Z]*$/", $_POST["EditProfileLastName"])){
			$EditProfileLastNameError = "Last name is invalid";
			$submit = false;
		}
	}
	if(empty($_POST["EditProfileEmail"]))
	{
		$EditProfileEmailError = "Email is required";
		$submit = false;
	}
	else{
		if(!filter_var($_POST["EditProfileEmail"], FILTER_VALIDATE_EMAIL)){
			$submit = false;
			$EditProfileEmailError = "Invalid Email format";
		}
	}
	
	if(empty($_POST["EditProfileDisplayName"]))
	{
		$EditProfileDisplayNameError = "Display name is required";
		$submit = false;
	}
	else{
		if(!preg_match("/^[A-Za-z0-9]{8,20}$/i",  $_POST["EditProfileDisplayName"])){
			$submit = false;
			$EditProfileDisplayNameError = "Invalid Display Name ,requires at least 8 characters and 20 characters at maximum";
		}
	}
	if(empty($_POST["EditProfileAddress"]))
	{
		$EditProfileAddressError = "Address is required";
		$submit = false;
	}
	
	
	if(empty($_POST["EditProfileContact"]))
	{
		$EditProfileContactError = "Phone Number is required";
		$submit = false;
	}
	else{
		if(!preg_match("/^[0-9]{8}$/",$_POST["EditProfileContact"])) {
			$submit = false;
			$EditProfileContactError = "Invalid Phone Number";
		}
	}
	
	if($submit){
		if($_POST["EditProfileDisplayName"] == $_SESSION['Object']-> getDisplayName() && $_POST["EditProfileFirstName"] == $_SESSION['Object']-> getFirstName() && $_POST["EditProfileLastName"] == $_SESSION['Object']-> getLastName() && $_POST["EditProfileEmail"] == $_SESSION['Object']-> getEmail() && $_POST["EditProfileContact"] == $_SESSION['Object']-> getContactNumber() && $_POST["EditProfileAddress"]  == $_SESSION['Object']-> getAddress()){
			$EditProfile = false;
			echo'<script>alert("No changes were made")</script>';
			echo '<script> location.replace("SettingsPage.php")</script> ';
		}
		else{
			if($_SESSION['Object']->EditProfileValidate($_POST["EditProfileEmail"],$_POST["EditProfileFirstName"],$_POST["EditProfileLastName"],$_POST["EditProfileContact"],$_POST["EditProfileDisplayName"],$_POST["EditProfileAddress"])=="validated"){
				$EditProfile = false;
				echo'<script>alert("Successfully updated your profile, please check your profile")</script>';
				$_SESSION['Object']->setUID($_SESSION['Object']->getUID());
				echo '<script> location.replace("SettingsPage.php")</script> ';
				
				
			}
			else if($_SESSION['Object']->EditProfileValidate($_POST["EditProfileEmail"],$_POST["EditProfileFirstName"],$_POST["EditProfileLastName"],$_POST["EditProfileContact"],$_POST["EditProfileDisplayName"],$_POST["EditProfileAddress"])=="Email error"){
				$EditProfileEmailError = "Email already exists";
				$EditProfile = false;
			}
		}
	}
}
else{
$_POST["EditProfileDisplayName"]  = "";
$_POST["EditProfileFirstName"]  = "";
$_POST["EditProfileLastName"]  = "";
$_POST["EditProfileEmail"]  = "";
$_POST["EditProfileContact"]  = "";
$_POST["EditProfileAddress"]  = "";
$EditProfile = false;
}
if(!$EditProfile){
echo'<style> .EditProfile_GUI{display:none;}</style>';	
}
?>

<div class="EditProfile_GUI">
<form class ="EditProfileForm" method="post">
<span class="error"></span><br /><br />
<div class="centerBox">
	<center><h1>Edit Profile<h1></center>
	<label>Display Name:</label>
	<input type="text" name="EditProfileDisplayName" value = <?php echo $_SESSION['Object']->getDisplayName() ; ?>>
	<span class="error">&nbsp;&nbsp;<?php echo $EditProfileDisplayNameError;?></span><br /><br />

	<label>First Name:</label>
	<input type="text" name="EditProfileFirstName" value = <?php echo $_SESSION['Object']->getFirstName(); ?>>
	<span class="error">&nbsp;&nbsp;<?php echo $EditProfileFirstNameError;?></span><br /><br />

	<label>Last Name:</label>
	<input type="text" name="EditProfileLastName" value = <?php echo $_SESSION['Object']->getLastName(); ?>>
	<span class="error">&nbsp;&nbsp;<?php echo $EditProfileLastNameError;?></span><br /><br />

	<label>Email:</label>
	<input type="text" name="EditProfileEmail" value = <?php echo $_SESSION['Object']->getEmail(); ?>>
	<span class="error">&nbsp;&nbsp;<?php echo $EditProfileEmailError;?></span><br /><br />

	<label>Contact Number:</label>
	<input type="text" name="EditProfileContact" value = <?php echo $_SESSION['Object']->getContactNumber(); ?>>
	<span class="error">&nbsp;&nbsp;<?php echo $EditProfileContactError;?></span><br /><br />

	<label style=" vertical-align: middle;">Address:</label>
	<textarea rows="4" cols="50" name="EditProfileAddress"><?php echo $_SESSION['Object']->getAddress(); ; ?></textarea>
	<span class="error">&nbsp;&nbsp;<?php echo $EditProfileAddressError;?></span><br /><br />


	<input type="Submit" name="EditProfileButton" value="Done" style="float:right;"/></br> 
</form>
</div>
<hr>
</div>

<?php 

$ChangePasswordPasswordError = $ChangePasswordNewPasswordError = $ChangePasswordNewConfirmPasswordError = "";
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ChangePasswordButton'])){
$ChangePassword = true;
$submit2 = true;
		if(empty($_POST["ChangePasswordNewPassword"]))
		{
			$ChangePasswordNewPasswordError = "New password is required";
			$submit2 = false;
		}
		else{
		
		if ( strlen($_POST["ChangePasswordNewPassword"]) < 8 ) {
			$submit2 = False;
			$SignUpPasswordError = "Password must contain 8 characters at least , with alphabets and numbers";
		}

		if ( !preg_match("#[0-9]+#", $_POST["ChangePasswordNewPassword"]) ) {
		
			$submit2 = False;
			$SignUpPasswordError = "Password must contain 8 characters at least , with alphabets and numbers";
		}

		if ( !preg_match("#[a-z]+#", $_POST["ChangePasswordNewPassword"]) ) {
	
			$submit2 = False;
			$SignUpPasswordError = "Password must contain 8 characters at least , with alphabets and numbers";
		}


		
	}

		if(empty($_POST["ChangePasswordNewConfirmPassword"]))
		{
			$ChangePasswordNewConfirmPasswordError = "Confirm Password is required";
			$submit2 = false;
		}
		else{

		if(strcmp($_POST["ChangePasswordNewPassword"],$_POST["ChangePasswordNewConfirmPassword"])!=0){

			$ChangePasswordNewConfirmPasswordError = "Passwords do not match";
			$submit2 = false;
		}
		}
		if($submit2){
		$ChangePassword = false;
		if($_SESSION['Object']->ChangePasswordValidate($_POST["ChangePasswordPassword"],$_POST["ChangePasswordNewPassword"],$_POST["ChangePasswordNewConfirmPassword"]) =="Validated"){
			echo'<style> alert("Password Changed Successfully!Please login again")</style>';
			$_SESSION['ID']=NULL;
			session_destroy();
			echo '<script> location.replace("LoginPage.php")</script> ';
			exit();
			
		}
		else{
			$ChangePasswordPasswordError = "Incorrect password";
			$ChangePassword = true;
		}
		}
}
else{
	$ChangePassword = false;
}
if(!$ChangePassword){
echo'<style> .ChangePassword_GUI{display:none;}</style>';	
}




?>

<div class="ChangePassword_GUI">
<form method="post">
<span class="error"></span><br /><br />
<div class="centerBox">
	<center><h1>Change Password<h1></center>
	<label>Password:</label>
	<input type="password" name="ChangePasswordPassword">
	<span class="error">&nbsp;&nbsp;<?php echo $ChangePasswordPasswordError;?></span><br /><br />
	
	<label>New Password:</label>
	<input type="password" name="ChangePasswordNewPassword">
	<span class="error">&nbsp;&nbsp;<?php echo $ChangePasswordNewPasswordError;?></span><br /><br />

	<label>Confirm new Password:</label>
	<input type="password" name="ChangePasswordNewConfirmPassword">
	<span class="error">&nbsp;&nbsp;<?php echo $ChangePasswordNewConfirmPasswordError;?></span><br /><br />

	<input type="Submit" name="ChangePasswordButton" value="Change Password" style="float:right;"/></br> 
</form>
</div>
<hr>