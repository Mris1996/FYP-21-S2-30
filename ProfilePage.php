<?php require_once("NavBar.php");
$ID = $_GET['ID'];
if(!isset($ID)){
echo '<script> location.replace("index.php")</script> ';	
}

$BaseUserObj = new BaseUser("Profile");
if(!$BaseUserObj->setUID($ID)){
echo '<script> location.replace("index.php")</script> ';	
}
?> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>


.card 
{
	box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
	width: 500px;
	margin-left: auto;
	float:left;
	text-align: center;
	font-family: arial;
}

a 
{
	text-decoration: none;
	font-size: 22px;
	color: black;
}
.fa {
  font-size: 25px;
}

.container {
	position: initial;
	width: 20%;
	height:500px;
	float:left;
	margin-left:200px;
 
  
}
.image {
  opacity: 1;
  display: block;
  width: 100%;
  height: auto;
  transition: .5s ease;
  backface-visibility: hidden;
}

.middle {
  transition: .5s ease;
  opacity: 0;
  position: relative;
  
  left: 50%;
  transform: translate(-30%,-100%);
  -ms-transform: translate(-30%, -30%);
  text-align: center;
}

.container:hover .image {
  opacity: 0.3;
}

.container:hover .middle {
  opacity: 1;
}

.text {

  background-color: black;
  color: white;
  font-size: 16px;
  padding: 20px 0px;
  width:200px;
  margin:auto;
}
</style>
<?php 

echo'<div class="card" style="margin-top:200px;">
		<h1>'.$BaseUserObj->getDisplayName().'</h1>
		<div class="w3-panel w3-black">';
		for($i=0;$i<intval($BaseUserObj->Rating['Rating']);$i++){
			echo'<span class="fa fa-star checked"></span>';

		}
		echo'
		<h2 style="font-weight:bold">Rating:'.round(intval($BaseUserObj->Rating['Rating']),3).'('.$BaseUserObj->Rating['NumOfReviewers'].')</h2>
		</div> 
		<p style="font-weight:bold"> Name:'.$BaseUserObj->getFirstName().' '.$BaseUserObj->getLastName().'</p>
		<p style="font-weight:bold">Email:'.$BaseUserObj->getEmail().'</p>
		</div>';
			
echo'
<div class="sorter">
<form method="post" style="margin-top:20px">
<Label>Sort By:</Label></br>
<input type="radio" id="ASC" name="Order" checked="checked" value="ASC"><label for="ASC">Ascending</label><br>
<input type="radio" id="DESC" name="Order" value="DESC"><label for="DESC">Descending</label><br>
<input type="submit" name="SortCat" value="Category">
<input type="submit" name="SortPrice" value="Price">
<input type="submit" name="SortDate" value="Date">
</form>
</div>';




if(isset($_POST['SortDate'])){
$BaseUserObj->ViewAllUserProduct("DateOfListing",$_POST['Order'],$ID);
}
if(isset($_POST['SortPrice'])){
$BaseUserObj->ViewAllUserProduct("ProductInitialPrice",$_POST['Order'],$ID);
}
if(isset($_POST['SortCat'])){	
$BaseUserObj->ViewAllUserProduct("ProductCategory",$_POST['Order'],$ID);
}
if(!isset($_POST['SortCat'])&&!isset($_POST['SortPrice'])&&!isset($_POST['SortDate'])){
$BaseUserObj->ViewAllUserProduct("DateOfListing","ASC",$ID);	
}

?>
<div style="float:left;width:100%">
<hr>
<h1>Reviews</h1>
<?php $BaseUserObj->viewReview($ID,"User");?>
</div>
<form method="post" style="text-align:center;">
<input type="text" name="reviewtext" style="width:1000px;height:100px;" placeholder="Review User">
<input type="hidden" name="reviewtextsubmit">
</form>
</div>

</div>
<?php

if(isset($_POST['reviewtextsubmit'])){
	
	$_SESSION['Object']->addNewUserReview($_POST['reviewtext'],$BaseUserObj->getUID());
	echo'<script>history.pushState({}, "", "")</script>';
	echo '<script> location.reload()</script> ';
	exit();	
}
?>