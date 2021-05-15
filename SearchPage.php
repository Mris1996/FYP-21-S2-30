<?php require_once("NavBar.php");
if(empty($_GET['query'])){
  

        echo "<h3> Enter a search query </h3>";
    }
else{
 $_SESSION['Searchquery'] = $_GET['query'];
echo "<h1>Search results for :". $_SESSION['Searchquery']."</h1>";


?> 
<style>

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
<hr>
<?php
if (!isset ($_GET['page']) ) {  
	$page = 1;  
} else {  
	$page = $_GET['page'];  
}
$BaseUserOBJ = new BaseUser("Search page");	
if(isset($_POST['SortDate'])){

$BaseUserOBJ->ViewSearchProduct("DateOfListing",$_POST['Order'], $_SESSION['Searchquery'],$page);
}
if(isset($_POST['SortPrice'])){

$BaseUserOBJ->ViewSearchProduct("ProductInitialPrice",$_POST['Order'], $_SESSION['Searchquery'],$page);
}
if(isset($_POST['SortCat'])){

$BaseUserOBJ->ViewSearchProduct("ProductCategory",$_POST['Order'], $_SESSION['Searchquery'],$page);
}
if(!isset($_POST['SortCat'])&&!isset($_POST['SortPrice'])&&!isset($_POST['SortDate'])){

$BaseUserOBJ->ViewSearchProduct("DateOfListing","ASC", $_SESSION['Searchquery'],$page);	
}
}

?>