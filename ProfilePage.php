<html>
	<head>
		<style>
			.profileButton {
				background-color: #008CBA; /* Blue */
				border: none;
				color: white;
				padding: 15px 32px;
				text-align: center;
				text-decoration: none;
				display: inline-block;
				font-size: 16px;
				margin: 4px 2px;
				cursor: pointer;
				
				/* Adjust position of button on screen */
				position: relative;
				top: 50%;
				left: 50%;
				transform: translate(-50%, -50%);
			}
			.centerBox {
				margin: auto;
				width: 40%;
				padding: 10px;
			}

			label, input, button{	
				display: inline-block; /* In order to define widths */
			}

			label {
				width: 30%;
				text-align: right;    /* Positions the label text beside the input */
			}

			label+input+button{
				width: 30%;
				/* Large margin-right to force the next element to the new-line
				and margin-left to create a gutter between the label and input */
					
				/* Margin: 0% for top, 30% for right, 0% for bottom, 4% for left */
				margin: 0 30% 0 4%;
			}
			
			
		</style>
		<?php 
			// Include the navigation bar
			include("NavBar.php"); 
			
			//Initialise variables here
			
			// Check if Session ID is set. If Not, then redirect to index.php
			if(isset($_SESSION['ID'])){ // Like NOT WORKING... 
				echo '<script> location.replace("index.php")</script> ';
			}
		?>
	</head>
	<body>
		<div class="centerBox">
			<!--Username Label-->
			<label>Username:</label>
			<!--Username Box-->
			<input type="text" name="username" value="Username" readonly><br><br>
			
			<!--Feels Awkward to be displaying user password on a profile page...(<_<) -->
			<!--Password Label-->
			<label>Password:</label>
			<!--Password Box-->
			<input type="text" name="password" value="Password" readonly><br><br>
			
			<!--Email Label-->
			<label>Email:</label>
			<!--Email Box-->
			<input type="email" name="email" value="example123@gmail.com" readonly><br><br>
			
			<!--Phone Number Label-->
			<label>Contact Number:</label>
			<!--Phone Number Box-->
			 <input type="contact" name="contact" placeholder="12345678" readonly><br><br>

			<!--Edit Profile Button-->
			<button class="profileButton">Edit Profile</button>
		</div>
	</body>
</html>

<!--Links used:-->
<!--https://www.w3schools.com/howto/howto_css_social_login.asp -->
<!--https://www.w3schools.com/howto/howto_css_login_form_navbar.asp -->
<!--https://www.w3schools.com/howto/howto_css_login_form.asp -->
<!--https://www.w3schools.com/tags/att_readonly.asp -->
<!--https://www.w3schools.com/tags/tag_br.asp -->
<!--https://www.w3schools.com/tags/att_input_type_email.asp -->
<!--https://www.w3schools.com/tags/att_input_type_tel.asp -->
<!--https://css-tricks.com/quick-css-trick-how-to-center-an-object-exactly-in-the-center/ -->
<!--https://www.w3schools.com/css/css3_buttons.asp -->

