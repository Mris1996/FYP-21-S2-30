<?php require_once("NavBar.php");?>

<style>

	
	

span{
	
	color:red;
}

.AddGUI{
	 display:none;
	width:1000px;
	height:1000px;
	text-align:center;
	margin:auto;
	border:1px solid black;
	border-radius:20px;
	box-shadow:5px 5px gray;
}
.AddGUI input[type="submit"]{
	margin-right:5%;
	float:right;

	
}
.AddGUI input[type="file"]{
	margin-top:3%;
	text-align:center;
	
}

 table,tr,th,td{
		text-align:center;
	border:1px solid #e8e6e6; 
 }
 tr{
	 height:50px;
	 vertical-align: text-bottom;
 }
 button,input[type=submit],input[type=button] {
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
#adsgui{
	width:100%;
	margin:auto;
}
table{
	width:80%;
	
	
}

th{
	width:200px;
	
}
#output{
		margin-top:5%;
	width:900px;
  height:600px;
  border:none;
}
</style>

<center><h1>Advertisment Management</h1><center><hr><div id="adsgui">
<table>
<tr>

<th>Ads Preview</th>
<th>No.</th>
<th>User</th>
<th>Date</th>
<th>Action</th>


</tr>
<?php 

if(!isset($_SESSION['ID'])){
	echo '<script> location.replace("index.php")</script> ';
}
if($_SESSION['Object']->getAccountType()!="Administrator"){
	echo '<script> location.replace("index.php")</script> ';
}

$ArrayOFAds = $_SESSION['Object']->ListOfAds();

for($x = 0;$x<sizeof($ArrayOFAds);$x++){
	echo'<tr><td><img src="'.$ArrayOFAds[$x][0].'" width:"400px" height="400px" ></td>
	<td>'.$x.'</td>
	<td>'.$ArrayOFAds[$x][1].'</td>	
	<td>'.$ArrayOFAds[$x][2].'</td>
	<td><form method="post">
	<input type="submit" name="Remove" value="Remove">
	<input type="hidden" name="ImageID" value="'.$ArrayOFAds[$x][0].'">
	</form></td></tr>
	';
}
if(sizeof($ArrayOFAds)==0){
echo'<td colspan="5">Add advertisments</td>';	
}
if(isset($_POST['Remove'])){
		$_SESSION['Object']->RemoveAds($_POST['ImageID']);
			echo '<script> location.replace("AdsManagementPage.php")</script> ';
		exit();
}

$ImageErr = $UserIDErr = '';
$Submit = true;
if(isset($_POST['AddSubmit'])){
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
					
				if($fileSize < 5000000){	//if file size less then 50mb
					$FileNew = uniqid('', true).".".$fileActualExt;
					

				} else {
					
					$FileErr= "The file is too big!";
					$Submit = false;
				}
			} else {
				
				$FileErr= "There was an error uploading the file!";
				$Submit = false;
			}
			
		} else {
			if($fileSize==0){
				
				$FileErr= "Upload a file";
				$Submit = false;
			}
			else{	
				$FileErr= "You cannot upload files of this type!";
				$Submit = false;
			}
		
		}
	}
	
	if($Submit){
		$fileDestination = 'ads/'.$FileNew;
		move_uploaded_file($fileTmpName, $fileDestination);
		$File = $fileDestination;
		
		$_SESSION['Object'] ->AddAds($File ,$_POST["UserIDInput"]);
		echo '<script> location.replace("AdsManagementPage.php")</script> ';
		exit();
	}
}
else{
	echo"<style>.AddButton{display:block}</style>";
}
?>
</table>
</div>
<script>
$(document).ready(function(){
  $(".AddButton").click(function(){
    $(".AddGui").show();
	  $(".AddButton").hide();
  });
});
</script>
<center>
<br /><br />
<button class="AddButton">Add</button>
<div class="AddGUI">
<center><h1>Preview</h1></center>
<form method="post" enctype="multipart/form-data">

  <img id="output" /></br>
    <label>Image:</label>
  <input type="file" name="file" accept="image/*" value="default" onchange="loadFile(event)">
	<script>
	var loadFile = function(event) {
	var output = document.getElementById('output');
	output.src = URL.createObjectURL(event.target.files[0]);
	output.onload = function() {
	  URL.revokeObjectURL(output.src) // free memory
	}
	};
	</script>
  <span class="error"><?php echo $ImageErr ?></span><br /><br />
  <label>UserID:</label>
  <input type="text" name="UserIDInput" required><br><br>
  <span class="error"><?php echo $UserIDErr?></span><br /><br />
  <input type="submit" name="AddSubmit" value="Add">

</form> 
</div>
</center>
<?php require_once("Footer.php");?>