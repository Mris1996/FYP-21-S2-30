<?php
require_once("NavBar.php");
if($_SESSION['ID'] == 'DemoUser0'){
	$_SESSION['OtherUser'] = 'DemoUser1';
}
else{
$_SESSION['OtherUser'] = 'DemoUser0';	
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
		padding:20px;
	}
	#message-box {
		min-height:400px;
		overflow:auto;
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
</style>

</head>
<body>
<div id="content">
	<div id="message-box">
		<?php $_SESSION['Object']->RetrieveChat()?>	
	</div>
	<div id="connecting">Connecting to web sockets server...</div>
	<input type="hidden" class="text-box" id="name-input" placeholder="Your Name" value = "<?php echo $_SESSION['Object']->getUID()?>">
	<input type="text" class="text-box" id="message-input" placeholder="Your Message" onkeyup="handleKeyUp(event)">
	<p>Press enter to send message</p>
</div>
<script>

var nameInput = document.getElementById("name-input"),
	messageInput = document.getElementById("message-input");

function handleKeyUp(e) {
	
	if (e.keyCode === 13) {
		sendMessage();
	}
}
function sendMessage() {
	var name = nameInput.value.trim(),
		message = messageInput.value.trim();

	if (!name)
		return alert("Please fill in the name");

	if (!message)
		return alert("Please write a message");

	var ajax = new XMLHttpRequest();
	ajax.open("POST", "php-send-message.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("name=" + name + "&message=" + message);
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
	
	var div = document.createElement("div");
	var author = document.createElement("span");
		author.className = "author";
		author.innerHTML = data.name;
	var message = document.createElement("span");
		message.className = "messsage-text";
		message.innerHTML = data.message;

	div.appendChild(author);
	div.appendChild(message);

	document.getElementById("message-box").appendChild(div);

}

</script>
</body>
