<?php require_once("NavBar.php");?>
<style>

.Sellercontracts_GUI{
	display:none;
}
.Buyercontracts_GUI{
	display:none;
}
</style>
<script>
$(document).ready(function(){
  $(".All").click(function(){
    $(".Allcontracts_GUI").show();
	$(".Sellercontracts_GUI").hide();
	$(".Buyercontracts_GUI").hide();
  });
    $(".Seller").click(function(){
    $(".Allcontracts_GUI").hide();
	$(".Sellercontracts_GUI").show();
	$(".Buyercontracts_GUI").hide();
  });
    $(".Buyer").click(function(){
    $(".Allcontracts_GUI").hide();
	$(".Sellercontracts_GUI").hide();
	$(".Buyercontracts_GUI").show();
  });

});
</script>
<button class="All">All Contracts</button>
<button class="Seller">Contracts as seller</button>
<button class="Buyer">Contracts as buyer</button>

<?php

if(!isset($_SESSION['ID'])){
	echo '<script> location.replace("index.php")</script> ';
}

echo'<div class="Allcontracts_GUI">';
$ArrayOfContracts = $_SESSION['Object']->ListOfContracts("All");
echo'<h1>All my Contracts Table</h1>';
if(!empty($ArrayOfContracts)){ 

echo'<hr><table id="AllContracts" class="table table-borderless table-dark">';
echo'<tr>
<th>ContractID</th>
<th>Transaction Open Date</th>
<th>ProductID</th>
<th>Product Name</th>
<th>Seller</th>
<th>Buyer</th>
<th>Initial Offer</th>
<th>Offer</th>
<th>Status</th>
<th>Go to Contracts Page</th>

';
if (!isset ($_GET['page']) ) {  
	$page = 1;  
} else {  
	$page = $_GET['page'];  
}
$Data_per_page = 5;
$number_of_page = ceil(sizeof($ArrayOfContracts)/$Data_per_page) ;
if(round($number_of_page) == 0){
	
	$number_of_page = 1;
}
$page_num = $page;
$page_num_max = $page_num *$Data_per_page ; 
$page_num_min = $page_num_max - $Data_per_page;
for($x = $page_num_min;$x<$page_num_max;$x++){
	$ContractsObj = new Contracts();
	$ProductObj = new Products();
	if (array_key_exists($x,$ArrayOfContracts)){
	$ContractsObj->InitialiseContract($ArrayOfContracts[$x]);
	$ProductObj->InitialiseProduct($ContractsObj->ProductID);
	echo'<tr><td>'.$ContractsObj->ContractID.'</td>
		<td>'.$ContractsObj->TransactionOpenDate.'</td>
		<td>'.$ContractsObj->ProductID.'</td>
		<td>'.$ProductObj->ProductName.'</td>
		<td>'.$ContractsObj->SellerUserID.'</td>
		<td>'.$ContractsObj->BuyerUserID.'</td>
		<td>'.$ContractsObj->InitialOffer.'</td>
		<td>'.$ContractsObj->NewOffer.'</td>
		<td>'.$ContractsObj->Status.'</td>';
		if(in_array($_SESSION['ID'],$ContractsObj->RatingToken)){
		echo'
		<td><form  method="post" action="RatingPage.php?ID='.$ContractsObj->ContractID.'"><input type="submit" value="Review"></form></td>';
		}
		if($ContractsObj->Status=="Transaction Complete"){
		echo'
		<td><form  method="post" action="RecieptPage.php?ID='.$ContractsObj->ContractID.'"><input type="submit" value="View Reciept"></form></td>';
		}
		echo'
		<td><form  method="post" action="ContractPage.php?ID='.$ContractsObj->ContractID.'"><input type="submit" value="View Contract"></form></td>
		</tr>';
	}
}
echo'</table>';

echo'<div style="margin-top:10px;width:1000px;margin-left:auto;margin-right:auto;text-align:center">';			
echo'<b style="bottom: 20;">Page</b></BR>';
echo '<a href = "MyContractsPage.php?page=1">First </a>'; 
for($page = 1; $page<=$number_of_page; $page++) { 
	if($page==1){
		echo '<a href = "MyContractsPage.php?page=' . $page . '">' . $page . ' </a>';  
		
	}
	else{
	echo '<a href = "MyContractsPage.php?page=' . $page . '">' . $page . ' </a>';  
	}
} 

echo '<a href = "MyContractsPage.php?page=' . $number_of_page . '">Last </a>';  

echo'</div>';
}
else{
echo '<b>You do not have any contracts under this section</b>';  
	
}
echo'</div><div class="Sellercontracts_GUI">';
$ArrayOfContracts2 = $_SESSION['Object']->ListOfContracts("Seller");
echo'<h1>My Seller Contracts Table</h1>';
if(!empty($ArrayOfContracts2)){ 

echo'<hr><table id="AllContracts" class="table table-borderless table-dark">';
echo'<tr>
<th>ContractID</th>
<th>Transaction Open Date</th>
<th>ProductID</th>
<th>Product Name</th>
<th>Seller</th>
<th>Buyer</th>
<th>Initial Offer</th>
<th>Offer</th>
<th>Status</th>
<th>Go to Contracts Page</th>

';
if (!isset ($_GET['page2']) ) {  
	$page2 = 1;  
} else {  
	$page2 = $_GET['page2'];  
}
$Data_per_page = 5;
$number_of_page2 = ceil(sizeof($ArrayOfContracts2)/$Data_per_page) ;
if(round($number_of_page2) == 0){
	
	$number_of_page2 = 1;
}
$page_num = $page2;
$page_num_max = $page_num *$Data_per_page ; 
$page_num_min = $page_num_max - $Data_per_page;
for($x = $page_num_min;$x<$page_num_max;$x++){
	$ContractsObj = new Contracts();
	$ProductObj = new Products();
	if (array_key_exists($x,$ArrayOfContracts2)){
	$ContractsObj->InitialiseContract($ArrayOfContracts2[$x]);
	$ProductObj->InitialiseProduct($ContractsObj->ProductID);
	echo'<tr><td>'.$ContractsObj->ContractID.'</td>
		<td>'.$ContractsObj->TransactionOpenDate.'</td>
		<td>'.$ContractsObj->ProductID.'</td>
		<td>'.$ProductObj->ProductName.'</td>
		<td>'.$ContractsObj->SellerUserID.'</td>
		<td>'.$ContractsObj->BuyerUserID.'</td>
		<td>'.$ContractsObj->InitialOffer.'</td>
		<td>'.$ContractsObj->NewOffer.'</td>
		<td>'.$ContractsObj->Status.'</td>';
		if(in_array($_SESSION['ID'],$ContractsObj->RatingToken)){
		echo'
		<td><form  method="post" action="RatingPage.php?ID='.$ContractsObj->ContractID.'"><input type="submit" value="Review"></form></td>';
		}
		echo'
		<td><form  method="post" action="ContractPage.php?ID='.$ContractsObj->ContractID.'"><input type="submit" value="View Contract"></form></td>
	</tr>';
	}
}
echo'</table>';

echo'<div style="margin-top:10px;width:1000px;margin-left:auto;margin-right:auto;text-align:center">';			
echo'<b style="bottom: 20;">Page</b></BR>';
echo '<a href = "MyContractsPage.php?page2=1">First </a>'; 
for($page2 = 1; $page2<=$number_of_page2; $page2++) { 
	if($page2==1){
		echo '<a href = "MyContractsPage.php?page2=' . $page2 . '">' . $page2 . ' </a>';  
		
	}
	else{
	echo '<a href = "MyContractsPage.php?page2=' . $page2 . '">' . $page2 . ' </a>';  
	}
} 

echo '<a href = "MyContractsPage.php?page2=' . $number_of_page2 . '">Last </a>';  

echo'</div>';
}
else{
echo '<b>You do not have any contracts under this section</b>';  
	
}



echo'</div><div class="Buyercontracts_GUI">';
$ArrayOfContracts3 = $_SESSION['Object']->ListOfContracts("Buyer");
echo'<h1>My Buyer Contracts Table</h1>';
if(!empty($ArrayOfContracts3)){ 

echo'<hr><table id="AllContracts" class="table table-borderless table-dark">';
echo'<tr>
<th>ContractID</th>
<th>Transaction Open Date</th>
<th>ProductID</th>
<th>Product Name</th>
<th>Seller</th>
<th>Buyer</th>
<th>Initial Offer</th>
<th>Offer</th>
<th>Status</th>
<th>Go to Contracts Page</th>

';
if (!isset ($_GET['page3']) ) {  
	$page3 = 1;  
} else {  
	$page3 = $_GET['page3'];  
}
$Data_per_page = 5;
$number_of_page3 = ceil(sizeof($ArrayOfContracts3)/$Data_per_page) ;
if(round($number_of_page3) == 0){
	
	$number_of_page3 = 1;
}
$page_num = $page3;
$page_num_max = $page_num *$Data_per_page ; 
$page_num_min = $page_num_max - $Data_per_page;
for($x = $page_num_min;$x<$page_num_max;$x++){
	$ContractsObj = new Contracts();
	$ProductObj = new Products();
	if (array_key_exists($x,$ArrayOfContracts3)){
	$ContractsObj->InitialiseContract($ArrayOfContracts3[$x]);
	$ProductObj->InitialiseProduct($ContractsObj->ProductID);
	echo'<tr><td>'.$ContractsObj->ContractID.'</td>
		<td>'.$ContractsObj->TransactionOpenDate.'</td>
		<td>'.$ContractsObj->ProductID.'</td>
		<td>'.$ProductObj->ProductName.'</td>
		<td>'.$ContractsObj->SellerUserID.'</td>
		<td>'.$ContractsObj->BuyerUserID.'</td>
		<td>'.$ContractsObj->InitialOffer.'</td>
		<td>'.$ContractsObj->NewOffer.'</td>
		<td>'.$ContractsObj->Status.'</td>';
		if(in_array($_SESSION['ID'],$ContractsObj->RatingToken)){
		echo'
		<td><form  method="post" action="RatingPage.php?ID='.$ContractsObj->ContractID.'"><input type="submit" value="Review"></form></td>';
		}
		echo'
		<td><form  method="post" action="ContractPage.php?ID='.$ContractsObj->ContractID.'"><input type="submit" value="View Contract"></form></td>
	</tr>';
		
	}
}
echo'</table>';

echo'<div style="margin-top:10px;width:1000px;margin-left:auto;margin-right:auto;text-align:center">';			
echo'<b style="bottom: 20;">Page</b></BR>';
echo '<a href = "MyContractsPage.php?page3=1">First </a>'; 
for($page3 = 1; $page3<=$number_of_page3; $page3++) { 
	if($page3==1){
		echo '<a href = "MyContractsPage.php?page3=' . $page3 . '">' . $page3 . ' </a>';  
		
	}
	else{
	echo '<a href = "MyContractsPage.php?page3=' . $page3 . '">' . $page3 . ' </a>';  
	}
} 

echo '<a href = "MyContractsPage.php?page3=' . $number_of_page3 . '">Last </a>';  

echo'</div>';
}
else{
echo '<b>You do not have any contracts under this section</b>';  
	
}
echo'</div>';
require_once("Footer.php");?>