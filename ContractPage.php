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
	echo '<script> location.replace("index.php")</script> ';
}



?>


<style type="text/css">
		* {
		box-sizing:border-box;
	}
	#content {
		float:right;
		width:1000px;
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
if($ContractObj->SellerUserID==$_SESSION['ID']){
	$Type = "Seller";
	$_POST["Chat_with"] = $ContractObj->BuyerUserID;
}

$ProductObj = new Products();
$ProductObj->InitialiseProduct($ContractObj->ProductID);
if (isset($_POST["Chat_with"])){

	$_SESSION['OtherUser'] = $_POST["Chat_with"];
	echo'<style> #content{display:block;}</style>';
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
<input type="hidden" class="text-box" id="User1-input"  value = "<?php echo $_SESSION['ID']?>">
<input type="hidden" class="text-box" id="User2-input"  value = "<?php echo $_SESSION['OtherUser']?>">
<input type="hidden" class="text-box" id="contractid"  value = "<?php echo $_GET['ID']?>">
<input type="hidden" class="text-box" id="usertype"  value = "<?php echo $Type?>">
<input type="hidden" class="text-box" id="Payment"  value = "<?php echo $ContractObj->PaymentMode?>">
<input type="hidden" class="text-box" id="Balance"  value = "<?php echo $_SESSION['Object']->getAccountBalance()?>">
<div id="sharedform">

<img src="<?php echo $ProductObj->Image;?>" style="width:50%;margin:auto"></br>
<label>Product Name:</label><b><?php echo $ProductObj->ProductName;?></b></br>
<label>Product Owner:</label><b><?php echo $_SESSION['Object']->getUserDisplayName($ProductObj->SellerUserID)?></b></br>
<label>Product Caption:</label><b><?php echo $ProductObj->ProductCaption?></b></br>
<label>Product Description:</label><b><?php echo $ProductObj->ProductDescription?></b></br>
<label>Product Initial Price:</label><b><?php echo $ProductObj->ProductInitialPrice?></b></br>


<h2>Your Offer</h2>
<?php
		if($Type == "Buyer"){
		echo'
		<label>Date product is required by:</label>
		<input type="date"  id ="DateRequired" name="DateRequired" oninput="formsyncfunction()" value="'.$ContractObj->DateRequired.'" required>';
		}
		if($Type == "Seller"){
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
		<input type="radio"  id="PaymentMode1" onclick="formsyncfunction()" name="PaymentMode" value="Half-STICoins" >
		<label for="Half">Half-STICoins now:</label><br>
		<input type="radio"  id="PaymentMode2" onclick="formsyncfunction()" name="PaymentMode" value="Full-STICoins">
		<label for="female">Full-STICoins now:</label><br>
		<input type="radio" id="PaymentMode3" onclick="formsyncfunction()" name="PaymentMode" value="Cash">
		<label for="Cash">Cash on delivery:</label><br><br>';
		}
		if($Type == "Seller"){
			echo'
		<label>Offer will be rounded up to whole number</label><br /><br />
		<label> Payment Mode</label><br>
		<input type="radio"  id="PaymentMode1" onclick="formsyncfunction()" name="PaymentMode" value="Half-STICoins"  disabled>
		<label for="Half">Half-STICoins now:</label><br>
		<input type="radio"  id="PaymentMode2" onclick="formsyncfunction()" name="PaymentMode" value="Full-STICoins" disabled>
		<label for="FullNow">Full-STICoins now:</label><br>
		<input type="radio" id="PaymentMode3" onclick="formsyncfunction()" name="PaymentMode" value="Full-STICoins_Later" disabled>
		<label for="FullLater">Full-STICoins later :</label><br><br>';
			
		}
		echo'</br>';
		if($Type=="Seller" && $ContractObj->Status == "Buyer has accepted service" || $Type=="Buyer" && $ContractObj->Status == "Seller has accepted service" ){
			echo'<input type="button" name="service" id="service" onclick="AcceptService()" value="Service fullfilled">';
		}
		if($ContractObj->Status == "Deal"){
			echo'</br><input type="button" name="service" id="service" onclick="AcceptService()" value="Service fullfilled">';	
			if($Type == "Buyer" && $ContractObj->PaymentMode=="Half-STICoins" || $ContractObj->PaymentMode=="Full-STICoins"  ||$ContractObj->Status == "Transaction Complete"){
				echo'</br><input type="button" name="refund" id="refund" onclick="RequestRefund()" value="Request Refund">';
			}
			else{
				echo'</br><input type="button" name="Cancel" value="Cancel Order">';
			}
			
		}
		if($Type == "Buyer" && $ContractObj->Status == "Transaction Complete"){
			echo'</br><input type="button" name="refund" id="refund" onclick="RequestRefund()" value="Request Refund">';
		}
		
?>
<button id="Accept" name="Accept" value="Accept" onclick="accept()">Accept</button>
<button id="Reject" name="Reject" value="Reject" onclick="reject()">Reject</button>
<h1 id="statusmessage">Status:<?php 
if($ContractObj->Status == "Deal"){
	
echo 'Contract agreed upon, awaiting for product to be transferred';

}
else if($ContractObj->Status == "Requested Refund"){
 echo 'Buyer has requested refund for product';	
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
else{
echo 'Terms are being negotiated';	
	
}


?></h1>
<div>
<div id="content">
	
	<h1>Contract ID:<?php echo $ContractID?></h1>
	<h1>Dealing with:<?php echo $_SESSION['OtherUser']?></h1>
	<h1>Party Type:<?php echo $Type?></h1>
	<div id="message-box">
	<span> Welcome User</span>
	
		<?php 
		$_SESSION['Object']->RetrieveChat($_SESSION['ID'],$_SESSION['OtherUser'])?>	
	</div>
	<div id="connecting">Connecting to web sockets server...</div>

	<input type="text" class="text-box" id="message-input" placeholder="Your Message" onkeyup="handleKeyUp(event)">
	<p>Press enter to send message</p>
</div>
<?php
if($ContractObj->Status == "Buyer has accepted" && $Type == "Buyer" || $ContractObj->Status == "Rejected" || $ContractObj->Status ==  "Requested Refund" || $ContractObj->Status == "Deal" ||$ContractObj->Status == "Buyer has accepted service" || $ContractObj->Status == "Seller has accepted service"){

?>
<script>
	document.getElementById('Accept').disabled = true;
	document.getElementById('Offer').disabled = true;
	document.getElementById('DateRequired').disabled = true;
	document.getElementById('PaymentMode3').disabled = true;
	document.getElementById('PaymentMode2').disabled = true;
	document.getElementById('PaymentMode1').disabled = true;
</script>
<?php
}
if($ContractObj->Status == "Rejected" || $ContractObj->Status ==  "Requested Refund" || $ContractObj->Status == "Deal" || $ContractObj->Status == "Seller has accepted service" || $ContractObj->Status == "Buyer has accepted service" || $ContractObj->Status == "Transaction Complete" ){
?>
<script>
	document.getElementById('Reject').disabled = true;

</script>
<?php
}
if($ContractObj->Status == "Seller has accepted" && $Type == "Seller"){
?>
<script>
	document.getElementById('Accept').disabled = true;
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
	ajax.open("POST", "php-send-message.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("&CheckAccepted=" + ContractID);
	console.log(ajax);

}
</script>
<?php	
}
if($ContractObj->Transaction == "On-Going"){
?>
<script>
var Intervals2 = setInterval(checkserviceaccepted,3000);
function checkserviceaccepted(){
	var ajax = new XMLHttpRequest();
	ajax.open("POST", "php-send-message.php", true);
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
	document.getElementById('Accept').disabled = true;
	document.getElementById('Reject').disabled = true;
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

if (document.getElementById('PaymentMode1').value == document.getElementById("Payment").value) {
	document.getElementById('PaymentMode1').checked = true;

}
if (document.getElementById('PaymentMode2').value == document.getElementById("Payment").value) {
	document.getElementById('PaymentMode2').checked = true;

}
if (document.getElementById('PaymentMode3').value == document.getElementById("Payment").value) {
	document.getElementById('PaymentMode3').checked = true;

}

var User1Input = document.getElementById("User1-input"),
	User2Input = document.getElementById("User2-input"),
	ContractID =  document.getElementById("contractid").value.trim(),
	messageInput = document.getElementById("message-input");

function handleKeyUp(e) {
	
	if (e.keyCode === 13) {
		sendMessage();
	}
}
function sendMessage() {
	var User1 = User1Input.value.trim(),
		User2 = User2Input.value.trim(),
		message = messageInput.value.trim();

	var ajax = new XMLHttpRequest();
	ajax.open("POST", "php-send-message.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("User1=" + User1 +  "&User2=" + User2 + "&message=" + message + "&contractid=" + ContractID);
	console.log(ajax);
	messageInput.value = "";
}

function accept(){
	document.getElementById('Accept').disabled = true;
	document.getElementById("Offer").disabled = true;
	document.getElementById("DateRequired").disabled = true;
	document.getElementById('PaymentMode3').disabled = true;
	document.getElementById('PaymentMode2').disabled = true;
	document.getElementById('PaymentMode1').disabled = true;
	var UserType =  document.getElementById("usertype").value.trim(),
		User1 = User1Input.value.trim(),
		User2 = User2Input.value.trim();
	var ajax = new XMLHttpRequest();
	ajax.open("POST", "php-send-message.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("Accept=" + User1 + "&contractid=" + ContractID + "&usertype=" + UserType + "&User1=" + User1 +  "&User2=" + User2 + "&message=" + " has accepted the offer");
	console.log(ajax);
	
}
function reject(){
	document.getElementById('Accept').disabled = true;
	document.getElementById("Offer").disabled = true;
	document.getElementById("Reject").disabled = true;
	document.getElementById("DateRequired").disabled = true;
	document.getElementById('PaymentMode3').disabled = true;
	document.getElementById('PaymentMode2').disabled = true;
	document.getElementById('PaymentMode1').disabled = true;
	var UserType =  document.getElementById("usertype").value.trim(),
		User1 = User1Input.value.trim(),
		User2 = User2Input.value.trim();
	var ajax = new XMLHttpRequest();
	ajax.open("POST", "php-send-message.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("Reject=" + User1 + "&contractid=" + ContractID + "&usertype=" + UserType + "&User1=" + User1 +  "&User2=" + User2 );
	console.log(ajax);
	var ajax = new XMLHttpRequest();
	ajax.open("POST", "php-send-message.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("message=" + " has rejected the offer,Transaction declined" + "&contractid=" + ContractID + "&usertype=" + UserType + "&User1=" + User1 +  "&User2=" + User2 );
	console.log(ajax);
	
	
	
	
}
function AcceptService(){
	var UserType =  document.getElementById("usertype").value.trim(),
		User1 = User1Input.value.trim(),
		User2 = User2Input.value.trim();
	var ajax = new XMLHttpRequest();
	ajax.open("POST", "php-send-message.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("AcceptService=" + User1 + "&contractid=" + ContractID + "&usertype=" + UserType + "&User1=" + User1 +  "&User2=" + User2);
	console.log(ajax);
	ajax.open("POST", "php-send-message.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("&contractid=" + ContractID + "&usertype=" + UserType + "&User1=" + User1 +  "&User2=" + User2 + "&message=" + " has agreed upon the service");
	console.log(ajax);
	location.reload();
}
function formsyncfunction(){

	var User1 = User1Input.value.trim(),
	User2 = User2Input.value.trim(),
	Offer =  document.getElementById("Offer").value.trim();
	DateRequired =  document.getElementById("DateRequired").value.trim(),
	UserType =  document.getElementById("usertype").value.trim();
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
	ajax.open("POST", "php-send-message.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("User1=" + User1 +  "&User2=" + User2 + "&offer=" + Offer + "&daterequired=" + DateRequired + "&paymentmode=" + PaymentMode + "&contractid=" + ContractID + "&usertype=" + UserType);
	console.log(ajax);
	var ajax = new XMLHttpRequest();
	ajax.open("POST", "php-send-message.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("User1=" + User1 +  "&User2=" + User2 + "&contractid=" + ContractID + "&message=" + " has updated the offer");
	console.log(ajax);
	
	
}
function RequestRefund(){
	var UserType =  document.getElementById("usertype").value.trim(),
	User1 = User1Input.value.trim(),
	User2 = User2Input.value.trim();
	var ajax = new XMLHttpRequest();
	ajax.open("POST", "php-send-message.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("Refund=" + User1 + "&contractid=" + ContractID + "&usertype=" + UserType + "&User1=" + User1 +  "&User2=" + User2 );
	console.log(ajax);
	var ajax = new XMLHttpRequest();
	ajax.open("POST", "php-send-message.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("message=" + " has requested refund" + "&contractid=" + ContractID + "&usertype=" + UserType + "&User1=" + User1 +  "&User2=" + User2 );
	console.log(ajax);
	
	
}
// web sockets
window.WebSocket = window.WebSocket || window.MozWebSocket;

var connection = new WebSocket('ws://localhost:3030');
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
			author.innerHTML = data.User1+":";
			var message = document.createElement("span");
			message.className = "messsage-text";
			message.innerHTML = data.message;
			if(data.User1 == User1Input.value.trim()){
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
			if (typeof data.Deal != 'undefined') {
				if(data.Deal=="set"){
					clearInterval(Intervals);
					var ajax = new XMLHttpRequest();
					ajax.open("POST", "php-send-message.php", true);
					ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					ajax.send("Transfer=" + ContractID);
					console.log(ajax);
				var delayInMilliseconds = 1000; //1 second

				setTimeout(function() {
				  //your code to be executed after 1 second
				}, delayInMilliseconds);
					location.reload();	
					
				}
				
			}
				if (typeof data.DealComplete != 'undefined') {
				 
				if(data.DealComplete=="set"){
					
					clearInterval(Intervals2);
					var ajax = new XMLHttpRequest();
					ajax.open("POST", "php-send-message.php", true);
					ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					ajax.send("Transfer=" + ContractID);
					console.log(ajax);
				var delayInMilliseconds = 2000; //1 second

				setTimeout(function() {
				  //your code to be executed after 1 second
				}, delayInMilliseconds);
					location.reload();	
					
				}
		
				
				
			}
			if (typeof data.Declined != 'undefined') {
				
				if(data.Declined=="set"){
					document.getElementById('Accept').disabled = true;
					document.getElementById('Reject').disabled = true;
					document.getElementById("Offer").disabled = true;
					document.getElementById("DateRequired").disabled = true;
					document.getElementById('PaymentMode3').disabled = true;
					document.getElementById('PaymentMode2').disabled = true;
					document.getElementById('PaymentMode1').disabled = true;
					document.getElementById('statusmessage').innerHTML = "Status:Offer Rejected, Transaction declined.";
					
				}
			}
			if (typeof data.REPLY != 'undefined') {
				if (data.REPLY == 'AcceptService') {
					document.getElementById('statusmessage').innerHTML = "Status:"+ data.Type + " has accepted service";
				}
			}
			
		
	}
}
var objDiv = document.getElementById("message-box");
objDiv.scrollTop = objDiv.scrollHeight;

	
</script>
</body>
