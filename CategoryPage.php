<?php require_once("NavBar.php");
$Category = $_GET['Category'];

if(!isset($Category)){
echo '<script> location.replace("index.php")</script> ';	
}
if (!file_exists('Categories.txt')) 
{
	fopen("Categories.txt", "w");
}
$count = 0;
$myfile = fopen("Categories.txt", "r") or die("Unable to open file!");
while(($line = fgets($myfile)) !== false) {
if(trim($Category)==trim($line)){
	$count++;
}
}
fclose($myfile);
if($count==0){
echo '<script> location.replace("index.php")</script> ';	
}
?> 

<style>
.container {
  position: relative;
  width: 20%;
  float:left;
  margin-top:20px;
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
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
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
<div class="sorter">
<form method="post" style="margin-top:20px">
<Label>Sort By:</Label></br>
<input type="radio" id="ASC" name="Order" checked="checked" value="ASC"><label for="ASC">Ascending</label><br>
<input type="radio" id="DESC" name="Order" value="DESC"><label for="DESC">Descending</label><br>
<input type="submit" name="SortCat" value="Category">
<input type="submit" name="SortPrice" value="Price">
<input type="submit" name="SortDate" value="Date">
</form>
</div>
<?php

if(isset($_POST['SortDate'])){
$BaseUserOBJ = new BaseUser("index page");	
$BaseUserOBJ->ViewAllProduct("DateOfListing",$_POST['Order'],$Category );
}
if(isset($_POST['SortPrice'])){
$BaseUserOBJ = new BaseUser("index page");	
$BaseUserOBJ->ViewAllProduct("ProductInitialPrice",$_POST['Order'],$Category );
}
if(isset($_POST['SortCat'])){
$BaseUserOBJ = new BaseUser("index page");	
$BaseUserOBJ->ViewAllProduct("ProductCategory",$_POST['Order'],$Category );
}
if(!isset($_POST['SortCat'])&&!isset($_POST['SortPrice'])&&!isset($_POST['SortDate'])){
$BaseUserOBJ = new BaseUser("index page");	
$BaseUserOBJ->ViewAllProduct("DateOfListing","ASC",$Category );	
}
?>