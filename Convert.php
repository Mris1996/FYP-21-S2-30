<?php require_once("NavBar.php");

if(!isset($_SESSION['ID'])){
	echo '<script> location.replace("index.php")</script> ';
}
?> 

<style>

</style>


<div class="Convert_GUI">
	
<form method="post">
  <label for="Convert_publickey">Public Key:</label><br>
  <input type="text" id="Convert_publickey" name="Convert_publickey"><br>
  
  <label for="Convert_privatekey">Private Key:</label><br>
  <input type="text" id="Convert_privatekey" name="Convert_privatekey"><br><br>
  
   <label for="Convert_amount">Amount in Ethereum:</label><br>
  <input type="Number" id="Convert_amount" name="Convert_amount"><br><br>
  <input type="submit" name="submit" value="Submit">
</form> 
<?php

if(isset($_POST['submit'])){

$_SESSION['Object'] -> ConvertToSTICOIN($_POST['Convert_amount'],$_POST['Convert_publickey'],$_POST['Convert_privatekey']);
echo'<script>history.pushState({}, "", "")</script>';

}
	

	
		



?>

</div>