<?php require_once("NavBar.php");

if(!isset($_SESSION['ID'])){
	echo '<script> location.replace("index.php")</script> ';
}


$Convert_publickeyError = $Convert_privatekeyError = $Convert_amountError= "";
$Convert2_publickeyError = $Convert2_privatekeyError = $Convert2_amountError= "";
$validated = true;
$STIC = false;
$ETH = false;
if(isset($_POST['STIC2ETH'])){
$STIC = true;
	
if(empty($_POST["Convert2_publickey"]))
{
$Convert2_publickeyError = "Public key is required";
	$validated = false;

}
else{
	if($_SESSION['Object'] -> checkAccountInNetwork($_POST['Convert2_publickey'])){
	
	}
	else{
		$Convert2_publickeyError= "Public key is invalid";
		$validated = false;		
	}
	
}

if(empty($_POST["Convert2_amount"]))
{
$Convert2_amountError = "Amount is required";
$validated = false;
}
else{
	
if($_POST["Convert2_amount"]>$_SESSION['Object']->getAccountBalance()){
$Convert2_amountError = "You insufficient amount of STICoins";	
$validated = false;
}
}
if($validated){
sleep(2);

$Convert2edAmount = $_POST["Convert2_amount"]/10000;
$message = $_SESSION['Object'] -> ConvertToETH($_POST['Convert2_amount'],$_POST['Convert2_publickey']);
echo'<style> .ETHGUI{display:none;}</style>';	
	

if($message!="Success"){
	echo'
	<form method="post" action="ConvertPage.php">
	<h1>Transaction Summary</h1>
	<b>Operation:Convert to Ethereum</b></br>
	<b>Initial Amount :'.$_POST["Convert2_amount"].'</b></br>
	<b>Converted Amount:'.$Convert2edAmount.'</b></br>
	<b>Transaction: Failed </b></br>
	<b>Reason:'.$message.'</b></br>
	<b>STICoin Balance:'.$_SESSION['Object']->getAccountBalance().'</b></br>
	<input type="submit" value="Try again">
	</form>';	
	echo'<script>history.pushState({}, "", "")</script>';
	exit();
}
else{
	echo'
	<form method="post" action="index.php">
	<h1>Transaction Summary</h1>
	<b>Operation:Convert to Ethereum</b></br>
	<b>Initial Amount :'.$_POST["Convert2_amount"].'</b></br>
	<b>Converted Amount:'.$Convert2edAmount.'</b></br>
	<b>Transaction: Success </br>
	<b>STICoin Balance:'.$_SESSION['Object']->getAccountBalance().'</b></br>
	<input type="submit" value="Return to main menu!">
	</form>';	
	echo'<script>history.pushState({}, "", "")</script>';
	exit();
}

}

}
else{
$_POST["Convert2_publickey"] = '';
$_POST["Convert2_privatekey"] = '';
$_POST["Convert2_amount"] = '';
}
if(!$STIC){
echo'<style> .ETHGUI{display:none;}</style>';	
}
if(isset($_POST['ETH2STIC'])){
$ETH = true;
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
echo'<style> .STICGUI{display:none;}</style>';


if($message!="Success"){
	echo'
	<form method="post" action="ConvertPage.php">
	<h1>Transaction Summary</h1>
	<b>Operation:Convert to STICoin</b></br>
	<b>Initial Amount :'.$_POST["Convert_amount"].'</b></br>
	<b>Converted Amount:'.$ConvertedAmount.'</b></br>
	<b>Transaction: Failed </b></br>
	<b>Reason:'.$message.'</b></br>
	<b>STICoin Balance:'.$_SESSION['Object']->getAccountBalance().'</b></br>
	<input type="submit" value="Try again">
	</form>';	
	echo'<script>history.pushState({}, "", "")</script>';
	exit();
}
else{
	echo'
	<form method="post" action="index.php">
	<h1>Transaction Summary</h1>
	<b>Operation:Convert to STICoin</b></br>
	<b>Initial Amount :'.$_POST["Convert_amount"].'</b></br>
	<b>Converted Amount:'.$ConvertedAmount.'</b></br>
	<b>Transaction: Success </br>
	<b>STICoin Balance:'.$_SESSION['Object']->getAccountBalance().'</b></br>
	<input type="submit" value="Get Buying!">
	</form>';	
	echo'<script>history.pushState({}, "", "")</script>';
	exit();
}

}

}
else{
$_POST["Convert_publickey"] = '';
$_POST["Convert_privatekey"] = '';
$_POST["Convert_amount"] = '';
}
if(!$ETH){
echo'<style> .STICGUI{display:none;}</style>';	
}
?> 

<style>
span{
	
	color:red;
}

</style>
<button class="STIC">STIC to ETH</button>
<button class="ETH">ETH to STIC</button>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $(".STIC").click(function(){
    $(".ETHGUI").show();
	$(".STICGUI").hide();
  });
  $(".ETH").click(function(){
    $(".STICGUI").show();
	$(".ETHGUI").hide();
  });
});
 function checkForm(form) // Submit button clicked
  {
    //
    // check form input values
    //

    form.STIC2ETH.style.display = "none";
    form.STIC2ETH.value = "Please wait...";
    return true;
  }
 function check2Form(form) // Submit button clicked
  {
    //
    // check form input values
    //

    form.ETH2STIC.style.display = "none";
    form.ETH2STIC.value = "Please wait...";
    return true;
  }

</script>
<hr>
<div class="ETHGUI">
	
<form method="post" id="formSTIC" onsubmit="return checkForm(this);">
  <?php echo '<b>Convert to Ethereum</b></br>';?>
  <label for="Convert2_publickey">Public Key:</label><br>
  <input type="text" id="Convert2_publickey" name="Convert2_publickey" value=<?php echo $_POST["Convert2_publickey"];?>><br>
  <span class="error"><?php echo $Convert2_publickeyError;?></span><br /><br />
  <label for="Convert2_amount">Amount:</label><br>
  <input type="Number" id="Convert2_amount" name="Convert2_amount"value=<?php echo $_POST["Convert2_amount"];?>><br><br>
  <span class="error"><?php echo $Convert2_amountError;?></span><br /><br />
  <input type="submit" name="STIC2ETH" value="Convert">

</form> 
</div>
<div class="STICGUI">
	
<form method="post" id="formETH" onsubmit="return check2Form(this);">
  <?php echo '<b>Convert to STICoin</b></br>';?>
  <label for="Convert_publickey">Public Key:</label><br>
  <input type="text" id="Convert_publickey" name="Convert_publickey" value=<?php echo $_POST["Convert_publickey"];?>><br/>
  <span class="error"><?php echo $Convert_publickeyError;?></span><br /><br />
  <label for="Convert_privatekey">Private Key:</label><br/>
  <input type="text" id="Convert_privatekey" name="Convert_privatekey"value=<?php echo $_POST["Convert_privatekey"];?>><br><br>
  <span class="error"><?php echo $Convert_privatekeyError;?></span><br /><br />
  <label for="Convert_amount">Amount:</label><br/>
  <input type="Number" id="Convert_amount" name="Convert_amount"value=<?php echo $_POST["Convert_amount"];?>><br><br>
  <span class="error"><?php echo $Convert_amountError;?></span><br /><br />
  <input type="submit"  name="ETH2STIC" value="Convert">
</form> 


</div>

</div>
