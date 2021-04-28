<?php require_once("NavBar.php");?>
<style>
span{
	color:red;
		width:200px;
}

</style>

<?php 
if(!isset($_SESSION['ID'])){
	echo '<script> location.replace("index.php")</script> ';
}
if($_SESSION['Object']->getAccountType()!="Administrator"){
	echo '<script> location.replace("index.php")</script> ';
	
}
$SusDateErr = "";
if(isset($_POST['hiddenval'])){
	$BaseUserObj = new BaseUser("Check user");
	if(!$BaseUserObj->setUID( $_POST['hiddenval'])){
		echo'<script>alert("No such user!")</script>';
		echo '<script> location.replace("AdministratorPage.php")</script> ';
	}
	$_SESSION['Temp'] = $_POST['hiddenval'];
	
}
//ban
if (isset ($_POST['Ban']) ){  
	echo'<form method="post">
	<h1>Are you sure you sure you want to '.$_POST['Ban'].' '.$_SESSION['Temp'].'<h1>
	<input type="submit" name="YesBan" value="Yes">
	<input type="submit" name="NoBan" value="No">
	</form>
	';

}

if(isset($_POST['YesBan'])){
	$_SESSION['Object']->Ban($_SESSION['Temp']);
	unset($_SESSION['Temp']);
	echo '<script> location.replace("AdministratorPage.php")</script> ';
}
if(isset($_POST['NoBan'])){
	unset($_SESSION['Temp']);
	echo '<script> location.replace("AdministratorPage.php")</script> ';
}

//Remove ban
if (isset ($_POST['Remove']) ){  
	echo'<form method="post">
	<h1>Are you sure you sure you want to '.$_POST['Remove'].' '.$_SESSION['Temp'].'<h1>
	<input type="submit" name="YesRemove" value="Yes">
	<input type="submit" name="NoRemove" value="No">
	</form>
	';

}

if(isset($_POST['YesRemove'])){
	$_SESSION['Object']->Removestatus($_SESSION['Temp']);
	unset($_SESSION['Temp']);
	echo '<script> location.replace("AdministratorPage.php")</script> ';
}
if(isset($_POST['NoRemove'])){
	unset($_SESSION['Temp']);
	echo '<script> location.replace("AdministratorPage.php")</script> ';
}


 
//Make Admin
if (isset ($_POST['MakeAdmin']) ){  
	echo'<form method="post">
	<h1>Are you sure you sure you want to make '.$_SESSION['Temp'].' an administrator?<h1>
	<input type="submit" name="YesAdmin" value="Yes">
	<input type="submit" name="NoAdmin" value="No">
	</form>
	';

}

if(isset($_POST['YesAdmin'])){
	$_SESSION['Object']->MakeAdmin($_SESSION['Temp']);
	unset($_SESSION['Temp']);
	echo '<script> location.replace("AdministratorPage.php")</script> ';
}
if(isset($_POST['NoAdmin'])){
	unset($_SESSION['Temp']);
	echo '<script> location.replace("AdministratorPage.php")</script> ';
}

if(isset($_POST['Suspend2'])){
	if(empty($_POST['SuspendDate'])){
		$SusDateErr = "Enter the end date of suspension";
		
	}
	else{
		if(strtotime($_POST['SuspendDate'])<strtotime("today")){
			$SusDateErr = "End of suspension date should be later than today";
		}
		else{
			echo'<style> .suspension_gui{display:none;}</style>';
			echo'<form method="post">
					<h1>Are you sure you want to suspend user '.$_SESSION['Temp'].' from '.date("d/m/Y").' to '.date("d/m/Y",strtotime($_POST['SuspendDate'])).'</h1>
					</br><input type="submit" name="Yes_Suspension" value="Yes">
					<input type="submit" name="No_Suspension" value="No">
					</form>';
					$_SESSION['TempDate']  = $_POST['SuspendDate'];
		}
	}


	$_POST['Suspend2'] = true;
	$_POST['Suspend'] = true;
}
if(isset($_POST['Yes_Suspension'])){
	$_SESSION['Object']->suspendUser($_SESSION['Temp'],$_SESSION['TempDate']);
	unset($_SESSION['TempDate']);
	unset($_SESSION['Temp']);
	echo '<script> location.replace("AdministratorPage.php")</script> ';
}
if(isset($_POST['No_Suspension'])){
	unset($_SESSION['TempDate']);
	unset($_SESSION['Temp']);
	echo '<script> location.replace("AdministratorPage.php")</script> ';
}

if (isset ($_POST['Suspend']) ){  

echo'
<div class="suspension_gui">
<form method="post">
<Label>Suspend Till</Label>:<input type="date" name="SuspendDate"><span style="margin-left:20px">'.$SusDateErr.'</span>
</br><input type="submit" name="Suspend2" value="Suspend">
</form>
</div>';
}

?>
<div class="Confirmation">

</div>