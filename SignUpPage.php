<html>
<style>
span{
	width:200px;
	color:red;
}
.SignUpForm * {
  vertical-align: middle;
}
</style>
<?php 
include("NavBar.php");
$SignUpFirstNameError = $SignUpContactError = $SignUpLastNameError = $SignUpIDError =  $SignUpEmailError =  $SignUpPasswordError =  $SignUpConfirmPasswordError = $SignUpAddressError = $SignUpDisplayNameError = $SignUpDOBError = ""; 
if(isset($_SESSION['ID'])){
	echo '<script> location.replace("index.php")</script> ';
}

$submit = true;


if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['SignUpButton'])){
	if(empty($_POST["SignUpFirstName"]))
	{
		$SignUpFirstNameError = "First name is required";
		$submit = false;
	}
	else{
		if(!preg_match("/^[a-zA-Z]*$/", $_POST["SignUpFirstName"])){
			$SignUpFirstNameError = "First name is invalid";
			$submit = false;
		}
	}
	if(empty($_POST["SignUpLastName"]))
	{
		$SignUpLastNameError = "Last name is required";
		$submit = false;
	}
	else{
		if(!preg_match("/^[a-zA-Z]*$/", $_POST["SignUpLastName"])){
			$SignUpLastNameError = "Last name is invalid";
			$submit = false;
		}
	}
	if(empty($_POST["SignUpEmail"]))
	{
		$SignUpEmailError = "Email is required";
		$submit = false;
	}
	else{
		if(!filter_var($_POST["SignUpEmail"], FILTER_VALIDATE_EMAIL)){
			$submit = false;
			$SignUpEmailError = "Invalid Email format";
		}
	}
	
	if(empty($_POST["SignUpID"]))
	{
		$SignUpIDError = "UserID is required";
		$submit = false;
	}
	else{
		if(!preg_match("/^[A-Za-z0-9]{8,20}$/i", $_POST["SignUpID"])){
			$submit = false;
			$SignUpIDError = "Invalid User ID ,requires at least 8 characters and 20 characters at maximum";
		}
	}
	
	if(empty($_POST["SignUpDisplayName"]))
	{
		$SignUpDisplayNameError = "Display name is required";
		$submit = false;
	}
	else{
		if(!preg_match("/^[A-Za-z0-9]{8,20}$/i",  $_POST["SignUpDisplayName"])){
			$submit = false;
			$SignUpDisplayNameError = "Invalid Display Name ,requires at least 8 characters and 20 characters at maximum";
		}
	}
	if(empty($_POST["SignUpAddress"]))
	{
		$SignUpAddressError = "Address is required";
		$submit = false;
	}
	
	if(empty($_POST["SignUpDOB"]))
	{
		$SignUpDOBError = "Date of birth is required";
		$submit = false;
	}	
	else{
		if(strtotime($_POST["SignUpDOB"]) > strtotime('now')) {
			$SignUpDOBError = "Invalid Date,date of birth must be before ". date('d/m/Y', strtotime(('now'))) ;
		}
	}
	
	if(empty($_POST["SignUpContact"]))
	{
		$SignUpContactError = "Phone Number is required";
		$submit = false;
	}
	else{
		if(!preg_match("/^[0-9]{8}$/",$_POST["SignUpContact"])) {
			$submit = false;
			$SignUpContactError = "Invalid Phone Number";
		}
	}
	
	if(empty($_POST["SignUpPassword"]))
	{
		$SignUpPasswordError = "Password is required";
		$submit = false;
	}
	else{
		if(!preg_match("/^(?!\d+$)[a-z0-9\'.]{8,16}$/",$_POST["SignUpPassword"])) {
			$submit = false;
			$SignUpPasswordError = "Password must contain 8 characters at least , with alphabets and numbers";
		}
		
	}
	
	if(empty($_POST["SignUpConfirmPassword"]))
	{
		$SignUpConfirmPasswordError = "Confirm Password is required";
		$submit = false;
	}
	else{
		
		if(strcmp($_POST["SignUpPassword"],$_POST["SignUpConfirmPassword"])!=0){
		
			$SignUpConfirmPasswordError = "Passwords do not match";
			$submit = false;
		}
	}
	
	if($submit){
		require_once("Users.php");
		$BaseUserOBJ = new BaseUser("SignUp");
		if($BaseUserOBJ->SignUpValidate($_POST["SignUpID"],$_POST["SignUpEmail"],$_POST["SignUpPassword"],$_POST["SignUpFirstName"],$_POST["SignUpLastName"],$_POST["SignUpContact"],$_POST["SignUpDisplayName"],$_POST["SignUpDOB"],$_POST["SignUpAddress"])=="validated"){
			echo '<script> alert("Successfully Signed Up! Please login now")</script> ';
			echo'<style> input[name="SignUp_GUI"]{display:none;}</style>';
			echo '<b>This is your public key associated with your account:</b>';
			echo $BaseUserOBJ->getPubKey();
		    echo '</br><b>This is your private key associated with your account,PLEASE DO NOT LOSE IT:</b>';
			echo $BaseUserOBJ->getPrivate();
			echo '<form action="LoginPage.php" method="post"> <input type="submit" value="Login Now"></form> ';
			exit();
		}
		else if($BaseUserOBJ->SignUpValidate($_POST["SignUpID"],$_POST["SignUpEmail"],$_POST["SignUpPassword"],$_POST["SignUpFirstName"],$_POST["SignUpLastName"],$_POST["SignUpContact"],$_POST["SignUpDisplayName"],$_POST["SignUpDOB"],$_POST["SignUpAddress"])=="UserID error"){
			$SignUpIDError = "UserID already exists";
		}
		else if($BaseUserOBJ->SignUpValidate($_POST["SignUpID"],$_POST["SignUpEmail"],$_POST["SignUpPassword"],$_POST["SignUpFirstName"],$_POST["SignUpLastName"],$_POST["SignUpContact"],$_POST["SignUpDisplayName"],$_POST["SignUpDOB"],$_POST["SignUpAddress"])=="Email error"){
			$SignUpEmailError = "Email already exists";
		}
	}
}
else{
$_POST["SignUpID"]  = "";
$_POST["SignUpDisplayName"]  = "";
$_POST["SignUpFirstName"]  = "";
$_POST["SignUpLastName"]  = "";
$_POST["SignUpEmail"]  = "";
$_POST["SignUpContact"]  = "";
$_POST["SignUpAddress"]  = "";
$_POST["SignUpDOB"]  = "";
$_POST["SignUpPassword"]  = "";
$_POST["SignUpConfirmPassword"]  = "";
}
?>
<div class="SignUp_GUI">
<form class ="SignUpForm" method="post">
<span class="error"></span><br /><br />
<label>User ID:</label><input type="text" name="SignUpID" value = <?php echo $_POST["SignUpID"] ; ?>>
<span class="error">&nbsp;&nbsp;<?php echo $SignUpIDError;?></span><br /><br />

<label>Display Name:</label><input type="text" name="SignUpDisplayName" value = <?php echo $_POST["SignUpDisplayName"] ; ?>>
<span class="error">&nbsp;&nbsp;<?php echo $SignUpDisplayNameError;?></span><br /><br />

<label>First Name:</label><input type="text" name="SignUpFirstName" value = <?php echo $_POST["SignUpFirstName"] ; ?>>
<span class="error">&nbsp;&nbsp;<?php echo $SignUpFirstNameError;?></span><br /><br />

<label>Last Name:</label><input type="text" name="SignUpLastName" value = <?php echo $_POST["SignUpLastName"] ; ?>>
<span class="error">&nbsp;&nbsp;<?php echo $SignUpLastNameError;?></span><br /><br />

<label>Email:</label><input type="text" name="SignUpEmail" value = <?php echo $_POST["SignUpEmail"] ; ?>>
<span class="error">&nbsp;&nbsp;<?php echo $SignUpEmailError;?></span><br /><br />

<label>Contact Number:</label><input type="text" name="SignUpContact" value = <?php echo $_POST["SignUpContact"] ; ?>>
<span class="error">&nbsp;&nbsp;<?php echo $SignUpContactError;?></span><br /><br />

<label>Address:</label><textarea rows="4" cols="50" name="SignUpAddress"><?php echo $_POST["SignUpAddress"] ; ?></textarea>
<span class="error">&nbsp;&nbsp;<?php echo $SignUpAddressError;?></span><br /><br />

<label>Date Of Birth:</label><input type="date" name="SignUpDOB" value = <?php echo $_POST["SignUpDOB"] ; ?>>
<span class="error">&nbsp;&nbsp;<?php echo $SignUpDOBError;?></span><br /><br />

<label>Password:</label><input type="password" name="SignUpPassword" value = <?php echo $_POST["SignUpPassword"] ; ?>>
<span class="error">&nbsp;&nbsp;<?php echo $SignUpPasswordError;?></span><br /><br />

<label>Confirm Password:</label><input type="password" name="SignUpConfirmPassword"  value = <?php echo $_POST["SignUpConfirmPassword"] ; ?>>
<span class="error">&nbsp;&nbsp;<?php echo $SignUpConfirmPasswordError;?></span><br /><br />



<input type="Submit" name="SignUpButton" value="Sign Up"/></br>
</form>
</div>
</html>
