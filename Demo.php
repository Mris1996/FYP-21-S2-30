<?php require_once("NavBar.php");
	$servername= "localhost";
		$username = "root";
		$password = "";
		$dbname = "sticdb";
		$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "SELECT * FROM product";
		$result = $conn ->query($sql) or die($conn ->error); 

		while($row = $result->fetch_assoc())
		{
 $_SESSION['Object']->UpdateProduct($row['ProductID'],$row['ProductName'],$row['ProductCategory'],$row['ProductDescription'],$row['ProductInitialPrice'],$row['ProductCaption'],$row['Image']);

		}

?>

