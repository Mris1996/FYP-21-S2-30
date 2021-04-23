<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"   "http://www.w3.org/TR/html4/strict.dtd">

			<script src='//cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.4/socket.io.min.js'></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>

			<script>
			var socket = io.connect('//127.0.0.1:3000');

			socket.on('connect', function () {
			console.log('connected');

			socket.on('localhost', function (data) {
			console.log(data);
			socket.emit("/getMessages", data);



			socket.on('disconnect', function () {
			console.log('disconnected');
			});
			});
			function passVal(){
			var data = {
			fn: "filename",
			str: "this_is_a_dummy_test_string"
			};

			$.post("uow", data);
			}
			passVal();
			</script>
			
		<form method="post">
<input type = "Submit" name="SignupButotn" value ="Sign Up"/>
</form>
			<?php
			require('C:\Users\Ris\vendor\autoload.php');

			use ElephantIO\Client;
			use ElephantIO\Engine\SocketIO\Version1X;

			$elephant = new Client(new Version1X('//127.0.0.1:3000'));
		

			//$client->initialize();
			// send message to connected clients
			if(isset($_POST['SignupButotn'])){
				//$client->emit('localhost', ['type' => 'notification', 'text' => 'Hello There!']);
			//$client->close();

			$elephant->init();
			$elephant->send(
			ElephantIOClient::TYPE_EVENT,
			null,
			null,
			json_encode(array('name' => 'foo', 'args' => 'bar'))
			);
			$elephant->close();

			echo 'tryin to send `bar` to the event `foo`';
			}
						
			
			
			?>
			
			
			