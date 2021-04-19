<html>
<style>
.Login_GUI{
	margin-left:auto;
	margin-right:auto;
	width:500px;
	height:400px;
	background-color:black;
	text-align:center;
	opacity:0.8;
	border-radius: 100px;
	font-size:20px;
	
}
label{
	display:inline-block;
	width:200px;
	margin-right:30px;
	text-align:center;
}

input[name="LoginButton"]{
	margin-left:auto;
	margin-right:auto;
	font-size:30px;
	color:white;
	background-color:black;

}

fieldset{
border:none;
width:500px;
margin:0px auto;
}
span{
	color:red;
}
input[type="text"]{
	width:200px;
	font-family: arial;
}
</style>

</html>
<?php 
include("NavBar.php");
$LoginLoginIDerror = $MainError = $PasswordPassworderror = "";
if(isset($_SESSION['ID'])){
	echo '<script> location.replace("index.php")</script> ';
}
$servername= "localhost";
$username = "root";
$password = "";
$dbname = "music-to-go";
$conn = new mysqli($servername, $username, $password, $dbname);
$submit = true;
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['LoginButton'])){
	if(empty($_POST["Login_LoginID"]))
	{
		$LoginLoginIDerror = "UserID is required";
		$submit = false;
	}

	if(empty($_POST["Login_Password"]))
	{
		$PasswordPassworderror = "Password is required";
		$submit = false;
	}
	if($submit){
		
		$BaseUserOBJ = new BaseUser("Login");
		if($BaseUserOBJ->LoginValidate($_POST["Login_LoginID"],$_POST["Login_Password"])){
			$_SESSION['ID'] = $BaseUserOBJ->getUID();
			$_SESSION['Type'] = $BaseUserOBJ->getAccountType();
			echo'<script>history.pushState({}, "", "")</script>';
			if($_SESSION['Type']=="Standard"){
				$UserObj = new StandardUser($BaseUserOBJ);
				$_SESSION['Object'] = $UserObj;
			}
			if($_SESSION['Type']=="Administrator"){
				$AdminObj = new Admin($BaseUserOBJ);
				$_SESSION['Object'] = $AdminObj;
			}
			echo '<script> location.replace("index.php")</script> ';
			exit();
		}
		else{
			$MainError = "UserID/Password is wrong";
			
		}
	}
	
}
?>
<div class="Login_GUI">
<form method="post">
<h1 style="color:white;font-size:60px;">Login</h1>
<span class="error"><?php echo $MainError;?></span><br /><br />
<label>User ID:</label><input type="text" name="Login_LoginID">
<span class="error"><?php echo $LoginLoginIDerror;?></span><br /><br />
<label>Password:</label><input type="password" name="Login_Password">
<span class="error"><?php echo $PasswordPassworderror;?></span><br /><br />
<input type="Submit" name="LoginButton" value="Login"/>
</form>
<form action="SignUpPage.php" method="post">
<input type = "Submit" name="SignupButotn" value ="Sign Up"/>
</form>
</div>

