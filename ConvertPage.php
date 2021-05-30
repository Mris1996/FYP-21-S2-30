<?php require_once("NavBar.php");?>

<style>
span{
	
	color:red;
}

#confirmation{
	display:none;
	position:fixed;
    padding:0;
    margin:auto;
    top:0;
    left:0;

    width: 100%;
    height: 100%;
    background:rgba(255,255,255,0.8);
}
#confirmationtext{
	width:200px;
    margin:auto;
	margin-top:20%;
   
}
#Loading_GUI{
	display:none;
}
#OTP{
	display:none;
	position:fixed;
    padding:0;
    margin:auto;
    top:0;
    left:0;

    width: 100%;
    height: 100%;
    background:rgba(255,255,255,0.8);
}
#OTPform{
	width:200px;
    margin:auto;
	margin-top:20%;
   
}
</style>
<?php

if(!isset($_SESSION['ID'])){
	echo '<script> location.replace("index.php")</script> ';
}


$Convert_publickeyError = $Convert_privatekeyError = $Convert_amountError= "";
$Convert2_publickeyError = $Convert2_privatekeyError = $Convert2_amountError= "";
$validated = true;
$FIAT = false;
$ETH = false;

echo'<input type="hidden" id="convertrate" value="'.$_SESSION['Object']->getCurrencyValue('SGD').'">';

if(isset($_POST['FIAT2ETH'])){

$FIAT = true;
	
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
$Convert2_amountError = "";	
echo'<script>alert("You have insufficient amount of money,please top up");</script>';
$validated = false;
}
}
	
if($validated){
	echo'<style> .ETHGUI{display:none;}</style>';
	echo'<style> #confirmation{display:block;}</style>';
	$_SESSION['PubKeyC2'] = $_POST["Convert2_publickey"];
	$_SESSION['AmountC2'] = $_POST["Convert2_amount"] ;
}

}
else{
$_POST["Convert2_publickey"] = '';
$_POST["Convert2_amount"] = '';
}


if(isset($_SESSION['VerifiedUser'])){
unset($_SESSION['VerifiedUser']);
$Convert2edAmount = $_SESSION['AmountC2']/$_SESSION['Object'] ->getCurrencyValue('SGD');
$message = $_SESSION['Object'] -> ConvertToETH($_SESSION['AmountC2'],$_SESSION['PubKeyC2']);
echo'<style> .ETHGUI{display:none;}</style>';	
sleep(2);

if($message!="Success"){
	$_SESSION['Object']->updateBalance();
	echo'
	<form method="post" action="ConvertPage.php">
	<h1>Transaction Summary</h1>
	<b>Operation:Convert to Ethereum</b></br>
	<b>Initial Amount :'.$_SESSION['AmountC2'].'</b></br>
	<b>Converted Amount:'.$Convert2edAmount.'</b></br>
	<b>Transaction: Failed </b></br>
	<b>Reason:'.$message.'</b></br>
	<b>Account Balance:SGD$'.$_SESSION['Object']->getAccountBalance().'</b></br>
	<input type="submit" value="Try again">
	</form>';	
	unset($_SESSION['PubKeyC2']);
	unset($_SESSION['AmountC2']);
	echo'<script>history.pushState({}, "", "")</script>';
	exit();
}
else{
	$_SESSION['Object']->updateBalance();
	echo'
	<form method="post" action="index.php">
	<h1>Transaction Summary</h1>
	<b>Operation:Convert to Ethereum</b></br>
	<b>Initial Amount :'.$_SESSION["AmountC2"].'</b></br>
	<b>Converted Amount:'.$Convert2edAmount.'</b></br>
	<b>Transaction: Success </br>
	<b>Account Balance:SGD$'.$_SESSION['Object']->getAccountBalance().'</b></br>
	<input type="submit" value="Return to main menu!">
	</form>';	
	unset($_SESSION['PubKeyC2']);
	unset($_SESSION['AmountC2']);
	echo'<script>history.pushState({}, "", "")</script>';
	exit();
}	

}




if(!$FIAT){
echo'<style> .ETHGUI{display:none;}</style>';	
}
if(isset($_POST['ETH2FIAT'])){
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
	$_SESSION['PubKeyC1'] = $_POST["Convert_publickey"];
	$_SESSION['AmountC1'] = $_POST["Convert_amount"] ;
	$_SESSION['PrivKeyC1'] =$_POST['Convert_privatekey'] ;
	echo'<style> .FIATGUI{display:none;}</style>';
	echo'<style> #confirmation{display:block;}</style>';
}

}
else{
$_POST["Convert_publickey"] = '';
$_POST["Convert_privatekey"] = '';
$_POST["Convert_amount"] = '';
}
if(!$ETH){
echo'<style> .FIATGUI{display:none;}</style>';	
}

if(isset($_SESSION['VerifiedUser'])){
unset($_SESSION['VerifiedUser']);
$Convert2edAmount =$_SESSION['AmountC1']*$_SESSION['Object'] ->getCurrencyValue('SGD');
$message = $_SESSION['Object'] -> ConvertToFIATCurrency($_SESSION['AmountC1'] ,$_SESSION['PubKeyC1'],$_SESSION['PrivKeyC1']);
echo'<style> .ETHGUI{display:none;}</style>';	
sleep(2);

if($message!="Success"){
	$_SESSION['Object']->updateBalance();
	echo'
	<form method="post" action="ConvertPage.php">
	<h1>Transaction Summary</h1>
	<b>Operation:Convert to SGD</b></br>
	<b>Initial Amount :'.$_SESSION['AmountC1'].'</b></br>
	<b>Converted Amount:'.$Convert2edAmount.'</b></br>
	<b>Transaction: Failed </b></br>
	<b>Reason:'.$message.'</b></br>
	<b>Account Balance:SGD$'.$_SESSION['Object']->getAccountBalance().'</b></br>
	<input type="submit" value="Try again">
	</form>';	
	unset($_SESSION['PubKeyC1']);
	unset($_SESSION['AmountC2']);
	unset($_SESSION['Convert_privatekey']);
	echo'<script>history.pushState({}, "", "")</script>';
	exit();
}
else{
	$_SESSION['Object']->updateBalance();
	echo'
	<form method="post" action="index.php">
	<h1>Transaction Summary</h1>
	<b>Operation:Convert to SGD</b></br>
	<b>Initial Amount :'.$_SESSION["AmountC1"].'</b></br>
	<b>Converted Amount:'.$Convert2edAmount.'</b></br>
	<b>Transaction: Success </br>
	<b>Account Balance:SGD$'.$_SESSION['Object']->getAccountBalance().'</b></br>
	<input type="submit" value="Return to main menu!">
	</form>';	
	unset($_SESSION['PubKeyC1']);
	unset($_SESSION['AmountC2']);
	unset($_SESSION['Convert_privatekey']);
	echo'<script>history.pushState({}, "", "")</script>';
	exit();
}	
}

?> 

<button class="FIAT">SGD to ETH</button>
<button class="ETH">ETH to SGD</button>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $(".FIAT").click(function(){
    $(".ETHGUI").show();
	$(".FIATGUI").hide();
  });
  $(".ETH").click(function(){
    $(".FIATGUI").show();
	$(".ETHGUI").hide();
  });
});
 function checkForm(form) // Submit button clicked
  {
    //
    // check form input values
    //

    form.FIAT2ETH.style.display = "none";
    form.FIAT2ETH.value = "Please wait...";
    return true;
  }
 function check2Form(form) // Submit button clicked
  {
    //
    // check form input values
    //

    form.ETH2FIAT.style.display = "none";
    form.ETH2FIAT.value = "Please wait...";
    return true;
  }
var convertrate = document.getElementById("convertrate").value;
function ConvertSGD(){
	var amount = document.getElementById("Convert_amount").value;
	document.getElementById("amountconverted").innerHTML = "Conversion Rate SGD/ETH: SGD$"+convertrate+"</br>"+ "Conversion Amount : SGD$"+(amount*convertrate).toFixed(2);
}
function ConvertETH(){
	var amount = document.getElementById("Convert2_amount").value;
	document.getElementById("amountconverted2").innerHTML = "Conversion Rate ETH/SGD: ETH "+(1/convertrate)+"</br>"+ "Conversion Amount : ETH "+(amount/convertrate).toFixed(5);
}
</script>
<hr>
<div class="ETHGUI">
	
<form method="post" id="formFIAT" onsubmit="return checkForm(this);">
  <?php echo '<b>Convert to Ethereum</b></br>';?>
  <label for="Convert2_publickey">Public Key:</label><br>
  <input type="text" id="Convert2_publickey" name="Convert2_publickey" value=<?php echo $_POST["Convert2_publickey"];?>><br>
  <span class="error"><?php echo $Convert2_publickeyError;?></span><br /><br />
  <label for="Convert2_amount">Amount:</label><br>
  <input type="Number"  onchange="ConvertETH()"step="any" id="Convert2_amount" name="Convert2_amount"value=<?php echo $_POST["Convert2_amount"];?>><br><br>
  <span class="error"><?php echo $Convert2_amountError;?></span><br /><br />
  <p id="amountconverted2"></p>
  <input type="submit" name="FIAT2ETH" value="Convert">

</form> 
</div>
<div class="FIATGUI">
	
<form method="post" id="formETH" onsubmit="return check2Form(this);">
  <?php echo '<b>Convert to SGD</b></br>';?>
  <label for="Convert_publickey">Public Key:</label><br>
  <input type="text" id="Convert_publickey" name="Convert_publickey" value=<?php echo $_POST["Convert_publickey"];?>><br/>
  <span class="error"><?php echo $Convert_publickeyError;?></span><br /><br />
  <label for="Convert_privatekey">Private Key:</label><br/>
  <input type="text" id="Convert_privatekey" name="Convert_privatekey"value=<?php echo $_POST["Convert_privatekey"];?>><br><br>
  <span class="error"><?php echo $Convert_privatekeyError;?></span><br /><br />
  <label for="Convert_amount">Amount:</label><br/>
  <input type="Number" step="any" onchange="ConvertSGD()" id="Convert_amount" name="Convert_amount"value=<?php echo $_POST["Convert_amount"];?>><br><br>
  <span class="error"><?php echo $Convert_amountError;?></span><br /><br />
  <p id="amountconverted"></p>
  <input type="submit"  name="ETH2FIAT" value="Convert">
</form> 


</div>

</div>

<div id = "Loading_GUI" class="Loading_GUI">
<h1>Loading,Please Wait</h1>
</div>
<div id="confirmation">
<div id="confirmationtext">
<b>Are you sure you?</b></br>
<input type="submit"   name="submit" id="<?php echo $_SESSION['Object']->getEmail()?>" onclick="emailverification(this.id)" value="Yes">
<input type="submit"  onclick="rejectfunction()" value="No">
</form>
</div>
</div>
</form>
<div id="OTP">
<div id="OTPform">
<Label>OTP Code:</Label><input type="text"  id="OTPinput">
<input type="submit" onclick="VerifyOTP()" value="Submit OTP">
<input type="submit" id="<?php echo $_SESSION['Object']->getEmail()?>" onclick="ResendOTP(this.id)" value="Resend">
</form>
</div>
</div>

<input type="hidden" class="text-box" id="User"  value = "<?php echo $_SESSION['Object']->getUID()?>">

<script>


var User  = document.getElementById('User').value;
function AcceptConfirm(){
document.getElementById('confirmation').style.display = "block";

}
function rejectfunction(){
	history.pushState({}, "", "");
location.reload();
}
function emailverification(email){
	ajax.open("POST", "ConvertPageController.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("Email=" + email);
	console.log(ajax);
	document.getElementById('confirmation').style.display = "none";
	document.getElementById('OTP').style.display = "block";

}
function ResendOTP(email){

	ajax.open("POST", "ConvertPageController.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("Email=" + email);
	console.log(ajax);
	alert("Resent Email");
}
function VerifyOTP(){
	document.getElementById('OTPform').style.display = "none";
	alert("Please Wait");
	OTPEntry = document.getElementById('OTPinput').value;
	ajax.open("POST", "ConvertPageController.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("OTP=" + OTPEntry );
	console.log(ajax);
}
var connection =  new WebSocket('ws://localhost:3030');
connection.onmessage = function (message) {
	var data = JSON.parse(message.data);

			if (data.REPLY == 'OTPResult') {
					if(User == data.User){
						console.log(data.Result);
							if(data.Result == "Success"){
								document.getElementById('Loading_GUI').style.display = "block";
								document.getElementById('OTP').style.display = "none";
								ajax.open("POST", "ConvertPageController.php", true);
								ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
								location.reload();
							}
							if(data.Result == "Failed"){
								alert("Invalid OTP code"); 
								history.pushState({}, "", "");
								location.reload();
							
							}
							if(data.Result == "LogOut"){
								alert("Max Attempt reached,you will be logged out"); 
								ajax.open("POST", "ConvertPageController.php", true);
								ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
								ajax.send("Logout=" + User);
								location.replace("LoginPage.php");
							}
						
					}
					
				}
	
}
</script>

<?php require_once("Footer.php");?>