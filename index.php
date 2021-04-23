<?php require_once("NavBar.php");
?> 
<style>
.Carousel{
	width:90%;
	margin-left:auto;
	margin-right:auto;
}
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
        <img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Slides/img%20(68).jpg"
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
        <img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Slides/img%20(6).jpg"
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
        <img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Slides/img%20(9).jpg"
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
$BaseUserOBJ->ViewAllProduct("DateOfListing",$_POST['Order']);
}
if(isset($_POST['SortPrice'])){
$BaseUserOBJ = new BaseUser("index page");	
$BaseUserOBJ->ViewAllProduct("ProductInitialPrice",$_POST['Order']);
}
if(isset($_POST['SortCat'])){
$BaseUserOBJ = new BaseUser("index page");	
$BaseUserOBJ->ViewAllProduct("ProductCategory",$_POST['Order']);
}
if(!isset($_POST['SortCat'])&&!isset($_POST['SortPrice'])&&!isset($_POST['SortDate'])){
$BaseUserOBJ = new BaseUser("index page");	
$BaseUserOBJ->ViewAllProduct("DateOfListing","ASC");	
}
?>
