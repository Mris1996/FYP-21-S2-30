<?php require_once("NavBar.php");

if(!isset($_SESSION['ID'])){
	echo '<script> location.replace("index.php")</script> ';
}

$Operation = "Convert to STICoin";
$Convert = "SC";
$Convert_publickeyError = $Convert_privatekeyError = $Convert_amountError= "";
$validated = true;

if(isset($_POST['submit'])){
	
if(empty($_POST["Convert_publickey"]))
{
$Convert_publickeyError = "Public key is required";
	$validated = false;

}
else{
	if($_SESSION['Object'] -> checkAccountInNetwork($_POST['Convert_publickey'])){
	
	}
	else{
		$Convert_publickeyError= "Public key is invalid";
		$validated = false;		
	}
	
}

if(empty($_POST["Convert_privatekey"]))
{
$Convert_privatekeyError = "Private key is required";
	$validated = false;
}
else{
	if(strlen($_POST["Convert_privatekey"])<64){
		$Convert_privatekeyError = "Private key is invalid";
		$validated = false;
	}
	
}


if(empty($_POST["Convert_amount"]))
{
$Convert_amountError = "Amount is required";
$validated = false;
}

if($validated){
sleep(2);

$ConvertedAmount = $_POST["Convert_amount"]*10000;
$message = $_SESSION['Object'] -> ConvertToSTICOIN($_POST['Convert_amount'],$_POST['Convert_publickey'],$_POST['Convert_privatekey']);
echo'<script>history.pushState({}, "", "")</script>';
echo'<style> .STICGUI{display:none;}</style>';


if($message!="Success"){
	echo'
	<form method="post" action="ConvertSCPage.php">
	<h1>Transaction Summary</h1>
	<b>Operation:'.$Operation.'</b></br>
	<b>Initial Amount :'.$_POST["Convert_amount"].'</b></br>
	<b>Converted Amount:'.$ConvertedAmount.'</b></br>
	<b>Transaction: Failed </b></br>
	<b>Reason:'.$message.'</b></br>
	<b>STICoin Balance:'.$_SESSION['Object']->getAccountBalance().'</b></br>
	<input type="submit" value="Try again">
	</form>';	
	
}
else{
	echo'
	<form method="post" action="index.php">
	<h1>Transaction Summary</h1>
	<b>Operation:'.$Operation.'</b></br>
	<b>Initial Amount :'.$_POST["Convert_amount"].'</b></br>
	<b>Converted Amount:'.$ConvertedAmount.'</b></br>
	<b>Transaction: Success </br>
	<b>STICoin Balance:'.$_SESSION['Object']->getAccountBalance().'</b></br>
	<input type="submit" value="Get Buying!">
	</form>';	
	
}

}

}
else{
$_POST["Convert_publickey"] = '';
$_POST["Convert_privatekey"] = '';
$_POST["Convert_amount"] = '';
}

?> 

<style>
span{
	
	color:red;
}
</style>

<div class="STICGUI">
	
<form method="post">
  <?php echo '<b>'.$Operation.'</b></br>';?>
  <label for="Convert_publickey">Public Key:</label><br>
  <input type="text" id="Convert_publickey" name="Convert_publickey" value=<?php echo $_POST["Convert_publickey"];?>><br>
  <span class="error"><?php echo $Convert_publickeyError;?></span><br /><br />
  <label for="Convert_privatekey">Private Key:</label><br>
  <input type="text" id="Convert_privatekey" name="Convert_privatekey"value=<?php echo $_POST["Convert_privatekey"];?>><br><br>
  <span class="error"><?php echo $Convert_privatekeyError;?></span><br /><br />
  <label for="Convert_amount">Amount:</label><br>
  <input type="Number" id="Convert_amount" name="Convert_amount"value=<?php echo $_POST["Convert_amount"];?>><br><br>
  <span class="error"><?php echo $Convert_amountError;?></span><br /><br />
  <input type="submit" name="submit" value="Submit">
</form> 


</div>

