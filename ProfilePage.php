<html>
	<head>
		<style>
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
		Hello World!
	</body>
</html>