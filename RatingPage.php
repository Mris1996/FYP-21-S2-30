<?php require_once("NavBar.php");?>
<style>
#rating{
display:none;
position:fixed;
padding:0;
margin:auto;
top:0;
left:0;
width: 100%;
height: 100%;
background:rgba(255,255,255,0.5);
}

#rating	form {
width: 100px;
}

#rating button {
border: 0;
background: transparent;
font-size: 1.5em;
margin: 0;
padding: 0;
float: right;
}

#rating  button:hover,
#rating button:hover + button,
#rating button:hover + button + button,
#rating button:hover + button + button + button,
#rating button:hover + button + button + button + button {
color: #faa;
}
</style>
<?php
if($_SESSION['RatingToken']!=0){
	echo '<script> location.replace("index.php")</script> ';
}

echo'<div id="rating"><form action="" method="POST" style="margin:auto;margin-top:20%;">

<label>Rate User</label></br>
  <input type="hidden" name="rating[post_id]" value="3">
  <button type="submit" name="rating[rating]" value="5">&#9733;</button>
  <button type="submit" name="rating[rating]" value="4">&#9733;</button>
  <button type="submit" name="rating[rating]" value="3">&#9733;</button>
  <button type="submit" name="rating[rating]" value="2">&#9733;</button>
  <button type="submit" name="rating[rating]" value="1">&#9733;</button>
 
</form></div>';

if(isset($_POST['rating'])){
	
	$_SESSION['Object']->RateUser($_POST['rating']['rating'],$_SESSION['OtherUser']);
	unset($_SESSION['OtherUser']);
	echo '<script>location.replace("MyContractsPage.php")</script> ';
}

require_once("Footer.php");
?>