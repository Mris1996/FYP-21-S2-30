<?php require_once("NavBar.php");?>
<style>

.Refundcontacts_GUI{
	display:none;
}
.Overduecontacts_GUI{
	display:none;
}
#AllContracts{
	
	background-color:white;
	width:1700px;
	
	color:purple;
	border:1px solid grey;
	margin:auto;
	text-align:center;
}
 table,tr,th,td{
	
	border:1px solid #e8e6e6; 
 }
 tr{
	 height:50px;
	 vertical-align: text-bottom;
 }
 button,input[type=submit],input[type=button] {
	margin-top:20px;
	border:none;
	background-color:purple;
	color:white;
	font-size:20px;
	border-radius:10px;
	margin-right:10px;
}
input[type=submit]:hover {
	
	 outline:60%;
    filter: drop-shadow(0 0 5px purple);
}
input[type=button]:hover {
	
	 outline:60%;
    filter: drop-shadow(0 0 5px purple);
}
button:hover {
	
	 outline:60%;
    filter: drop-shadow(0 0 5px purple);
}
</style>
<script>
$(document).ready(function(){
  $(".All").click(function(){
    $(".Allcontracts_GUI").show();
	$(".Refundcontacts_GUI").hide();
	$(".Overduecontacts_GUI").hide();
  });
    $(".Refund").click(function(){
    $(".Allcontracts_GUI").hide();
	$(".Refundcontacts_GUI").show();
	$(".Overduecontacts_GUI").hide();
  });
    $(".Overdue").click(function(){
    $(".Allcontracts_GUI").hide();
	$(".Refundcontacts_GUI").hide();
	$(".Overduecontacts_GUI").show();
  });

});
function opencontract(ID){

window.open("ContractPage.php?ID="+ID,"winname","width=1500,height=900");
}
</script>
<button class="All">All Contracts</button>
<button class="Refund">Refunded Contracts</button>
<button class="Overdue">Overdue Contracts</button>

<?php
if(!isset($_SESSION['ID'])){
	echo '<script> location.replace("index.php")</script> ';
}
if($_SESSION['Object']->getAccountType()!="Administrator"){
	echo '<script> location.replace("index.php")</script> ';
}
echo'<div class="Allcontracts_GUI">';
$ArrayOfContracts = $_SESSION['Object']->ListOfAdminContracts("All");
echo'<h1>All contracts</h1>';
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
<th>Halt Transaction</th>
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
		<td>'.$ContractsObj->Status.'</td>
		<td><input type="button" id="'.$ContractsObj->ContractID.'" onclick="opencontract(this.id)" value="Open Contract"/></td>
		<td><form  method="post"><input type="hidden" name="HaltContractID" value="'.$ContractsObj->ContractID.'"><input type="submit" name="Halt" value="Halt Transaction"></form></td>
	</tr>';
	}
}
echo'</table>';

echo'<div style="margin-top:10px;width:1000px;margin-left:auto;margin-right:auto;text-align:center">';			
echo'<b style="bottom: 20;">Page</b></BR>';
echo '<a href = "ContractManagementPage.php?page=1">First </a>'; 
for($page = 1; $page<=$number_of_page; $page++) { 
	if($page==1){
		echo '<a href = "ContractManagementPage.php?page=' . $page . '">' . $page . ' </a>';  
		
	}
	else{
	echo '<a href = "ContractManagementPage.php?page=' . $page . '">' . $page . ' </a>';  
	}
} 

echo '<a href = "ContractManagementPage.php?page=' . $number_of_page . '">Last </a>';  

echo'</div>';
}
else{
echo '<b>You do not have any contracts under this section</b>';  
	
}
echo'</div><div class="Refundcontacts_GUI">';
$ArrayOfContracts2 = $_SESSION['Object']->ListOfAdminContracts("Requested Refund");
echo'<h1>All refunded contracts</h1>';
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
<th>Halt Transaction</th>
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
		<td>'.$ContractsObj->Status.'</td>
		<td><input type="button" id="'.$ContractsObj->ContractID.'" onclick="opencontract(this.id)" value="Open Contract"/></td>
		<td><form  method="post"><input type="hidden" name="HaltContractID" value="'.$ContractsObj->ContractID.'"><input type="submit" name="Halt" value="Halt Transaction"></form></td>
	</tr>';
	}
}
echo'</table>';

echo'<div style="margin-top:10px;width:1000px;margin-left:auto;margin-right:auto;text-align:center">';			
echo'<b style="bottom: 20;">Page</b></BR>';
echo '<a href = "ContractManagementPage.php?page2=1">First </a>'; 
for($page2 = 1; $page2<=$number_of_page2; $page2++) { 
	if($page2==1){
		echo '<a href = "ContractManagementPage.php?page2=' . $page2 . '">' . $page2 . ' </a>';  
		
	}
	else{
	echo '<a href = "ContractManagementPage.php?page2=' . $page2 . '">' . $page2 . ' </a>';  
	}
} 

echo '<a href = "ContractManagementPage.php?page2=' . $number_of_page2 . '">Last </a>';  

echo'</div>';
}
else{
echo '<b>You do not have any contracts under this section</b>';  
	
}



echo'</div><div class="Overduecontacts_GUI">';
$ArrayOfContracts3 = $_SESSION['Object']->ListOfAdminContracts("Overdue contracts");
echo'<h1>All overdue contracts</h1>';
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
<th>Halt Transaction</th>
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
		<td>'.$ContractsObj->Status.'</td>
		<td><input type="button" id="'.$ContractsObj->ContractID.'" onclick="opencontract(this.id)" value="Open Contract"/></td>
		<td><form  method="post"><input type="hidden" name="HaltContractID" value="'.$ContractsObj->ContractID.'"><input type="submit" name="Halt" value="Halt Transaction"></form></td>
	</tr>';
	}
}
echo'</table>';

echo'<div style="margin-top:10px;width:1000px;margin-left:auto;margin-right:auto;text-align:center">';			
echo'<b style="bottom: 20;">Page</b></BR>';
echo '<a href = "ContractManagementPage.php?page3=1">First </a>'; 
for($page3 = 1; $page3<=$number_of_page3; $page3++) { 
	if($page3==1){
		echo '<a href = "ContractManagementPage.php?page3=' . $page3 . '">' . $page3 . ' </a>';  
		
	}
	else{
	echo '<a href = "ContractManagementPage.php?page3=' . $page3 . '">' . $page3 . ' </a>';  
	}
} 

echo '<a href = "ContractManagementPage.php?page3=' . $number_of_page3 . '">Last </a>';  

echo'</div>';
}
else{
echo '<b>You do not have any contracts under this section</b>';  
	
}
echo'</div>';
if(isset($_POST['Halt'])){
	$_SESSION['Object']->HaltTransaction($_POST['HaltContractID']);
	echo '<script> window.open("ContractPage.php?ID='.$_POST['HaltContractID'].'","winname","width=1500,height=900");</script> ';
	
}

require_once("Footer.php");?>