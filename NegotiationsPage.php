<?php
require_once("NavBar.php");

if($_SESSION['ID'] == 'DemoUser0'){
	$OtherUser = 'DemoUser1';
}
else{
	$OtherUser = 'DemoUser0';	
}

?>


<style type="text/css">
		* {
		box-sizing:border-box;
	}
	#content {
		width:600px;
		max-width:100%;
		margin:30px auto;
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
<body>
<div id="content">
	<div id="message-box">
		<?php $_SESSION['Object']->RetrieveChat($_SESSION['ID'],$OtherUser)?>	
	</div>
	<div id="connecting">Connecting to web sockets server...</div>
	<input type="hidden" class="text-box" id="User1-input"  value = "<?php echo $_SESSION['ID']?>">
	<input type="hidden" class="text-box" id="User2-input"  value = "<?php echo $OtherUser?>">
	<input type="text" class="text-box" id="message-input" placeholder="Your Message" onkeyup="handleKeyUp(event)">
	<p>Press enter to send message</p>
</div>
<script>


var User1Input = document.getElementById("User1-input"),
	User2Input = document.getElementById("User2-input"),
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
	ajax.send("User1=" + User1 +  "&User2=" + User2 + "&message=" + message);
	console.log(ajax);
	messageInput.value = "";
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
	console.log(data.User2);
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
	var objDiv = document.getElementById("message-box");
objDiv.scrollTop = objDiv.scrollHeight;
	
</script>
</body>
