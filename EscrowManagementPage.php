<?php require_once("NavBar.php");?>
<style>
table, th, td {
  border: 1px solid black;
}
.AddGUI{
  display:none;
}
span{
	
	color:red;
}
</style>

<div><center><h1>Escrow Management</h1><center><hr>
<table>
<tr>

<th>Escrow Account</th>
<th>Action</th>

</tr>
<?php 

if(!isset($_SESSION['ID'])){
	echo '<script> location.replace("index.php")</script> ';
}
if($_SESSION['Object']->getAccountType()!="Administrator"){
	echo '<script> location.replace("index.php")</script> ';
}

$ArrayOFEscrows = $_SESSION['Object']->ListOfEscrows();
for($x = 0;$x<sizeof($ArrayOFEscrows);$x++){
	echo'<tr><td>'.$ArrayOFEscrows[$x].'</td>
	<td><form method="post">
	<input type="submit" name="Remove" value="Remove">
	<input type="hidden" name="PubKey" value="'.$ArrayOFEscrows[$x].'">
	</form></td></tr>
	';
}
if(sizeof($ArrayOFEscrows)==0){
echo'<td colspan="2">Add Escrow Account</td>';	
}
if(isset($_POST['Remove'])){
		$_SESSION['Object']->RemoveEscrow($_POST['PubKey']);
		echo '<script> location.replace("EscrowManagementPage.php")</script> ';
		exit();
}
$PubKeyErr = $PrivateKeyErr = '';
$Submit = false;
if(isset($_POST['AddSubmit'])){
	if(empty($_POST['PublicKeyInput'])){
		$PubKeyErr  = "Please enter public key";
	}
	else{
		if(!$_SESSION['Object'] -> checkAccountInNetwork($_POST['PublicKeyInput'])){
			$PubKeyErr  = "Public key is invalid";
		}
		else{
			
			$Submit = false;		
		}
	
	}
	if(empty($_POST['PrivateKeyInput'])){
		$PrivateKeyErr  = "Please enter private key";
	}
	else{
		if(strlen($_POST["PrivateKeyInput"])<64){
			$PrivateKeyErr = "Private key is invalid";
		}
		else{
			$Submit = true;
		}
	
	}
	echo"<style>.AddGUI{display:block}</style>";
	echo"<style>.AddButton{display:none}</style>";
	
	if($Submit){
		
		$_SESSION['Object'] ->AddEscrow($_POST['PublicKeyInput'],$_POST["PrivateKeyInput"]);
		echo '<script> location.replace("EscrowManagementPage.php")</script> ';
		exit();
	}
}
else{
	echo"<style>.AddButton{display:block}</style>";
}
?>
</table>
</div>
<script>
$(document).ready(function(){
  $(".AddButton").click(function(){
    $(".AddGui").show();
	  $(".AddButton").hide();
  });
});
</script>
<center>
<br /><br />
<button class="AddButton">Add</button>
<div class="AddGUI">
<form method="post">
  <label>Public Key:</label>
  <input type="text"  name="PublicKeyInput"><br>
  <span class="error"><?php echo $PubKeyErr ?></span><br /><br />
  <label>Private Key:</label>
  <input type="text" name="PrivateKeyInput"><br><br>
  <span class="error"><?php echo $PrivateKeyErr?></span><br /><br />
  <input type="submit" name="AddSubmit" value="Add">

</form> 
</div>
</center>
<?php require_once("Footer.php");?>