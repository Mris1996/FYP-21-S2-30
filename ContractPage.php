<?php
require_once("NavBar.php");
if(!isset($_SESSION['ID'])){
	echo '<script> location.replace("index.php")</script> ';
}
$ContractID = $_GET['ID'] ;
$_SESSION["ContractID"] = $_GET['ID'];
$ContractObj = new Contracts();
if(!$ContractObj->initialiseContract($ContractID)){
	echo '<script> location.replace("index.php")</script> ';
}
if($ContractObj->BuyerUserID!=$_SESSION['ID']&&$ContractObj->SellerUserID!=$_SESSION['ID']){
	if($_SESSION['Object']->getAccountType()!="Administrator"){
	echo '<script> location.replace("index.php")</script> ';
}
	
}



?>


<style type="text/css">
	* {
	box-sizing:border-box;
}
#sharedform{
	width:45%;
	float:left;
	display:block;
	margin-bottom:10px;
	opacity:1;

}
#sharedform input{
	
}
	#chatbox {
		float:right;
		width:50%;
		max-width:100%;
		margin:30px auto;
		display:none;
		background-color:#fafafa;
	
	}
	#message-box {
		min-height:400px;
		overflow:auto;
		padding:30px;
		height: 110px;
		overflow: auto;
	  
	}
	.author {
		margin-right:5px;
		font-weight:600;
	}
	.text-box {
		width:100%;
		border:1px solid #eee;
		padding:10px;
		margin-bottom:10px;
	}
#User1{
	text-align:right;
	word-wrap: break-word;
}
#User2{
	text-align:left;
	word-wrap: break-word;
}


</style>

</head>
<body >
<?php
$Type = ''; 
if($ContractObj->BuyerUserID==$_SESSION['ID']){
	$Type = "Buyer";
	$_POST["Chat_with"] = $ContractObj->SellerUserID;
}
else if($ContractObj->SellerUserID==$_SESSION['ID']){
	$Type = "Seller";
	$_POST["Chat_with"] = $ContractObj->BuyerUserID;
}
else{
if($_SESSION['Object']->getAccountType()=="Administrator"){
	$Type = "Admin";
	$_POST["Chat_with"] = $_SESSION['ID'];
}
}
$ProductObj = new Products();
$ProductObj->InitialiseProduct($ContractObj->ProductID);
if (isset($_POST["Chat_with"])){
	if($Type == "Admin"){
		$_SESSION['AdminAssist'] = $_POST["Chat_with"];	
	}
	else{
		$_SESSION['OtherUser'] = $_POST["Chat_with"];
	}
	echo'<style> #chatbox{display:block;}</style>';
}


if(!isset($_SESSION['ID'])){
	echo '<script> location.replace("index.php")</script> ';
}
$submit = true;
$ProductID = $ProductObj->ProductID;
$DateRequiredError = $OfferError = "";
$Owner = $_SESSION['Object']->getProductOwner($ProductID);
$ProductObj = new Products();
$ProductObj->InitialiseProduct($ProductID);


?>
<input type="hidden" class="text-box" id="UserID"  value = "<?php echo $_SESSION['ID']?>">
<input type="hidden" class="text-box" id="contractid"  value = "<?php echo $_GET['ID']?>">
<input type="hidden" class="text-box" id="usertype"  value = "<?php echo $Type?>">
<input type="hidden" class="text-box" id="Payment"  value = "<?php echo $ContractObj->PaymentMode?>">
<input type="hidden" class="text-box" id="Balance"  value = "<?php echo $_SESSION['Object']->getAccountBalance()?>">
<?php
if($Type=="Admin"){
$BaseUserOBJ = new BaseUser("check balance");
$BaseUserOBJ->setUID($ContractObj->SellerUserID);
echo'<input type="hidden" class="text-box" id="SellerBalance"  value = "'.$BaseUserOBJ->getAccountBalanceFromServer($BaseUserOBJ->getPubKey()).'">';
}

?>
<h1 id="statusmessage" style="text-align:center">Status:<?php 
if($ContractObj->Status == "Deal"){
	
echo 'Contract agreed upon, awaiting for product to be transferred';

}
else if($ContractObj->Status == "Requested Refund"){
 echo 'Buyer refunded,await Admin assistance';	
} 
else if($ContractObj->Status == "Buyer has accepted service"){
	echo 'Buyer has accepted service';	
}
else if($ContractObj->Status == "Seller has accepted service"){
	echo 'Seller has accepted service';	
}
else if($ContractObj->Status == "Buyer has accepted"){
	echo 'Buyer has accepted';	
}
else if($ContractObj->Status == "Seller has accepted"){
	echo 'Seller has accepted';	
}
else if($ContractObj->Status == "Transaction Complete"){
	echo 'Transaction Complete';	
}
else if($ContractObj->Status == "Order Cancelled"){
	echo 'Seller has cancelled the order, sorry for any inconvenience caused,STICoins will be returned to the buyer , as soon as possible.';	
}
else if($ContractObj->Status == "Rejected"){
	echo 'Transaction declined,offer is rejected';	
}
else if($ContractObj->Status == "Refunded Transaction"){
	echo 'Admin intervened and refunded buyer';	
}
else if($ContractObj->Status == "Admin has halted this transaction"){
	echo 'Admin has halted this transaction';	
}
else{
echo 'Terms are being negotiated';	

}

?></h1>
<div id="sharedform">
<center><h2>Product Details</h2>
<img src="<?php echo $ProductObj->Image;?>" style="width:50%;"></br></center>
<label>Product Name:</label><b><?php echo $ProductObj->ProductName;?></b></br>
<label>Product Owner:</label><b><?php echo $_SESSION['Object']->getUserDisplayName($ProductObj->SellerUserID)?></b></br>
<label>Product Caption:</label><b><?php echo $ProductObj->ProductCaption?></b></br>
<label>Product Description:</label><b><?php echo $ProductObj->ProductDescription?></b></br>
<label>Product Initial Price:</label><b><?php echo $ProductObj->ProductInitialPrice?></b></br>


<hr><center><h2>Contract Details</h2></center>
<?php
		if($Type == "Buyer"){
		echo'
			<label>Date product is required by:</label>
			<input type="date"  id ="DateRequired" name="DateRequired" oninput="formsyncfunction()" value="'.$ContractObj->DateRequired.'" required>';
		}
		if($Type == "Seller" || $Type== "Admin"){
		echo'
			<label>Date product is required by:</label>
			<input type="date" id ="DateRequired" name="DateRequired" oninput="formsyncfunction()" value="'.$ContractObj->DateRequired.'" readonly>';
		}
?>
	
	
		<br />
		<label>Offer(STICoins):</label>
		<input type="number" id="Offer" name="Offer" min="0.00" step="any" oninput="formsyncfunction()" value="<?php echo $ContractObj->NewOffer;?>" required>
		<br />
<?php 
		if($Type == "Buyer"){
		echo'
		<label>Offer will be rounded up to whole number</label><br /><br />
		<label> Payment Mode</label><br>
		<label for="Half">Half-STICoins now:</label>
		<input type="radio"  id="PaymentMode1" onclick="formsyncfunction()" name="PaymentMode" value="Half-STICoins" ><br>
		<label for="female">Full-STICoins now:</label>
		<input type="radio"  id="PaymentMode2" onclick="formsyncfunction()" name="PaymentMode" value="Full-STICoins"><br>
		<label for="FullLater">Full-STICoins later :</label>
		<input type="radio" id="PaymentMode3" onclick="formsyncfunction()" name="PaymentMode" value="Full-STICoins_Later"><br>
		<br>';
		}
		if($Type == "Seller" || $Type == "Admin"){
			echo'
		<label>Offer will be rounded up to whole number</label><br /><br />
		<label> Payment Mode</label><br>
		<label for="Half">Half-STICoins now:</label>
		<input type="radio"  id="PaymentMode1" onclick="formsyncfunction()" name="PaymentMode" value="Half-STICoins"  disabled><br>
		<label for="FullNow">Full-STICoins now:</label>
		<input type="radio"  id="PaymentMode2" onclick="formsyncfunction()" name="PaymentMode" value="Full-STICoins" disabled><br>
		<label for="FullLater">Full-STICoins later :</label>
		<input type="radio" id="PaymentMode3" onclick="formsyncfunction()" name="PaymentMode" value="Full-STICoins_Later" disabled><br>
		<br>';
			
		}
		echo'</br>';
		if($Type=="Seller" && $ContractObj->Status == "Buyer has accepted service" || $Type=="Buyer" && $ContractObj->Status == "Seller has accepted service"|| $ContractObj->Status == "Deal"){
			echo'<input type="button" name="service" id="service" onclick="AcceptService()" value="Service fullfilled">';
		}
		if($Type == "Buyer" && $ContractObj->Status == "Transaction Complete"){
			echo'</br><input type="button" name="refund" id="refund" onclick="RequestRefund()" value="Request Refund">';
		}
		if($Type == "Seller" && $ContractObj->Transaction == "On-Going" && $ContractObj->Status != "Order Cancelled" && $ContractObj->Status != "Buyer has accepted service"){
				
				echo'</br><input type="button" name="cancel" id="cancel" onclick="CancelOrder()" value="Cancel Order">';
			
				
		}
		
?>
<button id="Accept" name="Accept" value="Accept" onclick="Accept()">Sign Contract</button>
<button id="Reject" name="Reject" value="Reject" onclick="Reject()">Reject Contract</button>
<?php 
if($Type=="Admin"){
if($ContractObj->Status == "Requested Refund"){
	echo'<button id="Refund_Admin" name="Refund_Admin" value="Refund Buyer" onclick="Refund_Admin()">Refund Buyer</button>';
}
echo'<form action="UserManagementPage.php?ID='.$ContractObj->SellerUserID.'" method="post"><input type="submit" value="Take disciplinary action on seller"></form>';
echo'<form action="UserManagementPage.php?ID='.$ContractObj->BuyerUserID.'"method="post"><input type="submit" value="Take disciplinary action on buyer"></form>';
if($ContractObj->Status == "Admin has halted this transaction"){
echo'<form method="post"><input type="submit" name="ResumeTranasction" value="Resume Transaction"></form>';	
}
}
if(isset($_POST['ResumeTranasction'])){
	$_SESSION['Object']->ResumeTranasction($ContractObj->ContractID,$ContractObj->Transaction);
	echo'<script>location.replace("ContractManagementPage.php");</script>';
}

?>

</div>
<div id="chatbox">
	<h1>Contract ID:<?php echo $ContractID?></h1>
<?php if($Type!="Admin"){ ?>
	<h1>Dealing with:<?php  if(isset($_SESSION['OtherUser'])){echo $_SESSION['OtherUser'];}?></h1>
	<h1>Your Party Type:<?php echo $Type?></h1>
<?php }
	 else{
?>
		<h1>Dealing with Buyer:<?php echo $ContractObj->BuyerUserID?></h1> 
		<h1>Dealing with Seller:<?php echo $ContractObj->SellerUserID?></h1> 
<?php
	 }

?>	
	<div id="message-box">
	<span> Welcome User</span>

		<?php 
		$_SESSION['Object']->RetrieveChat($ContractObj->ContractID)?>	
	</div>
	<div id="connecting">Connecting to web sockets server...</div>

	<input type="text" class="text-box" id="message-input" placeholder="Your Message" onkeyup="handleKeyUp(event)">
	<p>Press enter to send message</p>
</div>
<?php
if($Type=="Admin" || $ContractObj->Status == "Admin has halted this transaction"|| $ContractObj->Status == "Buyer has accepted" && $Type == "Buyer" || $ContractObj->Status == "Rejected" ||  $ContractObj->Status == "Order Cancelled" || $ContractObj->Status ==  "Requested Refund" || $ContractObj->Status == "Deal" ||$ContractObj->Status == "Buyer has accepted service" || $ContractObj->Status == "Seller has accepted service"){

?>
<script>
	document.getElementById('Accept').style.display = "None";
	document.getElementById('Offer').disabled = true;
	document.getElementById('DateRequired').disabled = true;
	document.getElementById('PaymentMode3').disabled = true;
	document.getElementById('PaymentMode2').disabled = true;
	document.getElementById('PaymentMode1').disabled = true;
</script>
<?php
}
if($Type=="Admin" || $ContractObj->Status == "Admin has halted this transaction"|| $ContractObj->Status == "Rejected" || $ContractObj->Status ==  "Requested Refund" ||$ContractObj->Status == "Order Cancelled" ||  $ContractObj->Status == "Deal" || $ContractObj->Status == "Seller has accepted service" || $ContractObj->Status == "Buyer has accepted service" || $ContractObj->Status == "Transaction Complete" ){
?>
<script>
	document.getElementById('Reject').style.display = "None";
	

</script>
<?php
}
if($ContractObj->Status == "Seller has accepted" && $Type == "Seller"){
?>
<script>
	document.getElementById('Accept').style.display = "None";
	document.getElementById('Offer').disabled = true;
</script>
<?php
}
if($ContractObj->Transaction == "Negotiating"){
?>
<script>
var Intervals = setInterval(checkaccepted,3000);
function checkaccepted(){

	var ajax = new XMLHttpRequest();
	ajax.open("POST", "ContractPageController.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("&CheckAccepted=" + ContractID);
	console.log(ajax);

}
</script>
<?php	
}
else if($ContractObj->Transaction == "On-Going"){
?>
<script>
var Intervals2 = setInterval(checkserviceaccepted,3000);
function checkserviceaccepted(){
	var ajax = new XMLHttpRequest();
	ajax.open("POST", "ContractPageController.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("&CheckServiceAccepted=" + ContractID);
	console.log(ajax);

}
</script>
<?php	
}
else{
?>
<script>
	document.getElementById('Accept').style.display = "None";
	document.getElementById('Reject').style.display = "None";
	document.getElementById('Offer').disabled = true;
	document.getElementById('DateRequired').disabled = true;
	document.getElementById('PaymentMode3').disabled = true;
	document.getElementById('PaymentMode2').disabled = true;
	document.getElementById('PaymentMode1').disabled = true;
</script>
<?php	
}
?>
<script>
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (document.getElementById('PaymentMode1').value == document.getElementById("Payment").value) {
	document.getElementById('PaymentMode1').checked = true;

}
if (document.getElementById('PaymentMode2').value == document.getElementById("Payment").value) {
	document.getElementById('PaymentMode2').checked = true;

}
if (document.getElementById('PaymentMode3').value == document.getElementById("Payment").value) {
	document.getElementById('PaymentMode3').checked = true;

} 
//initialise all required variables from php -> Js
var User = document.getElementById("UserID").value.trim(),
ContractID =  document.getElementById("contractid").value.trim(),
Balance = Number(document.getElementById("Balance").value),
messageInput = document.getElementById("message-input"),
UserType =  document.getElementById("usertype").value.trim();
if (UserType=="Admin") {
	SellerBalance = document.getElementById("SellerBalance").value;
	
}
		
function handleKeyUp(e) {
	
	if (e.keyCode === 13) {
		sendMessage();
	}
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function sendMessage() {

	var message = messageInput.value.trim();

	var ajax = new XMLHttpRequest();
	ajax.open("POST", "ContractPageController.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("User=" + User + "&message=" + message + "&contractid=" + ContractID + "&usertype=" + UserType );
	console.log(ajax);
	messageInput.value = "";
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function formsyncfunction(){

	var Offer =  document.getElementById("Offer").value.trim();
	DateRequired =  document.getElementById("DateRequired").value.trim();
	
	if (document.getElementById('PaymentMode1').checked) {
	  PaymentMode = document.getElementById('PaymentMode1').value;
	 
	}
	if (document.getElementById('PaymentMode2').checked) {
	  PaymentMode = document.getElementById('PaymentMode2').value;
	 
	}
	if (document.getElementById('PaymentMode3').checked) {
	  PaymentMode = document.getElementById('PaymentMode3').value;
	 
	}
	
	var ajax = new XMLHttpRequest();
	ajax.open("POST", "ContractPageController.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("User=" + User + "&offer=" + Offer + "&daterequired=" + DateRequired + "&paymentmode=" + PaymentMode + "&contractid=" + ContractID + "&usertype=" + UserType);
	console.log(ajax);
	var ajax = new XMLHttpRequest();
	ajax.open("POST", "ContractPageController.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("User=" + User + "&contractid=" + ContractID + "&message=" + " has updated the offer");
	console.log(ajax);
	
	
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function Accept(){

	if(document.getElementById('PaymentMode2').checked && UserType =="Buyer"){
		if(Balance < document.getElementById("Offer").value){
			alert("You have insufficient balance,please top up STICoins");
		}
		else{
			SendAccept();
			
		}
	}
	else if(document.getElementById('PaymentMode1').checked && UserType =="Buyer"){

		if(Balance < (document.getElementById("Offer").value/2)){
			
			alert("You have insufficient balance,please top up STICoins");
		}
		else{
			SendAccept();
			
		}
	}
	else{
		SendAccept();	
	}
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function SendAccept(){
document.getElementById('Accept').style.display = "None";
document.getElementById('Reject').style.display = "None";
document.getElementById("Offer").disabled = true;
document.getElementById("DateRequired").disabled = true;
document.getElementById('PaymentMode3').disabled = true;
document.getElementById('PaymentMode2').disabled = true;
document.getElementById('PaymentMode1').disabled = true;
var ajax = new XMLHttpRequest();
ajax.open("POST", "ContractPageController.php", true);
ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
ajax.send("Accept=" + User + "&contractid=" + ContractID + "&usertype=" + UserType + "&User=" + User);
var ajax = new XMLHttpRequest();
ajax.open("POST", "ContractPageController.php", true);
ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
ajax.send("User=" + User + "&contractid=" + ContractID + "&message=" + " has accepted the offer");
console.log(ajax);
console.log(ajax);
	
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function Reject(){
	document.getElementById('Accept').style.display = "None";
	document.getElementById('Reject').style.display = "None";
	document.getElementById("Offer").disabled = true;
	document.getElementById("DateRequired").disabled = true;
	document.getElementById('PaymentMode3').disabled = true;
	document.getElementById('PaymentMode2').disabled = true;
	document.getElementById('PaymentMode1').disabled = true;
	var ajax = new XMLHttpRequest();
	ajax.open("POST", "ContractPageController.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("Reject=" + User + "&contractid=" + ContractID );
	console.log(ajax);
	var ajax = new XMLHttpRequest();
	ajax.open("POST", "ContractPageController.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("message=" + " has rejected the offer,Transaction declined" + "&contractid=" + ContractID + "&usertype=" + UserType + "&User=" + User );
	console.log(ajax);
	
	
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function AcceptService(){
if(document.getElementById('PaymentMode3').checked && UserType =="Buyer"){
	if(Balance < document.getElementById("Offer").value){
		alert("You have insufficient balance,please top up STICoins");
	}
	else{
		SendAcceptService();
		
	}
}
else if(document.getElementById('PaymentMode1').checked && UserType =="Buyer"){

	if(Balance < (document.getElementById("Offer").value/2)){
		
		alert("You have insufficient balance,please top up STICoins");
	}
	else{
		SendAcceptService();
		
	}
}
else{
	SendAcceptService();	
}
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function SendAcceptService(){
	document.getElementById('service').style.display = "none";
	var ajax = new XMLHttpRequest();
	ajax.open("POST", "ContractPageController.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("AcceptService=" + User + "&contractid=" + ContractID + "&usertype=" + UserType + "&User=" + User);
	console.log(ajax);
	ajax.open("POST", "ContractPageController.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("message=" + " has agreed upon the service" + "&contractid=" + ContractID + "&usertype=" + UserType + "&User=" + User );
	console.log(ajax);

}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function RequestRefund(){
	var ajax = new XMLHttpRequest();
	ajax.open("POST", "ContractPageController.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("Refund=" + User + "&contractid=" + ContractID + "&usertype=" + UserType + "&User=" + User);
	console.log(ajax);
	var ajax = new XMLHttpRequest();
	ajax.open("POST", "ContractPageController.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("message=" + " has requested refund" + "&contractid=" + ContractID + "&usertype=" + UserType + "&User=" + User );
	console.log(ajax);
	location.reload();
	
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function CancelOrder(){
	if(document.getElementById('PaymentMode2').checked && UserType =="Seller"){
	if(Balance < document.getElementById("Offer").value){
		alert("You have insufficient balance,please top up STICoins");
	}
	else{
		SendCancelOrder();
		
	}
}
else if(document.getElementById('PaymentMode1').checked && UserType =="Seller"){

	if(Balance < (document.getElementById("Offer").value/2)){
		
		alert("You have insufficient balance,please top up STICoins");
	}
	else{
		SendCancelOrder();
		
	}
}
else{
	SendCancelOrder();	
}
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function SendCancelOrder(){
	var ajax = new XMLHttpRequest();
	ajax.open("POST", "ContractPageController.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("Cancel=" + User + "&contractid=" + ContractID + "&usertype=" + UserType + "&User=" + User);
	console.log(ajax);
	var ajax = new XMLHttpRequest();
	ajax.open("POST", "ContractPageController.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("message=" + " has cancelled order.Sorry for the inconvenience,your STICoins will return to you shortly." + "&contractid=" + ContractID + "&usertype=" + UserType + "&User=" + User );
	console.log(ajax);
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function Refund_Admin(){

	if(Number(SellerBalance) < document.getElementById("Offer").value){
		alert("You have insufficient balance,please top up STICoins");
	}
	else{
		SendRefund_Admin();
	}
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function SendRefund_Admin(){
	var ajax = new XMLHttpRequest();
	ajax.open("POST", "ContractPageController.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("RefundAdmin=" + User + "&contractid=" + ContractID + "&usertype=" + UserType + "&User=" + User);
	console.log(ajax);
	var ajax = new XMLHttpRequest();
	ajax.open("POST", "ContractPageController.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("message=" + " has refunded for buyer." + "&contractid=" + ContractID + "&usertype=" + UserType + "&User=" + User );
	console.log(ajax);
}
const socket = new WebSocket('ws://localhost:3030');

// Connection opened
socket.addEventListener('open', function (event) {
    socket.send('Hello Server!');
	connectingSpan.style.display = "none";
});

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*window.WebSocket = window.WebSocket || window.MozWebSocket;

var connection =  new WebSocket('ws://localhost:3030',null);
var connectingSpan = document.getElementById("connecting");
connection.onopen = function () {
	
	connectingSpan.style.display = "none";
};
connection.onerror = function (error) {
	connectingSpan.innerHTML = "Error occured";
};
connection.onmessage = function (message) {
	var data = JSON.parse(message.data);

	if(data.ContractID==document.getElementById("contractid").value.trim()){
			
			if (typeof data.message != 'undefined') {
				// the variable is defined

			var div = document.createElement("div");
			var author = document.createElement("span");
			author.className = "author";
			if(data.Type=="Admin"){
				author.innerHTML = data.User+"(Administrator):";
			}
			else{
				author.innerHTML = data.User+":";
			}
			
			var message = document.createElement("span");
			message.className = "messsage-text";
			message.innerHTML = data.message;
			if(data.User == User){
				div.setAttribute("id", "User1");
				
			}	
			else{
				div.setAttribute("id", "User2");
				
			}
			div.appendChild(author);
			div.appendChild(message);
			
			var objDiv = document.getElementById("message-box");
			objDiv.scrollTop = objDiv.scrollHeight;
			document.getElementById("message-box").appendChild(div);
			}
			if (typeof data.offer != 'undefined') {
				document.getElementById('Accept').style.display = "inline";
				document.getElementById('Reject').style.display = "inline";
				document.getElementById("Offer").disabled = false;
				document.getElementById("DateRequired").disabled = false;
				document.getElementById('PaymentMode3').disabled = false;
				document.getElementById('PaymentMode2').disabled = false;
				document.getElementById('PaymentMode1').disabled = false;
				document.getElementById('Offer').value = data.offer;
				document.getElementById('DateRequired').value = data.daterequired;
				console.log(data.paymentmode);
				if (document.getElementById('PaymentMode1').value == data.paymentmode ) {
						document.getElementById('PaymentMode1').checked = true;
				 
				}
				if (document.getElementById('PaymentMode2').value == data.paymentmode ) {
						document.getElementById('PaymentMode2').checked = true;
				 
				}
				if (document.getElementById('PaymentMode3').value == data.paymentmode ) {
						document.getElementById('PaymentMode3').checked = true;
				 
				}

			}
			
			
			if (typeof data.REPLY != 'undefined') {
				if (data.REPLY == 'CheckAccepted') 
				{
					if(data.Deal=="set")
					{
						clearInterval(Intervals);
						var ajax = new XMLHttpRequest();
						ajax.open("POST", "ContractPageController.php", true);
						ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						ajax.send("Transfer=" + ContractID);
						console.log(ajax);
						var delayInMilliseconds = 1000; //1 second

						setTimeout(function() {
						//your code to be executed after 1 second
						}, delayInMilliseconds);
						location.replace("MyContractsPage.php");

					}
				}
				if (data.REPLY == 'CheckServiceAccepted') {

				if(data.DealComplete=="set"){

					clearInterval(Intervals2);
					var ajax = new XMLHttpRequest();
					ajax.open("POST", "ContractPageController.php", true);
					ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					ajax.send("Transfer=" + ContractID);
					console.log(ajax);
					var delayInMilliseconds = 2000; //1 second

					setTimeout(function() {
					//your code to be executed after 1 second
					}, delayInMilliseconds);
					location.replace("RatingPage.php");
					

				}


				}
				if(data.REPLY=="Reject"){
					document.getElementById('Accept').disabled = true;
					document.getElementById('Reject').disabled = true;
					document.getElementById("Offer").disabled = true;
					document.getElementById("DateRequired").disabled = true;
					document.getElementById('PaymentMode3').disabled = true;
					document.getElementById('PaymentMode2').disabled = true;
					document.getElementById('PaymentMode1').disabled = true;
					document.getElementById('statusmessage').innerHTML = "Status:Offer Rejected, Transaction declined.";
					location.replace("MyContractsPage.php");
				}
				
				if(data.REPLY=='Cancel'){
					document.getElementById('Accept').disabled = true;
					document.getElementById('Reject').disabled = true;
					document.getElementById("Offer").disabled = true;
					document.getElementById("DateRequired").disabled = true;
					document.getElementById('PaymentMode3').disabled = true;
					document.getElementById('PaymentMode2').disabled = true;
					document.getElementById('PaymentMode1').disabled = true;
					document.getElementById('statusmessage').innerHTML = "Status:Seller has cancelled the order, sorry for any inconvenience caused,STICoins will be returned to the buyer , as soon as possible.";
					location.replace("MyContractsPage.php");
				}
				if(data.REPLY=='Refund'){
					document.getElementById('Accept').disabled = true;
					document.getElementById('Reject').disabled = true;
					document.getElementById("Offer").disabled = true;
					document.getElementById("DateRequired").disabled = true;
					document.getElementById('PaymentMode3').disabled = true;
					document.getElementById('PaymentMode2').disabled = true;
					document.getElementById('PaymentMode1').disabled = true;
					document.getElementById('statusmessage').innerHTML = "Status:Buyer refunded,await Admin assistance.";
					
				}
				if (data.REPLY == 'AcceptService') {
					if(UserType == "Seller"){
						document.getElementById('cancel').style.display = "none";
					}
					
					document.getElementById('statusmessage').innerHTML = "Status:"+ data.Type + " has accepted service";
				}
				if (data.REPLY == 'AcceptOffer') {
					document.getElementById('statusmessage').innerHTML = "Status:"+ data.Type + " has accepted offer";
				}
				if (data.REPLY == 'AdminRefund') {
					location.replace("MyContractsPage.php");
				}
			}
			
		
	}
}*/
var objDiv = document.getElementById("message-box");
objDiv.scrollTop = objDiv.scrollHeight;

	
</script>
</body>
<?php require_once("Footer.php");?>