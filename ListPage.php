<?php require_once("NavBar.php");

if(!isset($_SESSION['ID'])){
	echo '<script> location.replace("index.php")</script> ';
}
$NameErr = $CategoryErr = $CaptionErr = $DescriptionErr = $CostErr = $FileErr= "";





$submit = true;

if(isset($_POST['submit'])){
$Name = test_input($_POST["Name"]);
$Category = test_input($_POST["Category"]);
$Caption = test_input($_POST["Caption"]); 
$Description = test_input($_POST["Description"]); 
$Cost = test_input($_POST["Cost"]);

if (empty($_POST["Category"])){
	$CategoryErr= "Category is required";	
	$submit = false;
}

if (empty($_POST["Caption"])){
	$CaptionErr= "Caption is required";	
	$submit = false;
}


if (empty($_POST["Name"])){
	$NameErr= "Name is required";	
	$submit = false;
}



if (empty($_POST["Description"])){
	$DescriptionErr= "Description is required";	
	$submit = false;
}

if (empty($_POST["Cost"])){
	$CostErr= "Initial cost is required";	
	$submit = false;
}



if (empty($_POST["file"])){
		$file = $_FILES['file'];
		
		$File = $_FILES['file']['name'];
		$fileTmpName = $_FILES['file']['tmp_name'];
		$fileSize = $_FILES['file']['size'];
		$FileError = $_FILES['file']['error'];
		$fileType = $_FILES['file']['type'];
		
		$fileExt = explode('.',$File);
		$fileActualExt = strtolower(end($fileExt));
		$allowed = array('jpg','jpeg','png','pdf');
		
		if(in_array($fileActualExt, $allowed)){
		
			if($FileError == 0){
					
				if($fileSize < 500000){	//if file size less then 50mb
					$FileNew = uniqid('', true).".".$fileActualExt;
					

				} else {
					
					$FileErr= "The file is too big!";
					$submit = false;
				}
			} else {
				
				$FileErr= "There was an error uploading the file!";
				$submit = false;
			}
			
		} else {
			if($fileSize==0){
				
				$FileErr= "Upload a file";
				$submit = false;
			}
			else{	
				$FileErr= "You cannot upload files of this type!";
				$submit = false;
			}
		
		}
	}	
}
else{
$File = '';
$Name = '';
$Category ='';
$Caption = '';
$Description = '';
$Cost = '';

}	
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<style>
.Insert_GUI{
	clear: both;
	margin-left:auto;
	margin-right:auto;
	margin-bottom:20px;
	width:1000px;
	height:1000px;
	
	text-align:left;
	opacity:0.8;
	font-size:20px;
	

}
label,span{
	display:inline-block;
	width:200px;
	margin-right:5px;
	text-align:center;
}
.Insert_GUI input[type="submit"]{
	font-size:30px;
	color:white;
	background-color:black;
}
span{
	color:red;
		width:200px;
}
hr{
	background-color:white;
}
input[type="text"]{
	font-family: arial;
	width:200px;
}
.Post_Insert_GUI{
	margin-left:auto;
	margin-right:auto;
	margin-bottom:20px;
	width:500px;
	height:300px;
	text-align:center;
	opacity:0.8;
	font-size:30px;

}
.ConfirmList_GUI{
	margin-left:auto;
	margin-right:auto;
	margin-bottom:20px;
	width:500px;
	height:300px;
	text-align:left;
	opacity:0.8;
	font-size:30px;
	
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
.Payment_GUI{
	display:none;
}
.Loading_GUI
{
	display:none;
}
</style>
<h1 style="font-size:70px"><center>Insert New Product Details</center></h1>	
 <div class="List_GUI">
    <form method="post" enctype="multipart/form-data">  
	
	<h2>Basic Product Information</h2>
	
		<label>Upload File</label>
		<input type="file" name="file"/>
		<span class="error"><?php echo $FileErr;?></span><br />
	
		<label>Name:</label>
		<input type="text" name="Name" value="<?php echo $Name;?>">
		<span class="error"><?php echo $NameErr;?></span><br />
		
		<label>Category:</label>
		  <select style="background-color:black;color:white;" id="Category" name="Category">
			<?php
			$myfile = fopen("Categories.txt", "r") or die("Unable to open file!");
			while(($line = fgets($myfile)) !== false) {
			$arr = explode(":",$line);
			echo 
			"<option style='background-color:black;color:white;' value='".$arr[0]."'>".$arr[0]."</option>";
			}fclose($myfile);
			?>
		  </select><br />
	<hr>
	<h2>Description of product</h2>  
	
		<label>Product Caption:</label>
		<textarea id="Caption" name="Caption" rows="1" cols="50" value=""><?php echo $Caption;?></textarea>
		<span class="error"><?php echo $CaptionErr;?></span><br />
		<label style=" vertical-align: middle;">Product Description:</label>
		<textarea style=" vertical-align: middle;" id="Description" name="Description" rows="4" cols="50" value=""><?php echo $Description;?></textarea>
		<span class="error"><?php echo $DescriptionErr;?></span><br /><br />
		
		<label>Initial Cost(STICoins):</label>

		<input type="number" id="Cost" name="Cost" min="0.00" step="any" value="<?php echo $Cost;?>">
		<span class="error"><?php echo $CostErr;?></span><br />
		<br />
		
		
		<input type="submit" name="submit" value="List">
    </form>
</div>

<?php

if(isset($_POST['submit'])&& $submit){

	$fileDestination = 'images/'.$FileNew;

	echo'<style> .List_GUI{display:none;}</style>';
	echo'<style> .Payment_GUI{display:block;}</style>';
}
if(isset($_SESSION['UploadNow'])){
	echo'<style> .List_GUI{display:none;}</style>';
	echo'<style> .Payment_GUI{display:none;}</style>';
	echo'<style> .Loading_GUI{display:none;}</style>';
	$_SESSION['Object']->PayProduct($_SESSION['UploadNow']);
	move_uploaded_file($fileTmpName,$fileDestination);
	$ProductID = $_SESSION['Object']->ListProduct($Name,$Category,$Description,round($Cost, 0),$Caption,$fileDestination,$_SESSION['PaymentOption']);
	unset($_SESSION['UploadNow']);
	unset($_SESSION['PaymentOption']);
	echo'<script>location.replace("ProductPage.php?ID='.$ProductID.'")</script>';
	exit();
}

?>
<div id = "Loading_GUI" class="Loading_GUI">
<h1>Loading,Please Wait</h1>
</div>
<div id = "Payment_GUI" class="Payment_GUI">
<label>Select the period that you want</label><br /><br />
<div class="card">
<label>1 week</label>
<b>Cost:<?php echo ($_SESSION['Object']->getProductCost()/30) ?></b>
<input type="radio"  id="PaymentPeriod" name="PaymentPeriod" value="week"  checked><br>
</div>

<div class="card">
<label>1 month</label>
<b>Cost:<?php echo ($_SESSION['Object']->getProductCost()) ?></b>
<input type="radio"  id="PaymentPeriod" name="PaymentPeriod" value="month"  ><br>
</div>

<div class="card">
<label>1 year</label>
<b>Cost:<?php echo ($_SESSION['Object']->getProductCost()*12) ?></b>
<input type="radio"  id="PaymentPeriod"  name="PaymentPeriod" value="year"  ><br>
</div>

<input type="button" onclick="AcceptConfirm()" value="Pay Now">
</div>

<div id="confirmation">
<div id="confirmationtext">
<b>Are you sure you?</b></br>
<input type="submit"   name="submit" id="<?php echo $_SESSION['Object']->getEmail()?>" onclick="emailverification(this.id)" value="Yes">
<input type="submit"  onclick="location.reload()" value="No">
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
<input type="hidden" class="text-box" id="Balance"  value = "<?php echo $_SESSION['Object']->getAccountBalance()?>">
<input type="hidden" class="text-box" id="Price"  value = "<?php echo $_SESSION['Object']->getProductCost()?>">
<input type="hidden" class="text-box" id="User"  value = "<?php echo $_SESSION['Object']->getUID()?>">

<script>

var Name = "<?php echo $Name?>";
var Category = "<?php echo $Category?>";
var Description = "<?php echo $Description?>";
var Cost = "<?php echo round($Cost, 0)?>";
var Caption = "<?php echo $Caption?>";
var FileOld = "<?php echo $fileTmpName?>";
var FileNew = "<?php echo $fileDestination?>";
var Option  = document.getElementsByName('PaymentPeriod');
var OptionChoice;
var OptionPrice;
for (var i = 0, length = Option.length; i < length; i++) {
if (Option[i].checked) {

if(Option[i].value == 'week'){
	OptionPrice = 0.25;
}
if(Option[i].value == 'month'){
	OptionPrice = 1;
}

if(Option[i].value == 'year'){
	OptionPrice = 120;
}
OptionChoice = Option[i].value;
break;
}
}
var User  = document.getElementById('User').value;
var Price   = document.getElementById('Price').value;
var Balance = Number(document.getElementById('Balance').value);
var Amount;
function AcceptConfirm(){



Amount = Price * OptionPrice;
if(Balance>Amount){
	document.getElementById('confirmation').style.display = "block";

}
else{
	alert("Payment failed,you have insufficient balance,please top up");
	window.open("ConvertPage.php");
}
	
}

function emailverification(email){
	ajax.open("POST", "ListPageController.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("Email=" + email);
	console.log(ajax);
	document.getElementById('confirmation').style.display = "none";
	document.getElementById('OTP').style.display = "block";


}
function ResendOTP(email){
	ajax.open("POST", "ListPageController.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("Email=" + email);
	console.log(ajax);
}
function VerifyOTP(){
	document.getElementById('OTPform').style.display = "none";
	alert("Please Wait");
	OTPEntry = document.getElementById('OTPinput').value;
	ajax.open("POST", "ListPageController.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("OTP=" + OTPEntry );
	console.log(ajax);
}
var connection =  new WebSocket('ws://localhost:3030');
connection.onmessage = function (message) {
	var data = JSON.parse(message.data);

			if(data.REPLY == 'ProductIDreturn'){
				if(User == data.User){
					alert("Payment Successful"); 
					location.reload();
				}
			}
			if (data.REPLY == 'OTPResult') {
					if(User == data.User){
						console.log(data.Result);
							if(data.Result == "Success"){
								document.getElementById('Payment_GUI').style.display = "none";
								document.getElementById('Loading_GUI').style.display = "block";
								document.getElementById('OTP').style.display = "none";
								ajax.open("POST", "ListPageController.php", true);
								ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
								ajax.send( "Amount=" + Amount +"&Option=" + OptionChoice );
							}
							if(data.Result == "Failed"){
								alert("Invalid OTP code"); 
								location.reload();
							}
							if(data.Result == "LogOut"){
								alert("Max Attempt reached,you will be logged out"); 
								ajax.open("POST", "ListPageController.php", true);
								ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
								ajax.send("Logout=" + User);
								location.replace("index.php");
							}
						
					}
					
				}
	
}
</script>
<?php require_once("Footer.php");?> 