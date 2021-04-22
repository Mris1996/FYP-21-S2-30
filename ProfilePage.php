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
			
			// Check if Session ID is set. If Not, then redirect to index.php
			if(!isset($_SESSION['ID'])){  
				echo '<script> location.replace("index.php")</script> ';
			}
			
			// Initialise Variables
			$userObj = "";  // Used to hold a copy of the user object
			$uid            = "";
			$username       = "";
			$pubKey         = "";			
			$email          = "";
			$fname          = "";
			$lname          = "";
			$dob            = "";
			$contactNo      = "";
			$address        = "";
			$accountType    = "";
			$accountBalance = "";
			
			// Populate Variables with data
			// Accessing the user Object stored in Session variable
			$userObj = $_SESSION['Object']; // Copying an instance of the user object
			$uid            = $userObj -> getUID();
			$username       = $userObj -> getDisplayName();
			$pubKey         = $userObj -> getPubKey();
			$email          = $userObj -> getEmail();
			$fname          = $userObj -> getFirstName();
			$lname          = $userObj -> getLastName();
			$dob            = $userObj -> getDOB();
			$contactNo      = $userObj -> getContactNumber();
			$address        = $userObj -> getAddress();
			$accountType    = $userObj -> getAccountType();
			$accountBalance = $userObj -> getAccountBalance();
		?>
	</head>
	<body>
		<div class="centerBox">
			<!--User ID Label -->
			<label>User ID:</label>
			<!--User ID Box -->
			<input type="text" name="userID" value= "<?php echo $uid ?>" readonly><br><br>
		
			<!--Username Label-->
			<label>Username:</label>
			<!--Username Box-->
			<input type="text" name="username" value= "<?php echo $username ?>" readonly><br><br>
			
			<!--Public Key Label -->
			<label>Public Key:</label>
			<!--Public Key Box -->
			<input type="text" name="pubKey" value= "<?php echo $pubKey ?>" readonly><br><br>
			<!--Public Key "COPY"  button? -->
			
			<!--Email Label-->
			<label>Email:</label>
			<!--Email Box-->
			<input type="email" name="email" value="<?php echo $email ?>" readonly><br><br>
			
			<!--First Name Label -->
			<label>First Name:</label>
			<!--First Name Box -->
			<input type="text" name="firstName" value= "<?php echo $fname ?>" readonly><br><br>
			
			<!--Last Name Label -->
			<label>Last Name:</label>
			<!--Last Name Box -->
			<input type="text" name="lastName" value= "<?php echo $lname ?>" readonly><br><br>
			
			<!--DOB Label -->
			<label>Date Of Birth:</label>
			<!--DOB Box -->
			<input type="text" name="DOB" value = <?php echo $dob ?> readonly><br><br>
			<!--Cannot use "type=date" here as it does not display properly -->
			
			<!--Contact Number Label-->
			<label>Contact Number:</label>
			<!--Contact Number Box-->
			<input type="contact" name="contact" value="<?php echo $contactNo ?>" readonly><br><br>

			<!--Address Label -->
			<label>Address:</label>
			<!--Address Box -->
			<textarea rows="4" cols="50" name="address" readonly><?php echo $address ?></textarea>

			<!--Account Type Label -->
			<label>Account Type:</label>
			<!--Account Type Box -->
			<input type="text" name="accountType" value= "<?php echo $accountType ?>" readonly><br><br>
			
			<!--Account Balance Label -->
			<label>Account Balance:</label>
			<!--Account Balance Box -->
			<input type="number" name="accountBalance" value= "<?php echo $accountBalance ?>" readonly><br><br>

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
<!--https://stackoverflow.com/questions/12957384/how-to-use-an-instantiated-object-across-different-php-files -->
<!--https://www.w3schools.com/php/php_sessions.asp -->
<!--https://www.edureka.co/blog/upcasting-and-downcasting-in-java/ -->
<!--https://www.c-sharpcorner.com/UploadFile/d9da8a/deference-between-deep-copy-and-shallow-copy-in-php/ -->
<!--https://www.w3schools.com/tags/att_input_type_date.asp -->
<!--https://www.w3schools.com/tags/tag_textarea.asp -->
<!--https://www.w3schools.com/tags/att_input_type_number.asp -->


