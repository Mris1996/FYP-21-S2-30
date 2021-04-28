<?php require_once("NavBar.php");
if(isset($_POST['searchfunction'])){
    if(empty($_POST['SearchBar'])){

        echo "<h3> Enter a search query </h3>";
    }else{

       echo "<h1>Search results for :".$_POST['SearchBar']."</h1>";
    


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
<hr>
<?php
if (!isset ($_GET['page']) ) {  
	$page = 1;  
} else {  
	$page = $_GET['page'];  
}
$BaseUserOBJ = new BaseUser("Search page");	
if(isset($_POST['SortDate'])){

$BaseUserOBJ->ViewSearchProduct("DateOfListing",$_POST['Order'],$_POST['SearchBar'],$page);
}
if(isset($_POST['SortPrice'])){

$BaseUserOBJ->ViewSearchProduct("ProductInitialPrice",$_POST['Order'],$_POST['SearchBar'],$page);
}
if(isset($_POST['SortCat'])){

$BaseUserOBJ->ViewSearchProduct("ProductCategory",$_POST['Order'],$_POST['SearchBar'],$page);
}
if(!isset($_POST['SortCat'])&&!isset($_POST['SortPrice'])&&!isset($_POST['SortDate'])){

$BaseUserOBJ->ViewSearchProduct("DateOfListing","ASC",$_POST['SearchBar'],$page);	
}
}
}
?>