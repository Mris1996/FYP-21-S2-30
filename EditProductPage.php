<?php require_once("NavBar.php");

if(!isset($_SESSION['ID'])){
	echo '<script> location.replace("index.php")</script> ';
}
$BaseUserOBJ = new BaseUser("Edit Product");
$NameErr = $CategoryErr = $CaptionErr = $DescriptionErr = $CostErr = $FileErr= "";
if($_SESSION['ID'] == $BaseUserOBJ->getProductOwner($_GET['ID'])){
$ProductObj = new Products();
$ProductObj->InitialiseProduct($_GET['ID']);

}
else{
	echo '<script> location.replace("index.php")</script> ';
}


$submit = true;

if(isset($_POST['submit'])){
$Name = test_input($_POST["Name"]);
$Category = test_input($_POST["Category"]);
$Caption = test_input($_POST["Caption"]); 
$Description = test_input($_POST["Description"]); 
$Cost = test_input($_POST["Cost"]);

if (empty($_POST["Category"])){
	$CategoryErr= "Category is required";	
	$submit = false;
}

if (empty($_POST["Caption"])){
	$CaptionErr= "Caption is required";	
	$submit = false;
}


if (empty($_POST["Name"])){
	$NameErr= "Name is required";	
	$submit = false;
}



if (empty($_POST["Description"])){
	$DescriptionErr= "Description is required";	
	$submit = false;
}

if (empty($_POST["Cost"])){
	$CostErr= "Initial cost is required";	
	$submit = false;
}



if (!empty($_POST["file"])){
		$file = $_FILES['file'];
		
		$File = $_FILES['file']['name'];
		$fileTmpName = $_FILES['file']['tmp_name'];
		$fileSize = $_FILES['file']['size'];
		$FileError = $_FILES['file']['error'];
		$fileType = $_FILES['file']['type'];
		
		$fileExt = explode('.',$File);
		$fileActualExt = strtolower(end($fileExt));
		$allowed = array('jpg','jpeg','png','pdf');
		
		if(in_array($fileActualExt, $allowed)){
		
			if($FileError == 0){
					
				if($fileSize < 50000){	//if file size less then 50mb
					$FileNew = uniqid('', true).".".$fileActualExt;
					$submit = true;

				} else {
					
					$FileErr= "The file is too big!";
					$submit = false;
				}
			} else {
				
				$FileErr= "There was an error uploading the file!";
				$submit = false;
			}
			
		} else {
				
				$FileErr= "You cannot upload files of this type!";
				$submit = false;
			
		
		}
	}	
}
else{
$File = '';
$Name = '';
$Category ='';
$Caption = '';
$Description = '';
$Cost = '';

}	
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<style>
.Insert_GUI{
	clear: both;
	margin-left:auto;
	margin-right:auto;
	margin-bottom:20px;
	width:1000px;
	height:1000px;
	
	text-align:left;
	opacity:0.8;
	font-size:20px;
	

}
label,span{
	display:inline-block;
	width:200px;
	margin-right:5px;
	text-align:center;
}
.Insert_GUI input[type="submit"]{
	font-size:30px;
	color:white;
	background-color:black;
}
span{
	color:red;
		width:200px;
}
hr{
	background-color:white;
}
input[type="text"]{
	font-family: arial;
	width:200px;
}
.Post_Insert_GUI{
	margin-left:auto;
	margin-right:auto;
	margin-bottom:20px;
	width:500px;
	height:300px;
	text-align:center;
	opacity:0.8;
	font-size:30px;

}
.ConfirmList_GUI{
	margin-left:auto;
	margin-right:auto;
	margin-bottom:20px;
	width:500px;
	height:300px;
	text-align:left;
	opacity:0.8;
	font-size:30px;
	
}
</style>
<h1 style="font-size:70px"><center>Edit Product</center></h1>	
 <div class="List_GUI">
    <form method="post" enctype="multipart/form-data">  
	
	<h2>Basic Product Information</h2>
		<image src="<?php echo $ProductObj->Image;?>" width="300" height="300">
		<label>Upload File:</label>
		<input type="file" name="file" value="<?php echo $ProductObj->Image;?>"/>
		<span class="error"><?php echo $FileErr;?></span><br />
	
		<label>Name:</label>
		<input type="text" name="Name" value="<?php echo $ProductObj->ProductName;?>">
		<span class="error"><?php echo $NameErr;?></span><br />
		
		<label>Category:</label>
		  <select style="background-color:black;color:white;" id="Category" name="Category">
			<?php
			$myfile = fopen("Categories.txt", "r") or die("Unable to open file!");
			while(($line = fgets($myfile)) !== false) {
			if($line==$ProductObj->ProductCategory){
							echo 
			"<option style='background-color:black;color:white;' value=".$line." selected>".$line."</option>";
			}
			else{
			echo 
			"<option style='background-color:black;color:white;' value=".$line.">".$line."</option>";
			
			}}fclose($myfile);
			?>
		  </select><br />
	<hr>
	<h2>Description of product</h2>  
	
		<label>Product Caption:</label>
		<textarea id="Caption" name="Caption" rows="1" cols="50" value=""><?php echo $ProductObj->ProductCaption;?></textarea>
		<span class="error"><?php echo $CaptionErr;?></span><br />
	
		<label style=" vertical-align: middle;">Product Description:</label>
		<textarea style=" vertical-align: middle;" id="Description" name="Description" rows="4" cols="50" value=""><?php echo $ProductObj->ProductDescription?></textarea>
		<span class="error"><?php echo $DescriptionErr;?></span><br /><br />
		
		<label>Initial Cost(STICoins):</label>

		<input type="number" id="Cost" name="Cost" min="0.00" step="any" value="<?php echo $ProductObj->ProductInitialPrice;?>">
				<br /><label>Cost will be rounded up to whole number</label>
		<span class="error"><?php echo $CostErr;?></span><br />
		<br />
		
		
		<input type="submit" name="submit" value="Done">
    </form>
</div>

<?php

if(isset($_POST['submit'])&& $submit){
	$File = $ProductObj->Image;
	if (!empty($_POST["file"])){
	$fileDestination = 'images/'.$FileNew;
	move_uploaded_file($fileTmpName, $fileDestination);
	$File = $fileDestination;
	}
	
	echo'<style> .List_GUI{display:none;}</style>';
	if($Name==$ProductObj->ProductName && $Category==$ProductObj->ProductCategory && $Description==$ProductObj->ProductDescription && $Cost==$ProductObj->ProductInitialPrice&& $Caption==$ProductObj->ProductCaption&& $File==$ProductObj->Image){
	echo'<script>history.pushState({}, "", "")</script>';
	echo'<div class="Post_Insert_GUI">
	</br>
	<center>No changes were made</center>
	<center style="color:red">Click the link below to return to product page</center>
	<a href="ProductPage.php?ID='.$_GET['ID'].'">Product.php?ID='.$_GET['ID'].'</a>
	</div>';
	echo'<script>history.pushState({}, "", "")</script>';
	exit();
	}
	if($_SESSION['Object']->UpdateProduct($_GET['ID'],$Name,$Category,$Description,round($Cost, 0),$Caption,$File)){
	echo'<script>history.pushState({}, "", "")</script>';
	echo'<div class="Post_Insert_GUI">
			</br>
			<center>Successfully Updated product!</center>
			<center style="color:red">Head over to it\'s page now!</center>
			<a href="ProductPage.php?ID='.$_GET['ID'].'">Product.php?ID='.$_GET['ID'].'</a>
		</div>';
	echo'<script>history.pushState({}, "", "")</script>';
	exit();
	}
	
	

}



?>
<?php require_once("Footer.php");?>