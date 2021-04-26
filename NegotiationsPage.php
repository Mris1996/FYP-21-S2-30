<!DOCTYPE html>  <!--Specify type of document -->
<html lang="en"> <!--Set Language of the page -->
	<head>
		<meta charset="utf-8"> <!--Specify character encoding -->

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
			$uid = "";
			
			// Debug Code
			//echo json_encode($_SESSION);
			
			// Populate Variables with data
			$userObj = $_SESSION['Object']; // Copying an instance of the user object
			$username = stripslashes(htmlspecialchars($userObj -> getDisplayName()));
			$uid = $userObj -> getUID();
			// The above prevents XSS from happening by removing special characters
			
			// Will use code from SignUpPage and users.php to send and retrieve 
			// data from the database
			if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitmsg'])){
				echo $_POST["usermsg"];
				//$userObj -> insertChat($_POST["usermsg"]);
				
				// Calls the insertChat method in Users.php to insert into
				// sql table the uid and message
				
				if($userObj -> insertChat($_POST["usermsg"])=="Message Inserted") 
				{
					echo 'message inserted!';
				}
				//echo $_POST["usermsg"];
			}
		?>
	</head>
	<body>
		<div id="wrapper">
			<!--Top Menu -->
            <div id="menu">
                <p class="welcomeLabel">Welcome, <b><?php echo $username ?></b></p>
                <p class="logout"><a id="exit" href="#">Exit Chat</a></p>
            </div>
 
			<!--Chatbox -->
            <div id="chatbox">
			<?php 
				// Request for chats in SQL database.
			
			?>
			
			</div>
 
			<!--Message Input -->
			<!-- <form class ="SignUpForm" method="post"> -->
            <form name="message" method="post">
                <input name="usermsg" type="text" id="usermsg" />
                <input name="submitmsg" type="submit" id="submitmsg" value="Send" />
            </form>
        </div>
		
		<!--Will remove this part once the functionality is working -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript">
            // jQuery 
            $(document).ready(function () {});
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
<!--https://stackoverflow.com/questions/15447041/what-is-the-difference-between-jquery-and-node-js -->







