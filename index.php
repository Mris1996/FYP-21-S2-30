<?php
	require_once("NavBar.php");
	require_once("Users.php");
	require_once("Products.php");
?>

<!doctype html>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<style>
			.Carousel {
				width:900px;
				height:600px;
				margin:auto;
				margin-bottom:100px;
			}
			
			.card {
				font-family: 'Roboto';font-size: 22px;
				border: 2px solid purple;
				border-radius: 25px;
				font-size:5px;
				overflow:hidden;
				background-color:white;
				margin: auto;
				text-align: center;
				float:left;
				display: inline-block;
				margin-left:50px;
				margin-top:50px;
				position:relative;
				height:320px;
				width:300px;
				margin-bottom:50px;
			}
			
			.card:hover {
				box-shadow: 0 4px 10px 0 rgba(0, 0, 0, 1);
			}
			
			.card image{
				position: absolute;
				top: 0;
				bottom: 0;	
			}
			
			.card:hover {
				cursor:pointer;
				transform: scale(1.5); 
				z-index:1;
			}
			
			.text {
				background-color: white;
				color:purple;
				font-size: 16px;
				width:80%;
				margin:auto;
			}
			
			.Rec_Prod_GUI {
				margin-top:2%;
				width: 90%;
				display:inline;
				float:left;
				margin-left:5%;
				border-radius:20px;
				background-color:#23084D ;
				display: flex;
				justify-content: center;
				align-items: center;
				color:white;
				background-repeat: no-repeat; /* Do not repeat the image */
				background-size: cover; /* Resize the background image to cover the entire container */
				background-image: url('systemimages/ReccomendedWP.jpg');
				background-attachment: fixed;
			}
			
			.Rec_Prod_GUI .card {
				margin-right:20px;
			}
			
			.sorter {
				font-family: 'roboto';font-size: 22px;
				background-color:white ;
				font-size:20px;
				display:block;
				width:100%;
				opacity:0.9;
				color:white;
				float:right;
			}
			
			.sorter input {
				border: 2px solid white;
				background-color:purple;
				color:white;
				border-radius:5px;
			}
			
			.sorter input:hover {
				transform: scale(1.1); 
				outline:60%;
				filter: drop-shadow(0 0 6px white);
			}
			
			#container {
				width:80%;
				left:1%;
				margin:auto;
				margin-top:5%;
			}
			
			#sortcontent {
				opacity:1;
				margin-left:80px;
				width:400px;
				height:180px;
				color:purple;
				text-align:left;
				background-color:white;
			}
			
			.adsimage {
				maring:auto;
				transition: 0.3s;
				object-fit: contain;
				width:900px;
				height:600px;
				border:1px solid black;
				background-repeat: no-repeat; /* Do not repeat the image */
				background-size: cover; /* Resize the background image to cover the entire container */
				background-image: url('systemimages/adsbackground.jpg');
				background-attachment: fixed;
				opacity:0.9;
				filter: drop-shadow(0 0 5px black);
			}
			
			.adsimage :not(img) {

			}
			
			h1 {
				text-align: center;
				margin-top:30px;
			}
			
			.image {
				object-fit:cover;
				width:200px;
				height:200px;
				border-radius:20px;
				margin-top:20px
			}
			
			label.sort {
				margin-right:40px;
				font-size:30px;
			}
			
			label.products {
				text-align: center; 
				display: block;
				font-size:50px;
				margin-left: auto;
				margin-right: auto;
				
			}
			
		</style>
		
		<title>Index Page</title>
		
	</head>
	
	<body>
		<?php 
			displayAdvertisements();
			
			displayRecommendedProductsIfUserIsLoggedIn();
			
			displaySortingForm();
		?>
		
		<label class="products"><b>Products</b></label>
		<?php 
			displayAllProducts();
		?>
		
		<script>
			function clickproduct(ID) {
				location.replace("ProductPage.php?ID="+ID);
			}
		</script>
		
		<?php 
			require_once("Footer.php");
		?> 
	</body>
</html>

<?php
	function displayAdvertisements() {
		$ArrayOFAds = getArrayOfAds();
		if(sizeof($ArrayOFAds) != 0) {
			display($ArrayOFAds);
		}
	}

	function getArrayOfAds() {
		$BaseUserOBJ = new BaseUser("index page");
		return $BaseUserOBJ ->ListOfAds();
	}
	
	function display(&$ArrayOFAds) {
		?>
			<div class="Carousel">
				<div id="carousel-example-2" class="carousel slide carousel-fade" data-ride="carousel">
					<?php
						setupIndicators($ArrayOFAds);
						setupCarouselInner($ArrayOFAds);
						setupCarouselControls();
					?>
				</div>
				<!--/.Carousel Wrapper-->
			</div>
		<?php
	}
	
	function setupIndicators(&$ArrayOFAds) {
		?>
			<!--Indicators-->
			<ol class="carousel-indicators">
				<li data-target="#carousel-example-2" data-slide-to="0" class="active"></li>
				<?php 
					for($x = 1; $x<sizeof($ArrayOFAds); $x++) {	?>	
						<li data-target="#carousel-example-2" data-slide-to="1"></li>
						<?php
					} 
				?>
			</ol>
		<?php
	}
	
	function setupCarouselInner(&$ArrayOFAds) {
		?>
		<div class="carousel-inner" role="listbox">
			<div class="carousel-item active">
				<div class="view">
					<img class="adsimage"  src="<?php echo $ArrayOFAds[0][0]; ?>">
					<div class="mask rgba-black-light" style="background-color:black"></div>
				</div>
				
			</div>
		
			<?php 
				for($x = 1; $x<sizeof($ArrayOFAds); $x++) { ?>
					<div class="carousel-item">
						<div class="view">
							<img class="adsimage" src="<?php echo $ArrayOFAds[$x][0]; ?>">
							<div class="mask rgba-black-light"></div>
						</div>
					</div>
					<?php
				}
			?>
		</div>
		<?php
	}
	
	function setupCarouselControls() { 
		?>
		<a class="carousel-control-prev" href="#carousel-example-2" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		
		<a class="carousel-control-next" href="#carousel-example-2" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
		<!--/.Controls-->
		<?php
	}
	
	function displayRecommendedProductsIfUserIsLoggedIn() {
		if(userIsLoggedIn()) {
			displayRecommendedProducts();
		}
	}
	
	function userIsLoggedIn() {
		return isset($_SESSION['ID']);
	}
	
	function displayRecommendedProducts() {
		?>
		<div class="Rec_Prod_GUI">
		
			<h1>Specially picked for you!</h1>
			
			<?php
			$arrayOfRecommendedProductsId = getIdsOfRecommendedProducts();
			
			foreach($arrayOfRecommendedProductsId as $productId) {
				$productDetailsObject = getProductDetails($productId);
				displayProductDetails($productDetailsObject); 
			}
			?>	
		</div>
		<?php
	}
	
	function getIdsOfRecommendedProducts() {
		return $_SESSION['Object']->UserProductBehaviourAnalysis();
	}
	
	function getProductDetails($productId) {
		$ProductObj = new Products();
		$ProductObj->InitialiseProduct($productId);
		return $ProductObj;
	}
	
	function displayProductDetails(&$productDetailsObject) {
		?>	
		<div class="card"  onclick="clickproduct(this.id)" id = "<?php echo $productDetailsObject->ProductID; ?>">
			
			<img src=" <?php echo $productDetailsObject->Image; ?>" class="image">
			
			<div class="text" style="font-size:10px">
				<b><?php echo $productDetailsObject->ProductCategory; ?></b>
			</div>
			
			<div class="text" style="font-size:15px">
				<b> <?php echo $productDetailsObject->ProductName; ?></b>
			</div>
			
			<div class="text">
				Date Listed:<i> <?php echo $productDetailsObject->DateOfListing; ?></i>
			</div>
			
			<div class="text" style="font-size:20px;">
				<b><?php echo formatPrice($productDetailsObject->ProductInitialPrice); ?></b>
			</div>
			
		</div>
		<br>
		<?php
	}
	
	function formatPrice($ProductInitialPrice) {
		return $_SESSION['Object']->getCurrency().number_format($ProductInitialPrice, 2, '.', '');
	}
	
	function displaySortingForm() { 
		?>
		<div class="sorter">
			<div id="sortcontent">
				<form method="post">
				
					<label class="sort"><b>Sort</b></label>
					<br>
					
					<input type="radio" id="ASC" name="Order" checked = "true" value="ASC">
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="ASC">Ascending</label>
					<br>
					
					<input type="radio" id="DESC" name="Order" value="DESC">
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="DESC">Descending</label>
					<br>
					
					<input type="submit" id="SortCat" name="SortCat" value="Category">
					<input type="submit" id="SortPrice" name="SortPrice" value="Price">
					<input type="submit" id="SortDate" name="SortDate" value="Date">
				
				</form>
			</div>
		</div>
		<?php
	}
	
	function displayAllProducts() {
		
		$statusOfViewingProducts = array();
		
		updateCurrent($statusOfViewingProducts);
		checkIfUserSelectedSortingAndUpdate($statusOfViewingProducts); 
		
		executeQueryToFetchAndDisplayAccordingTo($statusOfViewingProducts);
	}
	
	function updateCurrent(&$statusOfViewingProducts) {
		$statusOfViewingProducts["sortBy"] = getSortBy();
		$statusOfViewingProducts["orderOfProducts"] = getOrderOfProducts();
		$statusOfViewingProducts["category"] = getCategory(); 
		$statusOfViewingProducts["currentPageNumber"] = getCurrentPageNumber();
		$statusOfViewingProducts["pageName"] = getPageName();
	}
	
	function getSortBy() {		
		return (!isset ($_GET['Sb'])) ? "DateOfListing" :  $_GET['Sb'];
	}
	
	function getOrderOfProducts() {		
		return (!isset ($_GET['Ord'])) ? "DESC" : $_GET['Ord'];
	}
	
	function getCategory() {
		return "All";
	}
	
	function getCurrentPageNumber() {
		return (!isset ($_GET['page'])) ? 1 : $_GET['page'];
	}
	
	function getPageName() {
		return "index.php";
	}
	
	function checkIfUserSelectedSortingAndUpdate(&$statusOfViewingProducts) {
		if(sortByDate()) {
			$statusOfViewingProducts["sortBy"] = "DateOfListing";
			$statusOfViewingProducts["orderOfProducts"] = $_POST['Order'];
			$statusOfViewingProducts["category"] = "All"; 
			$statusOfViewingProducts["currentPageNumber"] = 1;
			$statusOfViewingProducts["pageName"] = "index.php";
			
		} elseif (sortByPrice()) {
			$statusOfViewingProducts["sortBy"] = "ProductInitialPrice";
			$statusOfViewingProducts["orderOfProducts"] = $_POST['Order'];
			$statusOfViewingProducts["category"] = "All"; 
			$statusOfViewingProducts["currentPageNumber"] = 1;
			$statusOfViewingProducts["pageName"] = "index.php";
		
		} elseif (sortByCategory()) {			
			$statusOfViewingProducts["sortBy"] = "ProductCategory";
			$statusOfViewingProducts["orderOfProducts"] = $_POST['Order'];
			$statusOfViewingProducts["category"] = "All"; 
			$statusOfViewingProducts["currentPageNumber"] = 1;
			$statusOfViewingProducts["pageName"] = "index.php";
		}
	}
	
	function sortByDate() {
		return isset($_POST['SortDate']);
	}
	
	function sortByPrice() {
		return isset($_POST['SortPrice']);
	}
	
	function sortByCategory() {
		return isset($_POST['SortCat']);
	}
	
	function executeQueryToFetchAndDisplayAccordingTo(&$statusOfViewingProducts) {
		
		$sortBy   = $statusOfViewingProducts["sortBy"];
		$order    = $statusOfViewingProducts["orderOfProducts"];
		$category = $statusOfViewingProducts["category"];
		$page     = $statusOfViewingProducts["currentPageNumber"];
		$pagename = $statusOfViewingProducts["pageName"];
		
		$BaseUserOBJ = new BaseUser("index page");
		$BaseUserOBJ->ViewAllProduct($sortBy, $order, $category, $page, $pagename);
	}
?>

<!--Links Used:-->
<!--
Mixing PHP and HTML 
https://thisinterestsme.com/mixing-php-html/

<center> Tag is deprecated
https://www.w3schools.com/tags/tag_center.asp

Centering elements
https://www.w3.org/Style/Examples/007/center.en.tmpl

Associative Arrays (HashMap)
https://www.w3schools.com/php/php_arrays_associative.asp

Ternary Operators 
https://www.edureka.co/blog/php-ternary-operator/


-->