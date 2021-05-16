<?php require_once("NavBar.php");

$FileErr = '';
$_SESSION['ID'] = "ASD";
if(isset($_POST["submit"])){
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
?>
<form method="post" enctype="multipart/form-data">
<label>Upload Profile Picture:</label>
<input type="file" name="file"/>
<span class="error"><?php echo $FileErr;?></span><br /><br />
<input type="submit" name="submit">
</form>
