<?php 
include("NavBar.php");

if(isset($_POST['ForgetButton'])){
$submit = true;
if(empty($_POST["ForgetPassEmail"]))
	{
		$EmailErr = "Email is required";
		$submit = false;
	}
	else{
		if(!filter_var($_POST["ForgetPassEmail"], FILTER_VALIDATE_EMAIL)){
			$submit = false;
			$EmailErr = "Invalid Email format";
		}
	}
	
	if($submit){
		$BaseUserObj = new BaseUser("Forget Password");
		if($BaseUserObj->ForgetPassword($_POST["ForgetPassEmail"])=="Sent"){
			echo'<style> .ForgetPassword_GUI{display:none;}</style>';
			echo'<b>Please check your email</b>';
		}
		if($BaseUserObj->ForgetPassword($_POST["ForgetPassEmail"])=="Email error"){
			$EmailErr = "This email does not exist in our database";
		}
		else{
			$EmailErr = "There is an error with the server";
		}
	}

}
else{
$_POST["ForgetPassEmail"] = '';
$EmailErr = '';
}
?>
<div class="ForgetPassword_GUI">
<form method="post">
<label>Email:</label>
<input type="text" name="ForgetPassEmail" value = <?php echo $_POST["ForgetPassEmail"] ; ?>>
<span class="error">&nbsp;&nbsp;<?php echo $EmailErr;?></span><br /><br />
<input type="Submit" name="ForgetButton" value="Retrieve" style="float:left;"/></br> 
</form>
</div>