<?php require_once("NavBar.php");?> 
<style>
.Carousel{
	width:80%;
	margin-left:auto;
	margin-right:auto;
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
.Rec_Prod_GUI{
	width: 100%;
	display:block;
	height:500px;
	float:left;
	margin-left:100px;
	margin-bottom:100px;

}	
</style>


<div class="Carousel">
<div id="carousel-example-2" class="carousel slide carousel-fade" data-ride="carousel">
  <!--Indicators-->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-2" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-2" data-slide-to="1"></li>
    <li data-target="#carousel-example-2" data-slide-to="2"></li>
  </ol>
  <!--/.Indicators-->
  <!--Slides-->
  <div class="carousel-inner" role="listbox">
    <div class="carousel-item active">
      <div class="view">
        <img class="d-block w-100" src="ads/Sample.png"
          alt="First slide">
        <div class="mask rgba-black-light"></div>
      </div>
      <div class="carousel-caption">
        <h3 class="h3-responsive">Light mask</h3>
        <p>First text</p>
      </div>
    </div>
    <div class="carousel-item">
      <!--Mask color-->
      <div class="view">
        <img class="d-block w-100" src="ads/Sample2.png"
          alt="Second slide">
        <div class="mask rgba-black-strong"></div>
      </div>
      <div class="carousel-caption">
        <h3 class="h3-responsive">Strong mask</h3>
        <p>Secondary text</p>
      </div>
    </div>
    <div class="carousel-item">
      <!--Mask color-->
      <div class="view">
        <img class="d-block w-100" src="ads/Sample3.png"
          alt="Third slide">
        <div class="mask rgba-black-slight"></div>
      </div>
      <div class="carousel-caption">
        <h3 class="h3-responsive">Slight mask</h3>
        <p>Third text</p>
      </div>
    </div>
  </div>
  <!--/.Slides-->
  <!--Controls-->
  <a class="carousel-control-prev" href="#carousel-example-2" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carousel-example-2" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
  <!--/.Controls-->
</div>
<!--/.Carousel Wrapper-->

  </div>
</div>
<?php
if(isset($_SESSION['ID'])){
	echo"<div class='Rec_Prod_GUI'><hr>
	<center><h1>Reccomended for you:</h1></center>
	";
	$ArrayOfRecProducts = $_SESSION['Object']->UserProductBehaviourAnalysis();
	foreach($ArrayOfRecProducts as $val){
		$ProductObj = new Products();
		$ProductObj->InitialiseProduct($val);
		echo'
			
			<div class="container">
			<img src="'.$ProductObj->Image.'" class="image" style="width:500px;height:400px">
			<div class="middle">
			<div class="text">Seller:<a href="ProfilePage.php?ID='.$ProductObj->SellerUserID.'">'.$ProductObj->SellerUserID.'</a></div>
			<div class="text">Product Name:'.$ProductObj->ProductName.'</div>
			<div class="text">Category:'.$ProductObj->ProductCategory.'</div>
			<div class="text">Date Listed:<i>'.$ProductObj->DateOfListing.'</i></div>
			<div class="text">Initial Price:'.$_SESSION['Object']->getCurrency().number_format($ProductObj->ProductInitialPrice, 2, '.', '').'</div>
			<form action="ProductPage.php?ID='.$ProductObj->ProductID.'" method="post"></br>
			<input type="submit" value="Product Page"/>
			</form>
			</div>
			</div>';
		
		
	}
	echo'</div>';
}

?>
<hr>
<hr style="margin-top:500px">
<div class="sorter">
<form method="post" style="margin-top:20px">
<Label>Sort By:</Label></br>
<input type="radio" id="ASC" name="Order" checked = "true" value="ASC"><label for="ASC">Ascending</label><br>
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
if (!isset ($_GET['Ord']) ) {  
	$Order = "DESC";  
} else {  
	$Order =$_GET['Ord'];  
}
if (!isset ($_GET['Sb']) ) {  
	$Sortby = "DateOfListing";	
} else {  
	$Sortby = $_GET['Sb'];
}
if (!isset ($_GET['Cat']) ) {  
	$Category = "All";	
} else {  
	$Category = "All";	
}
$BaseUserOBJ = new BaseUser("index page");	

if(isset($_POST['SortDate'])){

$BaseUserOBJ->ViewAllProduct("DateOfListing",$_POST['Order'],"All",1,"index.php");
}
if(isset($_POST['SortPrice'])){
	
$BaseUserOBJ->ViewAllProduct("ProductInitialPrice",$_POST['Order'],"All",1,"index.php");
}
if(isset($_POST['SortCat'])){
	
$BaseUserOBJ->ViewAllProduct("ProductCategory",$_POST['Order'],"All",1,"index.php");
}


if(!isset($_POST['SortCat'])&&!isset($_POST['SortPrice'])&&!isset($_POST['SortDate'])){
$BaseUserOBJ->ViewAllProduct($Sortby,$Order,$Category,$page,"index.php");	
}

   
?>
<?php require_once("Footer.php");?> 