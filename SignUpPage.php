<html>
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
		
		if ( strlen($_POST["SignUpPassword"]) < 8 ) {
			$submit = False;
			$SignUpPasswordError = "Password must contain 8 characters at least , with alphabets and numbers";
		}

		if ( !preg_match("#[0-9]+#", $_POST["SignUpPassword"]) ) {
			echo"asssdx";
			$submit = False;
			$SignUpPasswordError = "Password must contain 8 characters at least , with alphabets and numbers";
		}

		if ( !preg_match("#[a-z]+#", $_POST["SignUpPassword"]) ) {
			echo"asd";
			$submit = False;
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
			echo '<script> location.replace("LoginPage.php")</script> ';
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

<div class="centerBox">
	<label>User ID:</label>
	<input type="text" name="SignUpID" value = <?php echo $_POST["SignUpID"] ; ?>>
	<span class="error">&nbsp;&nbsp;<?php echo $SignUpIDError;?></span><br /><br />

	<label>Display Name:</label>
	<input type="text" name="SignUpDisplayName" value = <?php echo $_POST["SignUpDisplayName"] ; ?>>
	<span class="error">&nbsp;&nbsp;<?php echo $SignUpDisplayNameError;?></span><br /><br />

	<label>First Name:</label>
	<input type="text" name="SignUpFirstName" value = <?php echo $_POST["SignUpFirstName"] ; ?>>
	<span class="error">&nbsp;&nbsp;<?php echo $SignUpFirstNameError;?></span><br /><br />

	<label>Last Name:</label>
	<input type="text" name="SignUpLastName" value = <?php echo $_POST["SignUpLastName"] ; ?>>
	<span class="error">&nbsp;&nbsp;<?php echo $SignUpLastNameError;?></span><br /><br />

	<label>Email:</label>
	<input type="text" name="SignUpEmail" value = <?php echo $_POST["SignUpEmail"] ; ?>>
	<span class="error">&nbsp;&nbsp;<?php echo $SignUpEmailError;?></span><br /><br />

	<label>Contact Number:</label>
	<input type="text" name="SignUpContact" value = <?php echo $_POST["SignUpContact"] ; ?>>
	<span class="error">&nbsp;&nbsp;<?php echo $SignUpContactError;?></span><br /><br />

	<label>Address:</label>
	<textarea rows="4" cols="50" name="SignUpAddress"><?php echo $_POST["SignUpAddress"] ; ?></textarea>
	<span class="error">&nbsp;&nbsp;<?php echo $SignUpAddressError;?></span><br /><br />

	<label>Date Of Birth:</label>
	<input type="date" name="SignUpDOB" value = <?php echo $_POST["SignUpDOB"] ; ?>>
	<span class="error">&nbsp;&nbsp;<?php echo $SignUpDOBError;?></span><br /><br />

	<label>Password:</label>
	<input type="password" name="SignUpPassword" value = <?php echo $_POST["SignUpPassword"] ; ?>>
	<span class="error">&nbsp;&nbsp;<?php echo $SignUpPasswordError;?></span><br /><br />

	<label>Confirm Password:</label>
	<input type="password" name="SignUpConfirmPassword"  value = <?php echo $_POST["SignUpConfirmPassword"] ; ?>>
	<span class="error">&nbsp;&nbsp;<?php echo $SignUpConfirmPasswordError;?></span><br /><br />

	<input type="Submit" name="SignUpButton" value="Sign Up" style="float:right;"/></br> 
</div>

</form>
</div>
</html>

<!--Links Used:-->
<!--https://www.w3schools.com/css/css_align.asp-->
<!--https://stackoverflow.com/questions/13204002/align-form-elements-in-css-->
<!--https://www.w3schools.com/cssref/css_selectors.asp-->