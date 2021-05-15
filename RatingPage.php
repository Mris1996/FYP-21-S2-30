<?php require_once("NavBar.php");?>
<style>

#rating	form {
width: 300px;
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

if($_SESSION['RatingToken']==0){
	echo '<script> location.replace("index.php")</script> ';
}
echo'<h2>Rate User:'.$_SESSION['OtherUser'].'</label></h2>';
echo'<div id="rating"><form action="" method="POST" style="margin:auto;">
	Rating:
		<input type="hidden" name="rating[post_id]" value="3">
		<button type="submit" id ="rate5" name="rating[rating]" value="5">&#9733;</button>
		<button type="submit" id ="rate4" name="rating[rating]" value="4">&#9733;</button>
		<button type="submit" id ="rate3" name="rating[rating]" value="3">&#9733;</button>
		<button type="submit" id ="rate2" name="rating[rating]" value="2">&#9733;</button>
		<button type="submit" id ="rate1" name="rating[rating]" value="1">&#9733;</button></br></br>
	Review:
		<input type="text" name="reviewtext" style="width:1000px;height:100px;" placeholder="Review User"></br></br>
		<input type="submit" name="submit" value="Submit review">
</form></div>';
if(isset($_POST['rating'])){
	if(isset($_POST['rating']['rating'])){
	for($x=1;$x<$_POST['rating']['rating']+1;$x++){

		echo '<style>#rate'.$x.'{color: #faa;}</style>';
	}
	$_SESSION['Rating'] =$_POST['rating']['rating'];
}
	
	
}


if(isset($_POST['submit'])){
	$_SESSION['Object']->RateUser($_SESSION['Rating'],$_SESSION['OtherUser']);
	
	$_SESSION['Object']->addNewUserReview($_POST['reviewtext'],$_SESSION['OtherUser']);
	unset($_SESSION['OtherUser']);
	unset($_SESSION['Rating']);
	$_SESSION['RatingToken']-1;
	echo '<script>location.replace("MyContractsPage.php")</script> ';
	
}
require_once("Footer.php");
?>