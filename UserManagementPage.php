<?php require_once("NavBar.php");?>
<style>
table, th, td {
  border: 1px solid black;
}
.formcontainer{
	width:300px;
	margin:auto;
	text-align:center;
}
.formcontainer input{
	margin-top:5px;
}
</style>

<?php 

if(!isset($_SESSION['ID'])){
	echo '<script> location.replace("index.php")</script> ';
}
if($_SESSION['Object']->getAccountType()!="Administrator"){
	echo '<script> location.replace("index.php")</script> ';
}
if(!isset($_GET['ID'])){
	$_GET['ID'] = '';
}
$ArrayOfUsers = $_SESSION['Object']->ListOFUsers();
echo'<div class="formcontainer"><form method="post" action="UserManagementController.php"></br>
<Label>UserID : </Label><input type ="text" name="hiddenval" value="'.$_GET['ID'].'"></br>
<input type="submit" name="Ban" value="Ban user"></br>
<input type="submit" name="Suspend" value="Suspend user"></br>
<input type="submit" name="Remove" value="Unban/Unsuspend user"></br>
<input type="submit" name="MakeAdmin" value="Make User Admin"></br>
</form></div>
';
echo'<hr><table class="table table-borderless table-dark">';
echo'<tr><th>UserID</th>
<th>DisplayName</th>
<th>FirstName</th>
<th>LastName</th>
<th>Email</th>
<th>Rating</th>
<th>Status</th>
<th>Actions</th></tr>

';
echo'<h1>User Management Table</h1>';
if (!isset ($_GET['page']) ) {  
	$page = 1;  
} else {  
	$page = $_GET['page'];  
}
$Data_per_page = 10;
$number_of_page = ceil(sizeof($ArrayOfUsers)/$Data_per_page) ;
if(round($number_of_page) == 0){
	
	$number_of_page = 1;
}
$page_num = $page;
$page_num_max = $page_num *$Data_per_page ; 
$page_num_min = $page_num_max - $Data_per_page;
for($x = $page_num_min;$x<$page_num_max;$x++){
	$BaseUserObj = new BaseUser("Account Management");
	if (array_key_exists($x,$ArrayOfUsers)){
	$BaseUserObj->setUID_Admin($ArrayOfUsers[$x]);
	echo'<tr><td>'.$BaseUserObj->getUID().'</td>
	<td>'.$BaseUserObj->getDisplayName().'</td>
	<td>'.$BaseUserObj->getFirstName().'</td>
	<td>'.$BaseUserObj->getLastName().'</td>
	<td>'.$BaseUserObj->getEmail().'</td>
	<td>'.$BaseUserObj->Rating['Rating'].'</td>
	<td>'.json_decode($BaseUserObj->getStatus())[0].'</br>'.json_decode($BaseUserObj->getStatus())[1].'</td>
	
	<td><form method="post" action="UserManagementController.php">
		<input type="submit" name="Ban" value="Ban user">
		<input type="submit" name="Suspend" value="Suspend user"></br>
		<input type="submit" name="Remove" value="Unban/Unsuspend user">
		<input type="submit" name="MakeAdmin" value="Make User Admin">
		<input type="hidden" name="hiddenval" value="'.$BaseUserObj->getUID().'">
	</form></td>
	</tr>
	';
	}
}
echo'</table>';

echo'<div style="margin-top:10px;width:1000px;margin-left:auto;margin-right:auto;text-align:center">';			
echo'<b style="bottom: 20;">Page</b></BR>';
echo '<a href = "UserManagementPage.php?page=1">First </a>'; 
for($page = 1; $page<=$number_of_page; $page++) { 
	if($page==1){
		echo '<a href = "UserManagementPage.php?page=' . $page . '">' . $page . ' </a>';  
		
	}
	else{
	echo '<a href = "UserManagementPage.php?page=' . $page . '">' . $page . ' </a>';  
	}
} 

echo '<a href = "UserManagementPage.php?page=' . $number_of_page . '">Last </a>';  

echo'</div>';


?>
<?php require_once("Footer.php");?> 