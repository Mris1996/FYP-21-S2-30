<html>
<style>

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
	color:blue;

}
input[type="text"],[type="password"]{
	width:200px;
}
#container{
	margin-top:5%;
	width:1000px;
	height:700px;
	border-radius:20px;
	border:2px solid purple;
		margin-left:25%;
	overflow: hidden;
 box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
	
}
#innercontainer{
	background-repeat: no-repeat; /* Do not repeat the image */
	background-size: cover; /* Resize the background image to cover the entire container */
	background-image: url('ads/LoginAds.jpg');
	width:498px;
	height:100%;
	background-color:#4b0082;
	   float: right;
}
#Login_GUI{
		
		margin-top:15%;
	width:498px;
	height:400px;
	 float: left;
	font-size:20px;
	
}
#Login_GUI input{

	height:40px;


}
#Login_GUI input[type=submit]{
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

</html>
<?php 
require_once("NavBar.php");
$LoginLoginIDerror = $MainError = $PasswordPassworderror = "";
if(isset($_SESSION['ID'])){
	echo '<script> location.replace("index.php")</script> ';
}

$submit = true;

if(isset($_POST['SignupButton'])){
echo '<script> location.replace("SignUpPage.php")</script> ';	
	
}
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
			if(json_decode($BaseUserOBJ->Status)[0]=="Suspended"){
				if(strtotime("now")>strtotime(json_decode($BaseUserOBJ->Status)[1])){
					$AdminObj = new Admin($BaseUserOBJ);
					$AdminObj ->RemoveStatus($BaseUserOBJ->getUID());	
					$_SESSION['ID'] = $BaseUserOBJ->getUID();
					$_SESSION['Type'] = $BaseUserOBJ->getAccountType();
					echo'<script>history.pushState({}, "", "")</script>';
					if($_SESSION['Type']=="Standard"){
						// Downcasting to child class StandardUser
						$UserObj = new StandardUser($BaseUserOBJ);
						// Store UserObj to SESSION variable so it can be used on other pages
						$_SESSION['Object'] = $UserObj;
					}
					if($_SESSION['Type']=="Administrator"){
						// Downcasting to child class Admin
						$AdminObj = new Admin($BaseUserOBJ);
						// Store AdminObj to SESSION variable so it can be used on other pages
						$_SESSION['Object'] = $AdminObj;
					}
					echo '<script> location.replace("index.php")</script> ';
					exit();
				}
				else{
					$MainError = "Account has been suspended till ".date("d/m/Y",strtotime(json_decode($BaseUserOBJ->Status)[1]))."";
				}
				
				
			}
			else if(json_decode($BaseUserOBJ->Status)[0]=="Banned"){
				$MainError = "Account has been banned";
			}
			else{
			// Set SESSION variables here
			$_SESSION['ID'] = $BaseUserOBJ->getUID();
			$_SESSION['Type'] = $BaseUserOBJ->getAccountType();
			echo'<script>history.pushState({}, "", "")</script>';
			if($_SESSION['Type']=="Standard"){
				// Downcasting to child class StandardUser
				$UserObj = new StandardUser($BaseUserOBJ);
				// Store UserObj to SESSION variable so it can be used on other pages
				$_SESSION['Object'] = $UserObj;
			}
			if($_SESSION['Type']=="Administrator"){
				// Downcasting to child class Admin
				$AdminObj = new Admin($BaseUserOBJ);
				// Store AdminObj to SESSION variable so it can be used on other pages
				$_SESSION['Object'] = $AdminObj;
			}
			echo '<script> location.replace("index.php")</script> ';
			exit();
			}
		}
		else{
			$MainError = "UserID/Password is wrong";
			
		}
	}
	
}
?>
<div id="container">
<div id="Login_GUI">

<form method="post">
<center><a href="index.php"><img src="systemimages/STIClogo.jpg" class="image" style="object-fit:cover;width:200px;height:100px;border-radius:10px"></a></center>
<center><span class="error"><?php echo $MainError;?></span><br /><br /></center>
<label>User ID:</label><input type="text" name="Login_LoginID"><br />
<center><span class="error"><?php echo $LoginLoginIDerror;?></span><br /><br /></center>
<label>Password:</label><input type="password" name="Login_Password">
<center><span class="error"><?php echo $PasswordPassworderror;?></span><br /><br /></center>
<center>
<input type="Submit" name="LoginButton" value="Login"/>
<input type = "Submit" name="SignupButton" value ="Sign Up"/><br />
</form>



<a href="ForgetPasswordPage.php">Forgot password?</a>
</center>
</div>
<div id="innercontainer">

</div>
</div>

<?php require_once("Footer.php");?> 