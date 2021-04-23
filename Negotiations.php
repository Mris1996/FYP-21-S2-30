<!DOCTYPE html>  <!--Specify type of document -->
<html lang="en"> <!--Set Language of the page -->
	<head>
		<meta charset="utf-8"> <!--Specify character encoding -->
		<style>
			<!--External CSS to avoid too much code on page -->
			<!--<link rel="stylesheet" href="Negotiations.css" /> -->
			<!--<link href="negotiations.css" media="all" rel="Stylesheet" type="text/css" /> -->
			
			<!--External CSS seems to not be working so will use inline CSS for now... -->
			* {
				margin: 0;
				padding: 0;
			}
			body {
				margin: 20px auto;
				font-family: "Lato";
				font-weight: 300;
			}
			form {
				padding: 15px 25px;
				display: flex;
				gap: 10px;
				justify-content: center;
			}	
			form label {
				font-size: 1.5rem;
				font-weight: bold;
			}
			input {
				font-family: "Lato";
			}
			a {
				color: #0000ff;
				text-decoration: none;
			}
			a:hover {
				text-decoration: underline;
			}
			#wrapper,
			#loginform {
				margin: 0 auto;
				padding-bottom: 25px;
				background: #eee;
				width: 600px;
				max-width: 100%;
				border: 2px solid #212121;
				border-radius: 4px;
			}
			#loginform {
				padding-top: 18px;
				text-align: center;
			}
			#loginform p {
				padding: 15px 25px;
				font-size: 1.4rem;
				font-weight: bold;
			}	
			#chatbox {
				text-align: left;
				margin: 0 auto;
				margin-bottom: 25px;
				padding: 10px;
				background: #fff;
				height: 300px;
				width: 530px;
				border: 1px solid #a7a7a7;
				overflow: auto;
				border-radius: 4px;
				border-bottom: 4px solid #a7a7a7;
			}
			#usermsg {
				flex: 1;
				border-radius: 4px;
				border: 1px solid #ff9800;
			}
			#name {
				border-radius: 4px;
				border: 1px solid #ff9800;
				padding: 2px 8px;
			}
			#submitmsg,
			#enter {
				background: #ff9800;
				border: 2px solid #e65100;
				color: white;
				padding: 4px 10px;
				font-weight: bold;
				border-radius: 4px;
			}
			.error {
				color: #ff0000;
			}
			#menu {
				padding: 15px 25px;
				display: flex;
			}
			#menu p.welcome {
				flex: 1;
			}
			a#exit {
				color: white;
				background: #c62828;
				padding: 4px 8px;
				border-radius: 4px;
				font-weight: bold;
			}
			.msgln {
				margin: 0 0 5px 0;
			}
			.msgln span.left-info {
				color: orangered;
			}
			.msgln span.chat-time {
				color: #666;
				font-size: 60%;
				vertical-align: super;
			}

		</style>
		<?php
			// Include the navigation bar
			include("NavBar.php"); 
			
			// Check if Session ID is set. If Not, then redirect to index.php
			if(!isset($_SESSION['ID'])){  
				echo '<script> location.replace("index.php")</script> ';
			}
			
			//echo json_encode($_SESSION);
			
			// Initialise Variables
			$userObj = "";  // Used to hold a copy of the user object
			$username = "";
			
			// Populate Variables with data
			$userObj = $_SESSION['Object']; // Copying an instance of the user object
			$username = $userObj -> getDisplayName();
		?>
	</head>
	<body>
		<div id="wrapper">
			<!--Top Menu -->
            <div id="menu">
                <p class="welcome">Welcome, <b><?php echo $username ?></b></p>
                <p class="logout"><a id="exit" href="#">Exit Chat</a></p>
            </div>
 
			<!--Chatbox -->
            <div id="chatbox"></div>
 
			<!--Message Input -->
            <form name="message" action="">
                <input name="usermsg" type="text" id="usermsg" />
                <input name="submitmsg" type="submit" id="submitmsg" value="Send" />
            </form>
        </div>
		
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript">
            // jQuery Document
          //  $(document).ready(function () {});
        </script>
	</body>

</html>
<!--Links used: -->

<!--Main Website used: -->
<!--https://code.tutsplus.com/tutorials/how-to-create-a-simple-web-based-chat-application--net-5931 -->

<!--Flexbox Websites -->
<!--https://css-tricks.com/snippets/css/a-guide-to-flexbox/ -->
<!--https://www.w3schools.com/css/css3_flexbox.asp -->

<!--Other Websites -->
<!--https://www.w3schools.com/html/html_css.asp -->
<!--https://www.w3schools.com/tags/att_meta_charset.asp -->
<!--https://www.w3schools.com/css/css_howto.asp -->
<!--https://www.w3schools.com/howto/howto_js_popup_chat.asp -->







