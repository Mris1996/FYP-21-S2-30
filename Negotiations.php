<!DOCTYPE html>  <!--Specify type of document -->
<html lang="en"> <!--Set Language of the page -->
	<head>
		<meta charset="utf-8"> <!--Specify character encoding -->
		<style>
			<!--External CSS to avoid too much code on page -->
			<link rel="stylesheet" href="style.css" />
		</style>
		<?php
			// Include the navigation bar
			include("NavBar.php"); 
			
			// Check if Session ID is set. If Not, then redirect to index.php
			if(!isset($_SESSION['ID'])){  
				echo '<script> location.replace("index.php")</script> ';
			}
			
			// Initialise Variables
			
		?>
	</head>
	<body>
		<div id="wrapper">
			<!--Top Menu -->
            <div id="menu">
                <p class="welcome">Welcome, <b></b></p>
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
            $(document).ready(function () {});
        </script>
	</body>

</html>
<!--Links used: -->

<!--Main Website used: -->
<!--https://code.tutsplus.com/tutorials/how-to-create-a-simple-web-based-chat-application--net-5931 -->

<!--Other Websites -->
<!--https://www.w3schools.com/html/html_css.asp -->
<!--https://www.w3schools.com/tags/att_meta_charset.asp -->

<!--Flexbox Websites -->
<!--https://css-tricks.com/snippets/css/a-guide-to-flexbox/ -->
<!--https://www.w3schools.com/css/css3_flexbox.asp -->





