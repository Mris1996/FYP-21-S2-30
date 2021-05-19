<?php require_once("NavBar.php");

if(!isset($_SESSION['ID'])){
	echo '<script> location.replace("index.php")</script> ';
}
$NameErr = $CategoryErr = $CaptionErr = $DescriptionErr = $CostErr = $FileErr= "";





$submit = true;

if(isset($_POST['submit'])){
$Name = test_input($_POST["Name"]);
$Category = $_POST["Category"];
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



if (empty($_POST["file"])){
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
					
				if($fileSize < 500000){	//if file size less then 50mb
					$FileNew = uniqid('', true).".".$fileActualExt;
					

				} else {
					
					$FileErr= "The file is too big!";
					$submit = false;
				}
			} else {
				
				$FileErr= "There was an error uploading the file!";
				$submit = false;
			}
			
		} else {
			if($fileSize==0){
				
				$FileErr= "Upload a file";
				$submit = false;
			}
			else{	
				$FileErr= "You cannot upload files of this type!";
				$submit = false;
			}
		
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
<h1 style="font-size:70px"><center>Insert New Product Details</center></h1>	
 <div class="List_GUI">
    <form method="post" enctype="multipart/form-data">  
	
	<h2>Basic Product Information</h2>
	
		<label>Upload File</label>
		<input type="file" name="file"/>
		<span class="error"><?php echo $FileErr;?></span><br />
	
		<label>Name:</label>
		<input type="text" name="Name" value="<?php echo $Name;?>">
		<span class="error"><?php echo $NameErr;?></span><br />
		
		<label>Category:</label>
		  <select style="background-color:black;color:white;" id="Category" name="Category">
			<?php
			$myfile = fopen("Categories.txt", "r") or die("Unable to open file!");
			while(($line = fgets($myfile)) !== false) {

			echo 
			"<option style='background-color:black;color:white;' value='".$line."'>".$line."</option>";
			}fclose($myfile);
			?>
		  </select><br />
	<hr>
	<h2>Description of product</h2>  
	
		<label>Product Caption:</label>
		<textarea id="Caption" name="Caption" rows="1" cols="50" value=""><?php echo $Caption;?></textarea>
		<span class="error"><?php echo $CaptionErr;?></span><br />
		<label style=" vertical-align: middle;">Product Description:</label>
		<textarea style=" vertical-align: middle;" id="Description" name="Description" rows="4" cols="50" value=""><?php echo $Description;?></textarea>
		<span class="error"><?php echo $DescriptionErr;?></span><br /><br />
		
		<label>Initial Cost(STICoins):</label>

		<input type="number" id="Cost" name="Cost" min="0.00" step="any" value="<?php echo $Cost;?>">
				<br /><label>Cost will be rounded up to whole number</label>
		<span class="error"><?php echo $CostErr;?></span><br />
		<br />
		
		
		<input type="submit" name="submit" value="List">
    </form>
</div>

<?php

if(isset($_POST['submit'])&& $submit){

	$fileDestination = 'images/'.$FileNew;
	move_uploaded_file($fileTmpName, $fileDestination);
	$File = $fileDestination;
	echo'<style> .List_GUI{display:none;}</style>';
	$ProductID = $_SESSION['Object']->ListProduct($Name,$Category,$Description,round($Cost, 0),$Caption,$File);
	echo'<div class="Post_Insert_GUI">
			</br>
			<center>Successfully Listed product!</center>
			<center>Product Confirmation</center>
			<img src="'.$File.'" width="500" height="600">
			<label>Product ID:</label>'.$ProductID.'</br>
			<label>Name:</label>'.$Name.'</br>
			<center style="color:red">Head over to it\'s page now!</center>
			<a href="ProductPage.php?ID='.$ProductID.'">Product.php?ID='.$ProductID.'</a>
		</div>';
	
	echo'<script>history.pushState({}, "", "")</script>';
	exit();
	
	

}



?>
<?php require_once("Footer.php");?> 