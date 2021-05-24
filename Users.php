<?php

class BaseUser
{
	public $UID;
	public $DisplayName;
	public $PubKey;
	public $Email;
	public $FirstName;
	public $LastName;
	public $DOB;
	public $ContactNumber;
	public $Address;
	public $AccountType;
	public $AccountBalance;
	private $PrivateKey;
	public $Rating;
	public $Status;
	public $ProfilePic;
	public $results_per_page = 12;  
	public $Reported;  
	
	public function __construct($Operation)
	{
		if($Operation == "SignUp"){
			$this->createEthereumAccount();
		}
	}
	
	public function LoginValidate($ID,$Pass)
	{	$ID = filter_var($ID, FILTER_SANITIZE_STRING);
		$ID = preg_replace('/(\'|&#0*39;)/', '', $ID);
		$sql = "SELECT * FROM users WHERE UserID='".$ID."'";
		$result = $this->connect()->query($sql) or die($this->connect()->error);    
		if ($result->num_rows == 0) 
		{
			return false;
		}
		else{
			$sql = "SELECT Password FROM users WHERE UserID='".$ID."'" ;
			$result = $this->connect()->query($sql) or die($this->connect()->error); 
			$validated = false;
			while($row = $result->fetch_assoc()){ 
				if(Password_verify($Pass,$row["Password"]))
				{	$validated = true;
					
				}
				
			}	
			
			if($validated)
			{	
				$this->setUID($ID);
				$sql="UPDATE `users` SET `LoginCount`= `LoginCount`+1 WHERE `UserID`='".$ID."'";
				$result = $this->connect()->query($sql) or die($this->connect()->error); 
				return true;
			}
			else{
				return false;
			}
		}
		
	}
	public function LogOut(){
		$sql="UPDATE `users` SET `LoginCount`= `LoginCount`-1 WHERE `UserID`='".$this->getUID()."'";
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		echo'<style> input[name="Nav_Login"]{display:visible;}</style>';
		$_SESSION['ID']=NULL;
		session_destroy();
		echo '<script> location.replace("LoginPage.php")</script> ';
		exit();
	}
	
	public function ForgetPassword ($userid, $email)
	{	
		$data            = "";
		$hashed_password = "";
		$header          = "";
		$msg             = "";
		$result          = "";
		$sql             = "";
		$temp_password   = "";
		$user_email      = "";
		$user_userid     = "";
		
		// Validation here AGAIN just in case this method is called elsewhere which might lack validation.
		$user_userid = filter_var($userid, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);  // Sanitize userid
		$user_email  = filter_var($email, FILTER_SANITIZE_EMAIL);                            // Sanitize email
		
		// Query to check user ID if it exists in Database (Users)
		$sql = "SELECT * FROM users WHERE UserID='".$user_userid."'";
		
		// Executing the query above
		$result = $this->connect()->query($sql) or die($this->connect()->error); 

		// By right since UserID is unique, should only have 1 row as result
		// Designed for Default-Deny structure
		if ($result->num_rows == 1)
		{
			// Generate temporary password 15 characters long
			// Don't use "rand" as its not secure
			$data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
			for ($i = 0; $i < 15; $i++) 
			{
				$temp_password .= substr(str_shuffle($data), 0, 1);
			}
			
			// Hash temporary password
			$hashed_password = password_hash($temp_password, PASSWORD_DEFAULT);
			// Generating Salt is not needed as "password_hash" and "password_verify"
			// does it automatically and adds it to hash generated. 
			// See official command documentation for more details

			
			// Before storing temporary password, check if "temporarypassword" table has rows with 
			// the corresponding user ID, this to prevent duplicate records.
			$sql = "SELECT * FROM temporarypassword WHERE UserID='".$user_userid."'";
			$result = $this->connect()->query($sql) or die($this->connect()->error);
			
			// Checks if number of rows is more than "0"
			if ($result->num_rows > 0)
			{
				// Delete any duplicates 
				$sql = "DELETE FROM temporarypassword WHERE UserID='".$user_userid."'";
				$result = $this->connect()->query($sql) or die($this->connect()->error);
			}
			
			// Storing of temporary password in database (temporarypassword)
			$sql = "INSERT INTO `temporarypassword` (`UserID`, `Password`) VALUES ('".$user_userid."','".$hashed_password."')";
			$result = $this->connect()->query($sql) or die($this->connect()->error); 
			
			// Crafting the email
			// Setting headers
			$header  = "From:fyp21s230@gmail.com \r\n";
			$header .= "MIME-Version: 1.0\r\n";
			$header .= "Content-type: text/html\r\n";
			// Crafting message
			$msg = "Your temporary password is: ".$temp_password."\nClick on the link below to reset your password:\n<a href ='http://0621eb739b7e.ngrok.io/FYP-21-S2-30/PasswordResetPage.php'>Reset Password</a>";
			// Tells the system to wrap words if longer than 70
			$msg = wordwrap($msg,70);
			
			// Send mail
			if(mail($user_email,"Reset Password",$msg,$header)){ return "SUCCESS"; }
			else { return "Error occured! Please retry!"; }
		}
		else
		{
			
			return "Error occured! Please retry!";
			
				
		}
		
	}
	
	public function ResetPassword ($userid, $temporary_password, $new_password)
	{
		
		// Initialize variables
		$new_hashed_password = "";
		$result = "";
		$row = "";
		$sql = "";
		$retrieved_hash_password = "";
		$user_userid = "";
		
		// Validation for UserID
		$user_userid = filter_var($userid, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);  // Sanitize userid
		
		// Unable to implement PDO due to too much complications and unfamiliar syntax
		// Unsure but SQL Query may be prone to injection attacks.
		
		// Query to check user ID if it exists in Database (temporarypassword)
		$sql = "SELECT * FROM temporarypassword WHERE UserID='".$user_userid."'";
		$result = $this->connect()->query($sql) or die($this->connect()->error);  // Executing the query 

		// By right since UserID is unique, should only have 1 row as result
		if ($result->num_rows == 1)
		{
			
			$row = $result -> fetch_row();
			$retrieved_hash_password = $row[1];
			
			// Compare hashed passwords
			if (password_verify($temporary_password, $retrieved_hash_password)) 
			{
				// STOPPED HERE
				// Delete all temporary passwords associated with the username from database (temporaryPassword)
				$sql = "DELETE FROM temporarypassword WHERE UserID='".$user_userid."'";
				$result = $this->connect()->query($sql) or die($this->connect()->error);
			
				// Check if UserID exists in Database (Users)	
				$sql = "SELECT * FROM users WHERE UserID='".$user_userid."'"; 			
				$result = $this->connect()->query($sql) or die($this->connect()->error); 
				// By right since UserID is unique, should only have 1 row as result
				if ($result->num_rows == 1)
				{
					
					// Hash new password
					$new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
			
					// Update of new password in database (users)
					$sql = "UPDATE `users` SET `Password`='".$new_hashed_password."' WHERE `UserID`= '".$user_userid."'";					
					$result = $this->connect()->query($sql) or die($this->connect()->error); 
					
					// Once all functions successfully execute, then return "success"
					return "SUCCESS";
				}
				else { return "Error occured! Please retry!"; } // User would need to obtain another Temporary Password
				
			} 
			else { return "Error occured! Please retry!"; } // When Temporary password do not match			
		}
		else
		{
	
			return "Error occured! Please retry!";
			
			// Don't put unique error messages for "no" or "zero" rows. Keep them generic.
			// This is so to prevent hackers from performing account enumeration using this system.			
		}
	}
	public function getCurrencyValue($Currency){
		$ch = curl_init('https://min-api.cryptocompare.com/data/price?fsym=ETH&tsyms=SGD,USD,EUR');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$CurrencyVal = json_decode($response,true);
		curl_close($ch);
		return $CurrencyVal[$Currency];
		
	}
	public function GetAccountBalanceFromServer($PubKey){
		$host    = "localhost";
		$port    = 8080;
		$arr = array('REQUEST' => "GetBalance" , 'ACCOUNTPUBLICKEY' => $PubKey);
		$message = json_encode($arr);
		$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
		$result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");  
		if($result) { 
		socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
		$result = socket_read ($socket, 1024) or die("Could not read server response\n");
		}
		
		socket_close($socket);
		sleep(5);
		$sql = "SELECT * FROM users WHERE PublicKey='".$PubKey."'" ;
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
	
		while($row = $result->fetch_assoc())
		{ 	
			$Bal = $row['AccountBalance'];
		}

		 	
			//$Bal = ($Bal * $this->getCurrencyValue('SGD'));
		 $Bal = number_format($Bal, 5, '.', '');
		 return $Bal;
	}
	
	public function createEthereumAccount(){
		
		$host    = "localhost";
		$port    = 8080;
		$arr = array('REQUEST' => "GetNewAccount");
		$message = json_encode($arr);
		$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
		$result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");  
		if($result) { 
		socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
		$result = socket_read ($socket, 1024) or die("Could not read server response\n");
		}
		socket_close($socket);
		$raw_data = file_get_contents('http://localhost:3004/GetNewAccount');
		$data = json_decode($raw_data, true);
		$this->PubKey =  $data['pubkey'];
		$this->PrivateKey = $data['privatekey'];
		
	}
	public function SignUpValidate($ID,$Email,$Pass,$FName,$LName,$ContactNumber,$DispName,$DOB,$Address,$ProfilePicCurrent,$ProfilePicDest){
		$ID = preg_replace('/(\'|&#0*39;)/', '', $ID);
		$Pass = preg_replace('/(\'|&#0*39;)/', '', $Pass);
		$Email = preg_replace('/(\'|&#0*39;)/', '', $Email);
		$FName = preg_replace('/(\'|&#0*39;)/', '', $FName);
		$LName = preg_replace('/(\'|&#0*39;)/', '', $LName);
		$DispName = preg_replace('/(\'|&#0*39;)/', '', $DispName);
		$Address = preg_replace('/(\'|&#0*39;)/', '', $Address);
		
		$sql = "SELECT * FROM users WHERE UserID='".$ID."'";
		$result = $this->connect()->query($sql) or die($this->connect()->error);    
		if ($result->num_rows != 0) 
		{
			return "UserID error";
			
		}
		$sql = "SELECT * FROM users WHERE Email='".$Email."'";
		$result = $this->connect()->query($sql) or die($this->connect()->error);    
		if ($result->num_rows != 0) 
		{
			return "Email error";
			
		}
		$HPass = password_hash($Pass, PASSWORD_DEFAULT);
		$Type = "Standard";
		$sql = "INSERT INTO users (UserID,FirstName,LastName,Email,ContactNumber,Password,AccountType,DisplayName,Address,DateOfBirth,PublicKey,PrivateKey,ProfilePicture)VALUES('".$ID."','".$FName."','".$LName."','".$Email."' ,'".$ContactNumber."','".$HPass."','".$Type."','".$DispName."','".$Address."','".date('d/m/Y', strtotime($DOB))."','".$this->PubKey."','".$this->PrivateKey."','".$ProfilePicDest."' )";
		$result = $this->connect()->query($sql) or die( $this->connect()->error);    	
		move_uploaded_file($ProfilePicCurrent, $ProfilePicDest);
		return "validated";
	}
	
	public function getUID(){
		return 	$this->UID;
	}
	public function setUID($UID){
		$sql = "SELECT * FROM users WHERE UserID='".$UID."'" ;
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		if ($result->num_rows == 0) 
			{
				return false;

			}	
		while($row = $result->fetch_assoc())
		{ 	
			$this->UID = $row["UserID"];
			$this->DisplayName = $row["DisplayName"];
			$this->PubKey = $row["PublicKey"];
			$this->Email = $row["Email"];
			$this->FirstName = $row["FirstName"];
			$this->LastName = $row["LastName"];
			$this->DOB = $row["DateOfBirth"];
			$this->ContactNumber = $row["ContactNumber"];
			$this->Address = $row["Address"];
			$this->AccountType = $row["AccountType"];
			$this->AccountBalance = $this->GetAccountBalanceFromServer($this->PubKey);
			$this->Rating = json_decode($row["Rating"],true);
			$this->Status = $row["Status"];
			$this->ProfilePic = $row["ProfilePicture"];
			$this->Reported = $row["Reported"];

	}
	
	return true;
		
	}
	public function setUID_Admin($UID){
		$sql = "SELECT * FROM users WHERE UserID='".$UID."'" ;
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		if ($result->num_rows == 0) 
			{
				return false;

			}	
		while($row = $result->fetch_assoc())
		{ 	
			$this->UID = $row["UserID"];
			$this->DisplayName = $row["DisplayName"];
			$this->PubKey = $row["PublicKey"];
			$this->Email = $row["Email"];
			$this->FirstName = $row["FirstName"];
			$this->LastName = $row["LastName"];
			$this->DOB = $row["DateOfBirth"];
			$this->ContactNumber = $row["ContactNumber"];
			$this->Address = $row["Address"];
			$this->AccountType = $row["AccountType"];
			$this->Rating = json_decode($row["Rating"],true);
			$this->Status = $row["Status"];
			$this->ProfilePic = $row["ProfilePicture"];
			$this->Reported = $row["Reported"];
	}
	
	return true;
		
	}
	public function getPrivate(){
		return 	$this->PrivateKey;
	}
	public function getDisplayName(){
		return 	$this->DisplayName;
	}
	public function getPubKey(){
		return 	$this->PubKey;
	}
	public function getEmail(){
		return 	$this->Email;
	}
	public function getFirstName(){
		return $this->FirstName;
	}
	public function getLastName(){
		return $this->LastName;
	}
	public function getDOB(){
			return $this->DOB;
	}
	public function getContactNumber(){
		return $this->ContactNumber;
	}
	public function getAddress(){
		return $this->Address;
	}
	public function getAccountType(){
		return $this->AccountType;
	}
	public function getAccountBalance(){
		return $this->AccountBalance;
	}
	public function updateBalance(){
	 $this->AccountBalance=$this->GetAccountBalanceFromServer($this->PubKey);
		
	}
	public function getStatus(){
		return $this->Status;
	}
	public function connect(){
		$servername= "localhost";
		$username = "root";
		$password = "";
		$dbname = "sticdb";
		$conn = new mysqli($servername, $username, $password, $dbname);
		return $conn;
		
	}
	public function getUserDisplayName($UID){
		$sql = "SELECT * FROM users WHERE UserID='".$UID."'" ;
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		while($row = $result->fetch_assoc())
		{ 
			return $row["DisplayName"];
		}
	}
	public function getProductOwner($ProductID){
			$ID = trim($ProductID);
			$sql = "SELECT * FROM product WHERE ProductID='".$ProductID."'" ;
			$result = $this->connect()->query($sql) or die($this->connect()->error); 
			while($row = $result->fetch_assoc())
			{ 
				return $row["SellerUserID"];
			}
	}
	public function viewReview($ID,$Type){
		if($Type=="User"){
			$ID = trim($ID);
			$sql = "SELECT * FROM users WHERE UserID='".$ID."'" ;
			
		}
		if($Type=="Product"){
			$ID = trim($ID);
			$sql = "SELECT * FROM product WHERE ProductID='".$ID."'" ;
			
		}

		$result = $this->connect()->query($sql) or die($this->connect()->error); 
			while($row = $result->fetch_assoc())
			{ 
				$Data = $row['Review'];
			}

			if($Data!=null&&sizeof(json_decode($Data))!=0){
			$Data = json_decode($Data, true);
			for($i =0;$i<sizeof($Data);$i++){
			
			echo'
	
			<div class="media border p-3" style="width:40%;margin:auto;margin-top:5px;">
			<div class="media-body">
			<h4>'.$Data[$i]["User"].'<small>   <i>Posted on '.$Data[$i]["Date"].'</i></small></h4>
			<p>'.$Data[$i]["Review"].'</p>
			</div>
			</div></br>';
			}
			}
			else{
			echo '
			<div class="media border p-3" style="margin-top:5px;width:40%;margin:auto;">
			<div class="media-body">
			<b style="margin:auto;"> No Reviews Yet</b></div>
			</div></br>';	
			}
	}
	public function ViewAllProduct($sortby,$Order,$Category,$page,$pagename){
	
			if($Category=="All"){
					$sql = "SELECT * FROM product WHERE Status = 'Available' ORDER BY $sortby $Order" ;
			}
			
			else{
					$sql = "SELECT * FROM product WHERE Status = 'Available' AND ProductCategory = '".$Category."' ORDER BY $sortby $Order" ;
			}
			$result = $this->connect()->query($sql) or die($this->connect()->error); 
			$number_of_result = mysqli_num_rows($result);  
			$number_of_page = ceil ($number_of_result / $this->results_per_page);  
			if($page>$number_of_page){
				$page = 1;
			}
			$page_first_result = ($page-1) * $this->results_per_page;  
			if ($number_of_result == 0) 
			{
				echo'
					<b>No products in this category</b>';
				return;
			}
			
			if($Category=="All"){
					$sql = "SELECT * FROM product WHERE Status = 'Available' ORDER BY $sortby $Order LIMIT " . $page_first_result . ',' . $this->results_per_page; 
			}
			else{
					$sql = "SELECT * FROM product WHERE Status = 'Available' AND ProductCategory = '".$Category."' ORDER BY $sortby $Order LIMIT " . $page_first_result . ',' . $this->results_per_page; 
			}
			$result = mysqli_query($this->connect(), $sql);  
			
			while($row = $result->fetch_assoc())
			{ 
			
			echo'
			<div class="container">
			<img src="'.$row["Image"].'" class="image" style="width:500px;height:400px">
			<div class="middle">
			<div class="text">Seller:<a href="ProfilePage.php?ID='.$row["SellerUserID"].'">'.$row["SellerUserID"].'</a></div>
			<div class="text">Product Name:'.$row["ProductName"].'</div>
			<div class="text">Category:'.$row["ProductCategory"].'</div>
			<div class="text">Date Listed:<i>'.date('d-m-Y',$row["DateOfListing"]).'</i></div>
			<div class="text">Initial Price:'.number_format($row["ProductInitialPrice"], 2, '.', '').'</div>
			<form action="ProductPage.php?ID='.$row["ProductID"].'" method="post"></br>
			<input type="submit" value="Product Page"/>
			</form>
			</div>
			</div></div>';
		
			}
			if($number_of_page>1){
			echo'<div class = "pagination" >';			
			echo'<b style="bottom: 20;">Page</b></BR></BR>';
			echo '<a href = "'.$pagename.'?Ord='.$Order.'&Sb='.$sortby.'&page=1">First </a>'; 
			for($page = 1; $page<= $number_of_page; $page++) { 
				if($page==1){

				echo '<a href = "'.$pagename.'?Ord='.$Order.'&Sb='.$sortby.'&page=' . $page . '">' . $page . ' </a>';  
				
				}
				else{
				echo '<a href = "'.$pagename.'?Ord='.$Order.'&Sb='.$sortby.'&page=' . $page . '">' . $page . ' </a>';  
				}
			} 
			echo '<a href = "'.$pagename.'?Ord='.$Order.'&Sb='.$sortby.'&page=' . $number_of_page . '">Last </a>';  
			echo'</div>';
			}
			
			}
	public function ViewSearchProduct($sortby,$Order,$Query,$page){
			
			$sql = "SELECT * FROM product WHERE ProductName LIKE '%$Query%' or ProductCategory LIKE '%$Query' or SellerUserID LIKE '%$Query%' ORDER BY $sortby $Order" ;
			$result = $this->connect()->query($sql) or die($this->connect()->error); 
			$number_of_result = mysqli_num_rows($result);  
			$number_of_page = ceil ($number_of_result / $this->results_per_page); 
			if($page>$number_of_page){
				$page = 1;
			}			
			$page_first_result = ($page-1) * $this->results_per_page;  
			if ($result->num_rows == 0) 
			{
				echo'
					<b>No search result found</b>';

			}

			$sql = "SELECT * FROM product WHERE ProductName LIKE '%$Query%' or ProductCategory LIKE '%$Query' or SellerUserID LIKE '%$Query%' ORDER BY $sortby $Order LIMIT " . $page_first_result . ',' . $this->results_per_page; 
			$result = mysqli_query($this->connect(), $sql);  
			while($row = $result->fetch_assoc())
			{ 

			echo'
			<div class="container">
			<img src="'.$row["Image"].'" class="image" style="width:500px;height:400px">
			<div class="middle">
			<div class="text">Seller:<a href="ProfilePage.php?ID='.$row["SellerUserID"].'">'.$row["SellerUserID"].'</a></div>
			<div class="text">Product Name:'.$row["ProductName"].'</div>
			<div class="text">Category:'.$row["ProductCategory"].'</div>
			<div class="text">Date Listed:<i>'.date('d-m-Y',$row["DateOfListing"]).'</i></div>
			<div class="text">Initial Price:'.number_format($row["ProductInitialPrice"], 2, '.', '').'</div>
			<form action="ProductPage.php?ID='.$row["ProductID"].'" method="post"></br>
			<input type="submit" value="Product Page"/>
			</form>
			</div>
			</div>';
		
			}
			if($number_of_page>1){
			echo'<div class = "pagination" >';			
			echo'<b style="bottom: 20;">Page</b></BR></BR>';
			echo '<a href = "SearchPage.php?query='.$Query.'&Ord='.$Order.'&Sb='.$sortby.'&page=1">First </a>'; 
			for($page = 1; $page<= $number_of_page; $page++) { 
				if($page==1){

				echo '<a href = "SearchPage.php?query='.$Query.'&Ord='.$Order.'&Sb='.$sortby.'&page=' . $page . '">' . $page . ' </a>';  
				
				}
				else{
				echo '<a href = "SearchPage.php?query='.$Query.'&Ord='.$Order.'&Sb='.$sortby.'&page=' . $page . '">' . $page . ' </a>';  
				}
			} 
			echo '<a href = "SearchPage.php?query='.$Query.'&Ord='.$Order.'&Sb='.$sortby.'&page=' . $number_of_page . '">Last </a>';  
			echo'</div>';
			}			
			
	}
	
	public function ViewAllUserProduct($sortby,$Order,$UID){
			
			$sql = "SELECT * FROM product WHERE SellerUserID = '$UID' ORDER BY $sortby $Order" ;
			
			$result = $this->connect()->query($sql) or die($this->connect()->error); 
			if ($result->num_rows == 0) 
			{
				echo'
					<b>This user has not listed any products</b>';

			}	
			while($row = $result->fetch_assoc())
			{ 

			echo'
			<div class="container">
			<img src="'.$row["Image"].'" class="image" style="width:500px;height:400px">
			<div class="middle">
			<div class="text">Product Name:'.$row["ProductName"].'</div>
			<div class="text">Category:'.$row["ProductCategory"].'</div>
			<div class="text">Date Listed:<i>'.date('d-m-Y',$row["DateOfListing"]).'</i></div>
			<div class="text">Initial Price:'.number_format($row["ProductInitialPrice"], 2, '.', '').'</div>
			<form action="ProductPage.php?ID='.$row["ProductID"].'" method="post"></br>
			<input type="submit" value="Product Page"/>
			</form>
			</div>
			</div>';
		
			}	
			
		
	}
			
			
			
		
			
	}
	




class StandardUser extends BaseUser 
{
	private $EscrowPrivate;
	public function __construct($Object){
	
		$this->UID = $Object->getUID();
		$this->DisplayName =  $Object->getDisplayName();
		$this->PubKey =  $Object->getPubKey();
		$this->Email = $Object->getEmail();
		$this->FirstName =  $Object->getFirstName();
		$this->LastName =  $Object->getLastName();
		$this->DOB =  $Object->getDOB();
		$this->ContactNumber =  $Object->getContactNumber();
		$this->Address =  $Object->getAddress();
		$this->AccountType =  $Object->getAccountType();
		$this->AccountBalance = $Object->getAccountBalance();
		$this->ProfilePic = $Object->ProfilePic;
		$this->Reported = $Object->Reported;
		}
	
	public function NewOffer($Offer,$DateRequired,$SellerID,$ProductID,$InitialOffer){

		while(true){					
					$ContractID = str_pad(rand(0000,9999),4,0,STR_PAD_LEFT).str_pad(rand(0000,9999),4,0,STR_PAD_LEFT).str_pad(rand(0000,9999),4,0,STR_PAD_LEFT).chr(rand(97,122)).chr(rand(97,122)).chr(rand(97,122)).str_pad(rand(0000,9999),4,0,STR_PAD_LEFT). substr(rand(0000,9999), 2, 4);
					$result = $this->connect()->query("SELECT count(*) as 'c' FROM contracts WHERE ContractID='".$ContractID."'");
					$count = $result->fetch_object()->c;
					if ($count==0)
					  {
						break;
					  }
				}
				
		$sql = "INSERT INTO `contracts`(`ContractID`,`InitialOffer`,`NewOffer`,`DateRequired`, `BuyerUserID`, `SellerUserID`, `ProductID`) VALUES ('".$ContractID."','".$InitialOffer."','".$Offer."','".$DateRequired."','".$this->getUID()."','".$SellerID."','".$ProductID."')";
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		return $ContractID;
	}
	public function ListOfContracts($ContractType){
		if($ContractType=="All"){
		$sql = "SELECT * FROM contracts WHERE SellerUserID ='".$this->getUID()."' OR BuyerUserID ='".$this->getUID()."' ORDER BY TransactionOpenDate" ;
		}
		if($ContractType=="Seller"){
		$sql = "SELECT * FROM contracts WHERE SellerUserID ='".$this->getUID()."' ORDER BY TransactionOpenDate" ;
		}
		if($ContractType=="Buyer"){
		$sql = "SELECT * FROM contracts WHERE BuyerUserID ='".$this->getUID()."' ORDER BY TransactionOpenDate" ;
		}
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		if ($result->num_rows == 0) 
			{
				return false;

			}
		$ArrayOfContracts = array();
		while($row = $result->fetch_assoc())
		{
			array_push($ArrayOfContracts,$row['ContractID']);
			
				
		}
		return $ArrayOfContracts;
	}
	/*
	public function Chat($UserID){
	
		$sql = "SELECT * FROM negotiation WHERE UserID='".$UserID."' AND UserID2='".$this->getUID()."' OR UserID='".$this->getUID()."' AND UserID2='".$UserID."'";
		$result = $this->connect()->query($sql) or die($this->connect()->error);    
		if ($result->num_rows == 0) 
		{	
			
			$FullMessageArray = array();
			$JSONdata = Json_encode($FullMessageArray);
			$sql = "INSERT INTO `negotiation`(`UserID`, `Message`, `UserID2`) VALUES ('".$this->getUID()."','".$JSONdata."','".$UserID ."')";
			$result = $this->connect()->query($sql) or die($this->connect()->error); 
		}
		
	}
	public function DeleteChat($UserID){
		
		$sql = "DELETE FROM negotiation WHERE UserID='".$UserID."' AND UserID2='".$this->getUID()."' OR UserID='".$this->getUID()."' AND UserID2='".$UserID."'";
		$result = $this->connect()->query($sql) or die($this->connect()->error);    
		
	}
	public function AllChatsArray(){
	
		$sql = "SELECT * FROM negotiation WHERE UserID='".$this->getUID()."' OR UserID2='".$this->getUID()."'";
		$result = $this->connect()->query($sql) or die($this->connect()->error);    
		
		if ($result->num_rows == 0) 
		{
			echo'<b>You have no chats currently</b>';
		}
		else{
			echo'<form method="post">';
			while($row = $result->fetch_assoc())
			{
					
					if($row['UserID']!=$this->getUID()){
					echo'<input type="submit" name ="Chat_with" value="'.$row['UserID'].'"></br>';
					
					}
					else{
					echo'<input type="submit" name ="Chat_with" value="'.$row['UserID2'].'"></br>';	
					}
					
					
			}
			echo'</form>';
		}
			
	}*/
	public function InsertOrdinaryChat($User1,$User2,$Message){
		$Message = preg_replace('/(\'|&#0*39;)/', '', $Message);
	
		$sql = "SELECT * FROM negotiation WHERE UserID='".$User1."' AND UserID2='".$User2."' OR UserID='".$User2."' AND UserID2='".$User1."'";
		$result = $this->connect()->query($sql) or die($this->connect()->error);    
		if ($result->num_rows == 0) 
		{
			$FullMessageArray = array($Message);
			$JSONdata = Json_encode($FullMessageArray);
			$sql = "INSERT INTO `negotiation`(`UserID`, `Message`, `UserID2`) VALUES ('".$User1."','".$JSONdata."','".$User2 ."')";
			$result = $this->connect()->query($sql) or die($this->connect()->error); 
		}
		else{
			while($row = $result->fetch_assoc())
			{ 
			
				$FullMessageArray = Json_decode( $row["Message"],true);

			}
			array_push($FullMessageArray,$Message);
			$JSONdata = Json_encode($FullMessageArray);
			$sql = "UPDATE `negotiation` SET `Message`='".$JSONdata."' WHERE  UserID='".$User1."' AND UserID2='".$User2."' OR UserID='".$User2."' AND UserID2='".$User1."'";
			$result = $this->connect()->query($sql) or die($this->connect()->error);  
		}               
	}

	public function InsertChat($ContractID,$User,$Message,$Type){
	    $Message = preg_replace('/(\'|&#0*39;)/', '', $Message);
		$Message = array("Message"=>$Message , "User"=>$User , "Time"=>Time() ,"Type"=>$Type);
		$sql = "SELECT * FROM contracts WHERE ContractID='".$ContractID."'";
		$result = $this->connect()->query($sql) or die($this->connect()->error);    
		if ($result->num_rows == 0) 
		{
			$FullMessageArray = array($Message);
			$JSONdata = Json_encode($FullMessageArray);
			$sql = "INSERT INTO `contracts`(`Message`) VALUES ('".$JSONdata."')";
			$result = $this->connect()->query($sql) or die($this->connect()->error); 
		}
		else{
			while($row = $result->fetch_assoc())
			{ 
			
				$FullMessageArray = Json_decode( $row["Message"],true);

			}
			array_push($FullMessageArray,$Message);
			$JSONdata = Json_encode($FullMessageArray);
			$sql = "UPDATE `contracts` SET `Message`='".$JSONdata."' WHERE ContractID='".$ContractID."'";
			$result = $this->connect()->query($sql) or die($this->connect()->error);  
		}               
	}
	public function RetrieveChat($ContractID){
	
		$sql = "SELECT * FROM contracts WHERE ContractID = '".$ContractID."'";

		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		$Msg = array();
		while($row = $result->fetch_assoc())
		{
			$Msg = json_decode($row['Message'],true);
			
				
		}

		if(sizeof($Msg)>0){
			for($x = 0; $x<sizeof($Msg);$x++){
				if($Msg [$x]['User']==$this->getUID()){
					echo'<div id="User1">';
				}
				else{
					echo'<div id="User2">';
				}
				if($Msg [$x]['Type']=="Admin"){
					echo'<span class="author">'.$Msg [$x]['User'].'(Administrator):</span>
						 <span class="messsage-text">'.$Msg [$x]['Message'].'</span></br>';
					echo'</div>';
				}
				else{
					echo'<span class="author">'.$Msg [$x]['User'].':</span>
						 <span class="messsage-text">'.$Msg [$x]['Message'].'</span></br>';
					echo'</div>';
				}
				
			}
		}
		
	}
	public function UpdateContract($offer,$daterequired,$paymentmode,$ContractID,$Type){

		$sql = " UPDATE `contracts` SET `Status`= '".$Type." has updated',`NewOffer`='".$offer."',`DateRequired`= '".$daterequired."',`Payment Mode`= '".$paymentmode."',`TotalAccepted`=  `TotalAccepted` -1 WHERE `ContractID`= '".$ContractID."' ";
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		$sql = " UPDATE `contracts` SET `TotalAccepted`=  0 WHERE `TotalAccepted`<0 ";
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
	}
	public function AcceptContract($ContractID,$Type){

		$sql = " UPDATE `contracts` SET `Status`= '".$Type." has accepted', `TotalAccepted`=  `TotalAccepted` +1 WHERE `ContractID`= '".$ContractID."' ";
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		
	}
	public function AcceptService($ContractID,$Type){

		$sql = " UPDATE `contracts` SET `Status`= '".$Type." has accepted service', `TotalAccepted`=  `TotalAccepted` +1 WHERE `ContractID`= '".$ContractID."' ";
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		
	}
	public function RejectContract($ContractID){

		$sql = " UPDATE `contracts` SET `Status`= 'Rejected', `TotalAccepted`= 0 WHERE `ContractID`= '".$ContractID."' ";
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		
	}
	public function RequestRefund($ContractID){

		$sql = " UPDATE `contracts` SET `Status`= 'Requested Refund', `TotalAccepted`= 0 ,`Transaction` = 'Transaction Declined' WHERE `ContractID`= '".$ContractID."' ";
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		
	}
	public function CancelOrder($ContractID){

		$sql = " UPDATE `contracts` SET `Status`= 'Order Cancelled', `TotalAccepted`= 0,`Transaction` = 'Transaction Declined'  WHERE `ContractID`= '".$ContractID."' ";
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
			$sql = "SELECT * FROM contracts  WHERE `ContractID`= '".$ContractID."' ";
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		while($row = $result->fetch_assoc())
		{	
			$Transferfrom = $row['SellerUserID'];
			$Transferto = $row['BuyerUserID'];
			$Amount = $row['NewOffer'];
			$Type = $row['Payment Mode'];
			$TransactionMessage = $row['Transaction'];
		}
		if($Type == "Half-STICoins")
		{
			$Amount = $Amount/2;
		}
		if($Type == "Full-STICoins"&& $TransactionMessage == "On-Going"){
			$Amount = $Amount;
		}
		$sql = "SELECT * FROM users WHERE UserID ='".$Transferto."'";
		$result = $this->connect()->query($sql) or die($this->connect()->error);    
		while($row = $result->fetch_assoc())
		{
			$TransfertoPubkey = $row['PublicKey'];
			
		}
		$sql = "SELECT * FROM users WHERE UserID ='".$Transferfrom."'";
		$result = $this->connect()->query($sql) or die($this->connect()->error);    
		while($row = $result->fetch_assoc())
		{
			
			$TransferfromPubkey = $row['PublicKey'];
			
		}
		$host    = "localhost";
		$port    = 8080;
		if($this->getUID()==$Transferfrom){
		date_default_timezone_set('UTC');
		$this->getEscrow();
		$textToEncrypt = $this->getEscrowPrivate();;
		$encryptionMethod = "AES-256-CBC";
		$secret = "My32charPasswordAndInitVectorStr";  //must be 32 char length
		$iv = substr($secret, 0, 16);
		$Amount = $Amount/$this->getCurrencyValue('SGD');
		$encryptedMessage = openssl_encrypt($textToEncrypt, $encryptionMethod, $secret,0,$iv);
		$arr = array('REQUEST' => "TransferSTICoins",'AMOUNT'=>$Amount,'BUYERPUBLICKEY'=>$TransferfromPubkey,'SELLERPUBLICKEY'=> $TransfertoPubkey ,'ESCROWPRIVATE'=>$encryptedMessage);
		$message = json_encode($arr);
		$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
		$result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");  
		if($result) { 
		socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
		$result = socket_read ($socket, 1024) or die("Could not read server response\n");
		}
		socket_close($socket);
		$raw_data = file_get_contents('http://localhost:3000/TransferAmount');
		$data = json_decode($raw_data, true);
		$sql = "SELECT * FROM contracts  WHERE `ContractID`= '".$ContractID."' ";
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		while($row = $result->fetch_assoc())
		{ 
			$TransactionData = $row['TransactionID'];
		}
		$TransactionData = json_decode($TransactionData, true);
		$NewData= array($data['TransactionHash'],date("d-m-Y"),$Amount,$Transferfrom,$Transferto);
		array_push($TransactionData,$NewData);
		$JData = json_encode($TransactionData);
		$sql = " UPDATE `contracts` SET `TransactionID`= '".$JData ."' WHERE `ContractID`= '".$ContractID."' ";
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		}
		else{
			sleep(4);
			
		}
		return;
			
		
	}
	public function UpdateStatusDeal($ContractID){
		$sql = " UPDATE `contracts` SET `Status`= 'Deal' , `Transaction` = 'On-Going', `TotalAccepted`= 0 WHERE `ContractID`= '".$ContractID."' ";
		$result = $this->connect()->query($sql) or die($this->connect()->error);
	}
	public function UpdateStatusComplete($ContractID){
			$sql = "SELECT * FROM contracts  WHERE `ContractID`= '".$ContractID."' ";
			$result = $this->connect()->query($sql) or die($this->connect()->error); 
			while($row = $result->fetch_assoc())
			{
				$Buyer = $row['BuyerUserID'];
				$Seller = $row['SellerUserID'];
			}
			$Data = array($Buyer,$Seller);
			$Jdata = json_encode($Data);
			$sql = " UPDATE `contracts` SET `Status`= 'Transaction Complete' ,`TransactionCloseDate`= '".date("Y-m-d")."',`RatingToken` = '".$Jdata."', `Transaction` = 'Complete' WHERE `ContractID`= '".$ContractID."' ";
			$result = $this->connect()->query($sql) or die($this->connect()->error);
		
	}
	public function CheckAccepted($ContractID){
		$sql = "SELECT * FROM contracts  WHERE `ContractID`= '".$ContractID."' ";
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		while($row = $result->fetch_assoc())
		{
			$NumOfAccepted = $row['TotalAccepted'];
			$Buyer = $row['BuyerUserID'];
		}
		return $NumOfAccepted ;
	}
	public function CheckServiceAccepted($ContractID){
		$sql = "SELECT * FROM contracts  WHERE `ContractID`= '".$ContractID."' ";
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		while($row = $result->fetch_assoc())
		{
			
			$NumOfAccepted = $row['TotalAccepted'];
			$Buyer = $row['BuyerUserID'];
			$Seller = $row['SellerUserID'];
		}
		$Data = array($Buyer,$Seller);
		$Jdata = json_encode($Data);
		
		return $NumOfAccepted ;
	}
	
	public function ToTransfer($ContractID){
		$sql = "SELECT * FROM contracts  WHERE `ContractID`= '".$ContractID."' ";
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		while($row = $result->fetch_assoc())
		{
			$Seller = $row['SellerUserID'];
			$Type = $row['Payment Mode'];
			$TransactionMessage = $row['Transaction'];
		}
	
		if($Seller==$this->getUID()){
		
			return True;
		}
		if($Type == "Half-STICoins"){
	
			return True;
		}
		if($Type == "Full-STICoins" && $TransactionMessage == "Negotiating"){
			
			return True;
		}
		if($Type == "Full-STICoins_Later" && $TransactionMessage == "Complete"){
				
				return True;
		}
		else{

			return False;
		}
		
		
	}
	public function AmountToTransfer($ContractID){
		$sql = "SELECT * FROM contracts  WHERE `ContractID`= '".$ContractID."' ";
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		while($row = $result->fetch_assoc())
		{
			
			$Amount = $row['NewOffer'];
			$Type = $row['Payment Mode'];
		}
		if($Type == "Half-STICoins"){
			$Amount= $Amount/2;
		}
		if($Type == "Full-STICoins" || $Type == "Full-STICoins_Later"){
			$Amount= $Amount;
		}
		return $Amount;
	}
	public function TransferAmountAcceptService($ContractID,$Amount){
		echo $Amount.'</br>';
		$sql = "SELECT * FROM contracts  WHERE `ContractID`= '".$ContractID."' ";
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		$Transferfrom = '';
		$Transferto = '';
		
		while($row = $result->fetch_assoc())
		{
			$Transferto = $row['SellerUserID'];
			$Transferfrom = $row['BuyerUserID'];
		}
	
		if($this->getUID()==$Transferfrom){
			
		$sql = "SELECT * FROM users WHERE UserID ='".$Transferto."'";
		$result = $this->connect()->query($sql) or die($this->connect()->error);    
		while($row = $result->fetch_assoc())
		{
			$TransfertoPubkey = $row['PublicKey'];
			
		}
		$sql = "SELECT * FROM users WHERE UserID ='".$Transferfrom."'";
		$result = $this->connect()->query($sql) or die($this->connect()->error);    
		while($row = $result->fetch_assoc())
		{
			
			$TransferfromPubkey = $row['PublicKey'];
			
		}
		$host    = "localhost";
		$port    = 8080;

		date_default_timezone_set('UTC');
		$this->getEscrow();
		$textToEncrypt = $this->getEscrowPrivate();
		$encryptionMethod = "AES-256-CBC";
		$secret = "My32charPasswordAndInitVectorStr";  //must be 32 char length
		$iv = substr($secret, 0, 16);
		$Amount = $Amount/$this->getCurrencyValue('SGD');
		echo $Amount;
		$encryptedMessage = openssl_encrypt($textToEncrypt, $encryptionMethod, $secret,0,$iv);
		$arr = array('REQUEST' => "TransferSTICoins",'AMOUNT'=>$Amount,'BUYERPUBLICKEY'=>$TransferfromPubkey,'SELLERPUBLICKEY'=> $TransfertoPubkey ,'ESCROWPRIVATE'=>$encryptedMessage);
		$message = json_encode($arr);
		$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
		$result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");  
		if($result) { 
		socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
		$result = socket_read ($socket, 1024) or die("Could not read server response\n");
		}
		socket_close($socket);
		$raw_data = file_get_contents('http://localhost:3000/TransferAmount');
		$data = json_decode($raw_data, true);
		if(empty($data)){
			return false;
		}
		$sql = "SELECT * FROM contracts  WHERE `ContractID`= '".$ContractID."' ";
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		while($row = $result->fetch_assoc())
		{ 
			$TransactionData = $row['TransactionID'];
		}
		$TransactionData = json_decode($TransactionData, true);
		$NewData= array($data['TransactionHash'],date("d-m-Y"),$Amount,$Transferfrom,$Transferto);
		array_push($TransactionData,$NewData);
		$JData = json_encode($TransactionData);
		$sql = " UPDATE `contracts` SET `TransactionID`= '".$JData ."' WHERE `ContractID`= '".$ContractID."' ";
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		$this->UpdateStatusComplete($_POST['CheckServiceAccepted']);	
		}
		return true;
		
	}
	public function TransferAmountAccept($ContractID,$Amount){
		echo $Amount.'</br>';
		$sql = "SELECT * FROM contracts  WHERE `ContractID`= '".$ContractID."' ";
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		$Transferfrom = '';
		$Transferto = '';
		
		while($row = $result->fetch_assoc())
		{
			$Transferto = $row['SellerUserID'];
			$Transferfrom = $row['BuyerUserID'];
		}
	
		if($this->getUID()==$Transferfrom){
			
		$sql = "SELECT * FROM users WHERE UserID ='".$Transferto."'";
		$result = $this->connect()->query($sql) or die($this->connect()->error);    
		while($row = $result->fetch_assoc())
		{
			$TransfertoPubkey = $row['PublicKey'];
			
		}
		$sql = "SELECT * FROM users WHERE UserID ='".$Transferfrom."'";
		$result = $this->connect()->query($sql) or die($this->connect()->error);    
		while($row = $result->fetch_assoc())
		{
			
			$TransferfromPubkey = $row['PublicKey'];
			
		}
		$host    = "localhost";
		$port    = 8080;

		date_default_timezone_set('UTC');
		$this->getEscrow();
		$textToEncrypt = $this->getEscrowPrivate();
		$encryptionMethod = "AES-256-CBC";
		$secret = "My32charPasswordAndInitVectorStr";  //must be 32 char length
		$iv = substr($secret, 0, 16);
		$Amount = $Amount/$this->getCurrencyValue('SGD');
		echo $Amount;
		$encryptedMessage = openssl_encrypt($textToEncrypt, $encryptionMethod, $secret,0,$iv);
		$arr = array('REQUEST' => "TransferSTICoins",'AMOUNT'=>$Amount,'BUYERPUBLICKEY'=>$TransferfromPubkey,'SELLERPUBLICKEY'=> $TransfertoPubkey ,'ESCROWPRIVATE'=>$encryptedMessage);
		$message = json_encode($arr);
		$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
		$result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");  
		if($result) { 
		socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
		$result = socket_read ($socket, 1024) or die("Could not read server response\n");
		}
		socket_close($socket);
		$raw_data = file_get_contents('http://localhost:3000/TransferAmount');
		$data = json_decode($raw_data, true);
		if(empty($data)){
			return false;
		}
		$sql = "SELECT * FROM contracts  WHERE `ContractID`= '".$ContractID."' ";
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		while($row = $result->fetch_assoc())
		{ 
			$TransactionData = $row['TransactionID'];
		}
		$TransactionData = json_decode($TransactionData, true);
		$NewData= array($data['TransactionHash'],date("d-m-Y"),$Amount,$Transferfrom,$Transferto);
		array_push($TransactionData,$NewData);
		$JData = json_encode($TransactionData);
		$sql = " UPDATE `contracts` SET `TransactionID`= '".$JData ."' WHERE `ContractID`= '".$ContractID."' ";
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		$this->UpdateStatusDeal($_POST['CheckAccepted']);	
		}
		return true;
	}
	public function TransferAmount($ContractID,$Amount){
		echo $Amount.'</br>';
		$sql = "SELECT * FROM contracts  WHERE `ContractID`= '".$ContractID."' ";
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		$Transferfrom = '';
		$Transferto = '';
		
		while($row = $result->fetch_assoc())
		{
			$Transferto = $row['SellerUserID'];
			$Transferfrom = $row['BuyerUserID'];
		}
	
		if($this->getUID()==$Transferfrom){
			
		$sql = "SELECT * FROM users WHERE UserID ='".$Transferto."'";
		$result = $this->connect()->query($sql) or die($this->connect()->error);    
		while($row = $result->fetch_assoc())
		{
			$TransfertoPubkey = $row['PublicKey'];
			
		}
		$sql = "SELECT * FROM users WHERE UserID ='".$Transferfrom."'";
		$result = $this->connect()->query($sql) or die($this->connect()->error);    
		while($row = $result->fetch_assoc())
		{
			
			$TransferfromPubkey = $row['PublicKey'];
			
		}
		$host    = "localhost";
		$port    = 8080;

		date_default_timezone_set('UTC');
		$this->getEscrow();
		$textToEncrypt = $this->getEscrowPrivate();
		$encryptionMethod = "AES-256-CBC";
		$secret = "My32charPasswordAndInitVectorStr";  //must be 32 char length
		$iv = substr($secret, 0, 16);
		$Amount = $Amount/$this->getCurrencyValue('SGD');
		echo $Amount;
		$encryptedMessage = openssl_encrypt($textToEncrypt, $encryptionMethod, $secret,0,$iv);
		$arr = array('REQUEST' => "TransferSTICoins",'AMOUNT'=>$Amount,'BUYERPUBLICKEY'=>$TransferfromPubkey,'SELLERPUBLICKEY'=> $TransfertoPubkey ,'ESCROWPRIVATE'=>$encryptedMessage);
		$message = json_encode($arr);
		$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
		$result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");  
		if($result) { 
		socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
		$result = socket_read ($socket, 1024) or die("Could not read server response\n");
		}
		socket_close($socket);
		$raw_data = file_get_contents('http://localhost:3000/TransferAmount');
		$data = json_decode($raw_data, true);
		$sql = "SELECT * FROM contracts  WHERE `ContractID`= '".$ContractID."' ";
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		while($row = $result->fetch_assoc())
		{ 
			$TransactionData = $row['TransactionID'];
		}
		$TransactionData = json_decode($TransactionData, true);
		$NewData= array($data['TransactionHash'],date("d-m-Y"),$Amount,$Transferfrom,$Transferto);
		array_push($TransactionData,$NewData);
		$JData = json_encode($TransactionData);
		$sql = " UPDATE `contracts` SET `TransactionID`= '".$JData ."' WHERE `ContractID`= '".$ContractID."' ";
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		if(!empty($TransactionData)){
			return true;
		}
		else{
			return false;
		}
		
		}
			return true;
		
	}
	
		public function getEscrow(){

		$sql = "SELECT * FROM users where `AccountType` = 'Escrow' ORDER BY RAND() LIMIT 1" ;
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		while($row = $result->fetch_assoc())
		{ 
			
			$this->EscrowPrivate = $row["PrivateKey"];
			return $row["PublicKey"];

		}
		}
		
		public function getEscrowPrivate(){
			return $this->EscrowPrivate;
		}
		public function addNewReview($Review,$ProductID){
			$Review = filter_var($Review,FILTER_SANITIZE_SPECIAL_CHARS);
			$sql = "SELECT * FROM product WHERE ProductID='".$ProductID."'" ;
			$result = $this->connect()->query($sql) or die($this->connect()->error); 
			while($row = $result->fetch_assoc())
			{ 
				$Data = $row['Review'];
			}
			$Data = json_decode($Data, true);
			$NewData= array("Review"=>$Review, "ProductID"=>$ProductID, "User"=>$this->getUID(),"Date"=>date("Y-m-d"));
			array_push($Data,$NewData);
			$JData = json_encode($Data);
			$sql="UPDATE `product` SET `Review`='".$JData."' WHERE `ProductID`='".$ProductID."'";
			$result = $this->connect()->query($sql) or die($this->connect()->error);    
		}
		public function addNewUserReview($Review,$UserID){
			$Review = filter_var($Review,FILTER_SANITIZE_SPECIAL_CHARS);
			$sql = "SELECT * FROM users WHERE UserID='".$UserID."'" ;
			$result = $this->connect()->query($sql) or die($this->connect()->error); 
			while($row = $result->fetch_assoc())
			{ 
				$Data = $row['Review'];
			}
			$Data = json_decode($Data, true);
			$NewData= array("Review"=>$Review, "UserID"=>$UserID, "User"=>$this->getUID(),"Date"=>date("Y-m-d"));
			array_push($Data,$NewData);
			$JData = json_encode($Data);
			$sql="UPDATE `users` SET `Review`='".$JData."' WHERE `UserID`='".$UserID."'";
			$result = $this->connect()->query($sql) or die($this->connect()->error);    
		}
		public function RateUser($Rating,$UserID) {
		$sql = "SELECT * FROM users WHERE UserID='".$UserID."'" ;
			$result = $this->connect()->query($sql) or die($this->connect()->error); 
			while($row = $result->fetch_assoc())
			{ 
				$Data = $row['Rating'];
			}
			$Data = json_decode($Data, true);
			$Data['Rating'] = ($Rating + $Data['Rating'])/2;
			$Data['NumOfReviewers'] = 	$Data['NumOfReviewers'] +1;
			$JData = json_encode($Data);
			$sql="UPDATE `users` SET `Rating`='".$JData."' WHERE `UserID`='".$UserID."'";
			$result = $this->connect()->query($sql) or die($this->connect()->error); 
		}
		public function PostContractRateBuyer($Rating,$UserID,$Review,$ReviewProduct,$ProductID){
			$this->RateUser($Rating,$UserID);
			if(!empty($Review)){
				$this->addNewUserReview($Review,$UserID);
			}
			if(!empty($ReviewProduct)){
				$this->addNewReview($ReviewProduct,$ProductID);
			}
		}
		public function PostContractRateSeller($Rating,$UserID,$Review){
			$this->RateUser($Rating,$UserID);
			if(!empty($Review)){
				$this->addNewUserReview($Review,$UserID);
			}
		}
		public function RemoveProduct($ProductID){
			
			$sql="DELETE FROM product WHERE ProductID='$ProductID'";
			$result = $this->connect()->query($sql) or die($this->connect()->error);  
		}
		public function UnreportProduct($ProductID){
			$sql="UPDATE `product` SET `Reported`= '0' WHERE ProductID='$ProductID'";
			$result = $this->connect()->query($sql) or die($this->connect()->error);  
		}
		public function ReportProduct($ProductID){
			$sql="UPDATE `product` SET `Reported`=`Reported`+1 WHERE ProductID='$ProductID'";
			$result = $this->connect()->query($sql) or die($this->connect()->error);  
		}
		public function UnreportUser($UID){
			$sql="UPDATE `users` SET `Reported`= '0' WHERE UserID='$UID'";
			$result = $this->connect()->query($sql) or die($this->connect()->error);  
		}
		public function ReportUser($UID){
			$sql="UPDATE `users` SET `Reported`=`Reported`+1 WHERE UserID='$UID'";
			$result = $this->connect()->query($sql) or die($this->connect()->error);  
		}
		public function UnreportContract($CID){
			$sql="UPDATE `contracts` SET `Reported`= '0' WHERE ContractID='$CID'";
			$result = $this->connect()->query($sql) or die($this->connect()->error);  
		}
		public function ReportContract($CID){
			$sql="UPDATE `contracts` SET `Reported`=`Reported`+1 WHERE ContractID='$CID'";
			$result = $this->connect()->query($sql) or die($this->connect()->error);  
		}
		public function UnlistProduct($ProductID){
			
			$sql="UPDATE `product` SET `Status`='Unlisted' WHERE ProductID='$ProductID'";
			$result = $this->connect()->query($sql) or die($this->connect()->error);  
		}
		
		public function checkAccountInNetwork($WalletPubKey){
			$host    = "localhost";
			$port    = 8080;
			$arr = array('REQUEST' => "CheckAccount",'PUBKEY' =>$WalletPubKey);
			$message = json_encode($arr);
			$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
			$result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");  
			if($result) { 
			socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
			$result = socket_read ($socket, 1024) or die("Could not read server response\n");
			}
			socket_close($socket);
			$raw_data = file_get_contents('http://localhost:3001/CheckAccount');
			$data = json_decode($raw_data, true);
			if ($data['RESPONSE']){
				return true;
				
			}
			else{
				return false;
			}
			
			
		}
		
		public function ConvertToFIATCurrency($amount,$WalletPubkey,$WalletPrivateKey){
		$host    = "localhost";
		$port    = 8080;
		date_default_timezone_set('UTC');
		$textToEncrypt = $WalletPrivateKey;
		$encryptionMethod = "AES-256-CBC";
		$secret = "My32charPasswordAndInitVectorStr";  //must be 32 char length
		$iv = substr($secret, 0, 16);
		$encryptedMessage = openssl_encrypt($textToEncrypt, $encryptionMethod, $secret,0,$iv);
		$arr = array('REQUEST' => "ConvertToSTICoin",'AMOUNT'=>$amount,'WALLETPUBKEY'=>$WalletPubkey,'WALLETPRIVATEKEY'=>$encryptedMessage,'ESCROWACCOUNT'=> $this->getEscrow(),'PUBKEY' =>$this->getPubKey());
		$message = json_encode($arr);
		$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
		$result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");  
		if($result) { 
		socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
		$result = socket_read ($socket, 1024) or die("Could not read server response\n");
		}
		socket_close($socket);
		$raw_data = file_get_contents('http://localhost:3002/ConvertToSTICoin');
		$data = json_decode($raw_data, true);
		if($data['Transaction']== "Success"){
			return $data['Transaction'];
		}
		else{
			return $data['Transaction'];
		}
	}
		public function ConvertToETH($amount,$WalletPubkey){
		$host    = "localhost";
		$port    = 8080;
		$amount = $amount/$this->getCurrencyValue('SGD');
		date_default_timezone_set('UTC');
		$this->getEscrow();
		$textToEncrypt = $this->getEscrowPrivate();
		$encryptionMethod = "AES-256-CBC";
		$secret = "My32charPasswordAndInitVectorStr";  //must be 32 char length
		$iv = substr($secret, 0, 16);
		$encryptedMessage = openssl_encrypt($textToEncrypt, $encryptionMethod, $secret,0,$iv);
		$arr = array('REQUEST' => "ConvertToETH",'AMOUNT'=>$amount,'WALLETPUBKEY'=>$WalletPubkey,'ESCROWPRIVATE'=> $encryptedMessage ,'PUBKEY' =>$this->getPubKey());
		$message = json_encode($arr);
		$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
		$result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");  
		if($result) { 
		socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
		$result = socket_read ($socket, 1024) or die("Could not read server response\n");
		}
		socket_close($socket);
		$raw_data = file_get_contents('http://localhost:3003/ConvertToETH');
		$data = json_decode($raw_data, true);
		if($data['Transaction']== "Success"){
			return $data['Transaction'];
		}
		else{
			return $data['Transaction'];
		}
	}
	
	public function ListProduct($Name,$Category,$Description,$Cost,$Caption,$File){
			$Name = filter_var($Name,FILTER_SANITIZE_SPECIAL_CHARS);
			$Description = filter_var($Description,FILTER_SANITIZE_SPECIAL_CHARS);
			$Caption = filter_var($Caption,FILTER_SANITIZE_SPECIAL_CHARS);
			
			while(true){					
					$ProductID = chr(rand(97,122)).chr(rand(97,122)).chr(rand(97,122)).str_pad(rand(0000,9999),4,0,STR_PAD_LEFT). substr(rand(0000,9999), 2, 4);
					$result = $this->connect()->query("SELECT count(*) as 'c' FROM product WHERE ProductID='".$ProductID."'");
					$count = $result->fetch_object()->c;
					if ($count==0)
					  {
						break;
					  }
				}
	
	
			 mysqli_query($this->connect(),"INSERT INTO `product` (`ProductID`, `ProductCategory`, `ProductDescription`, `ProductCaption`, `ProductInitialPrice`, `ProductName`,`SellerUserID`,`Image`,`DateOfListing`) VALUES ('".$ProductID."','".$Category."','".$Description."','".$Caption."','".$Cost."','".$Name."','".$this->getUID()."','".$File."','".time()."')") or die(mysqli_error($this->connect()));
	 	
				return $ProductID;
	}
		public function UpdateProduct($ProductID,$Name,$Category,$Description,$Cost,$Caption,$File){
				$Name = filter_var($Name,FILTER_SANITIZE_SPECIAL_CHARS);
				$Category = filter_var($Category,FILTER_SANITIZE_SPECIAL_CHARS);
				$Description = filter_var($Description,FILTER_SANITIZE_SPECIAL_CHARS);
				$Caption = filter_var($Caption,FILTER_SANITIZE_SPECIAL_CHARS);
				$sql = "UPDATE `product` SET `ProductName`= '$Name',`ProductCategory`='$Category',`ProductDescription`='$Description',`ProductCaption`='$Caption',`ProductInitialPrice`='$Cost',`Image`='$File' WHERE `ProductID` = '$ProductID'";
				$result = $this->connect()->query($sql) or die( $this->connect()->error);    	
			
				return true;
	}
	public function EditProfileValidate($Email,$FName,$LName,$ContactNumber,$DispName,$Address,$ProfilePicCurrent,$ProfilePicDest){
		$Email = preg_replace('/(\'|&#0*39;)/', '', $Email);
		$FName = preg_replace('/(\'|&#0*39;)/', '', $FName);
		$LName = preg_replace('/(\'|&#0*39;)/', '', $LName);
		$DispName = preg_replace('/(\'|&#0*39;)/', '', $DispName);
		$Address = preg_replace('/(\'|&#0*39;)/', '', $Address);
		$sql = "SELECT * FROM users WHERE Email='".$Email."'";
		$result = $this->connect()->query($sql) or die($this->connect()->error);    
		if ($result->num_rows > 1) 
		{
			return "Email error";
			
		}
		$ID = $this->getUID();
		$sql = "UPDATE `users` SET `DisplayName`= '$DispName',`Email`= '$Email',`FirstName`= '$FName',`LastName`='$LName',`ContactNumber`='$ContactNumber',`Address`= '$Address', `ProfilePicture`='$ProfilePicDest' WHERE `UserID` = '$ID' ";
		$result = $this->connect()->query($sql) or die( $this->connect()->error);    	
		echo $this->connect()->error;
		move_uploaded_file($ProfilePicCurrent, $ProfilePicDest);
		if($this->ProfilePic!="profilepictures/default.jpg"){
			unlink($this->ProfilePic);
		}
		return "validated";
	}
	
	public function ChangePasswordValidate($Pass,$NewPass){
			$Pass = preg_replace('/(\'|&#0*39;)/', '', $Pass);
			$sql = "SELECT Password FROM users WHERE UserID='".$this->getUID()."'" ;
			$result = $this->connect()->query($sql) or die($this->connect()->error); 
			$validated = false;
			while($row = $result->fetch_assoc()){ 
				if(Password_verify($Pass,$row["Password"]))
				{	$validated = true;
					
				}
				
			}	
			if($validated)
			{
				$Hpass = password_hash($NewPass, PASSWORD_DEFAULT);
				$ID = $this->getUID();
				$sql = "UPDATE `users` SET `Password`= '$Hpass' WHERE `UserID` = '$ID' ";
				$result = $this->connect()->query($sql) or die( $this->connect()->error);   
			
				return "Validated";
			}
			else{
				return "Wrong Password";
			}
	}
}

class Admin extends StandardUser 
{
	
	
	
	public function __construct($Object){
		$this->UID = $Object->getUID();
		$this->DisplayName =  $Object->getDisplayName();
		$this->PubKey =  $Object->getPubKey();
		$this->Email = $Object->getEmail();
		$this->FirstName =  $Object->getFirstName();
		$this->LastName =  $Object->getLastName();
		$this->DOB =  $Object->getDOB();
		$this->ContactNumber =  $Object->getContactNumber();
		$this->Address =  $Object->getAddress();
		$this->AccountType =  $Object->getAccountType();
		$this->AccountBalance = $Object->getAccountBalance();
		$this->ProfilePic = $Object->ProfilePic;
		$this->Reported = $Object->Reported;
	
	}
	public function HaltTransaction($ContractID){
		$sql = " UPDATE `contracts` SET `Status`='Admin has halted this transaction' WHERE `ContractID`= '".$ContractID."' ";
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
	}
	public function ResumeTranasction($ContractID,$Transaction){
		if($Transaction=="On-Going"){
			$sql = " UPDATE `contracts` SET `Status`='Deal' WHERE `ContractID`= '".$ContractID."' ";
		}
		if($Transaction=="Negotiating"){
			$sql = " UPDATE `contracts` SET `Status`='Negotiating' WHERE `ContractID`= '".$ContractID."' ";
		}
		if($Transaction=="Complete"){
			$sql = " UPDATE `contracts` SET `Status`='Transaction Complete' WHERE `ContractID`= '".$ContractID."' ";
		}
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
	}
	public function ListOfAdminContracts($ContractType){
	if($ContractType=="All"){
	$sql = "SELECT * FROM contracts ORDER BY TransactionOpenDate" ;
	}
	if($ContractType=="Overdue contracts"){
	$sql = "SELECT * FROM `contracts` WHERE DATEDIFF(`DateRequired`,now()) < 0 OR DATEDIFF(`DateRequired`,`TransactionOpenDate`) > 3 AND `Transaction` != 'Complete' " ;
	}
	if($ContractType=="Requested Refund"){

	$sql = "SELECT * FROM contracts WHERE `Status` = 'Requested Refund' ORDER BY TransactionOpenDate" ;
	}
	$result = $this->connect()->query($sql) or die($this->connect()->error); 
			
	if ($result->num_rows == 0) 
		{
			return false;

		}
	$ArrayOfContracts = array();
	while($row = $result->fetch_assoc())
	{
		array_push($ArrayOfContracts,$row['ContractID']);
		
			
	}
	return $ArrayOfContracts;
	}
	public function Refund_Admin($ContractID){
		$sql = "SELECT * FROM contracts  WHERE `ContractID`= '".$ContractID."' ";
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		$Transferfrom = '';
		$Transferto = '';
		while($row = $result->fetch_assoc())
		{
			$Transferfrom = $row['SellerUserID'];
			$Transferto = $row['BuyerUserID'];
			$Amount = $row['NewOffer'];
		}
		
		$sql = "SELECT * FROM users WHERE UserID ='".$Transferto."'";
		$result = $this->connect()->query($sql) or die($this->connect()->error);    
		while($row = $result->fetch_assoc())
		{
			$TransfertoPubkey = $row['PublicKey'];
			
		}
		$sql = "SELECT * FROM users WHERE UserID ='".$Transferfrom."'";
		$result = $this->connect()->query($sql) or die($this->connect()->error);    
		while($row = $result->fetch_assoc())
		{
			
			$TransferfromPubkey = $row['PublicKey'];
			
		}
		$host    = "localhost";
		$port    = 8080;

		date_default_timezone_set('UTC');
		$this->getEscrow();
		$textToEncrypt = $this->getEscrowPrivate();;
		$encryptionMethod = "AES-256-CBC";
		$secret = "My32charPasswordAndInitVectorStr";  //must be 32 char length
		$iv = substr($secret, 0, 16);
		$Amount = $Amount/$this->getCurrencyValue('SGD');
		$encryptedMessage = openssl_encrypt($textToEncrypt, $encryptionMethod, $secret,0,$iv);
		$arr = array('REQUEST' => "TransferSTICoins",'AMOUNT'=>$Amount,'BUYERPUBLICKEY'=>$TransferfromPubkey,'SELLERPUBLICKEY'=> $TransfertoPubkey ,'ESCROWPRIVATE'=>$encryptedMessage);
		$message = json_encode($arr);
		$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
		$result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");  
		if($result) { 
		socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
		$result = socket_read ($socket, 1024) or die("Could not read server response\n");
		}
		socket_close($socket);
		$raw_data = file_get_contents('http://localhost:3000/TransferAmount');
		$data = json_decode($raw_data, true);
		$sql = "SELECT * FROM contracts  WHERE `ContractID`= '".$ContractID."' ";
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		while($row = $result->fetch_assoc())
		{ 
			$TransactionData = $row['TransactionID'];
		}
		$TransactionData = json_decode($TransactionData, true);
		$NewData= array($data['TransactionHash'],date("d-m-Y"),$Amount,$Transferfrom,$Transferto);
		array_push($TransactionData,$NewData);
		$JData = json_encode($TransactionData);
		$sql = " UPDATE `contracts` SET `TransactionID`= '".$JData ."',`Status`='Refunded Transaction' ,`Transaction`='Complete',`TransactionCloseDate`='".date("Y-m-d")."'  WHERE `ContractID`= '".$ContractID."' ";
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		
		return;
	}
	public function ListOfUsers(){
		$sql = "SELECT * FROM users where AccountType = 'Standard'";
		$usersarray = array();
		$result = $this->connect()->query($sql) or die($this->connect()->error);    
		while($row = $result->fetch_assoc())
		{ 	
			array_push($usersarray,$row['UserID']);
		}
		
		return $usersarray;
	}
	public function ListOfEscrows(){
	
		$sql = "SELECT * FROM users where `AccountType` = 'Escrow'";
		$pubkeysarray = array();
		$result = $this->connect()->query($sql) or die($this->connect()->error);    
		while($row = $result->fetch_assoc())
		{ 	
			array_push($pubkeysarray,$row['PublicKey']);
		}
		return $pubkeysarray;
	}
	public function ListOfReportedProducts(){
		
		$sql = "SELECT * FROM product where `Reported` >0 ORDER BY `Reported` DESC";
		$arrayret = array();
		$result = $this->connect()->query($sql) or die($this->connect()->error);    
		while($row = $result->fetch_assoc())
		{ 	
			array_push($arrayret,$row['ProductID']);
		}
		return $arrayret;
		
	}
	public function ListOfReportedUsers(){
		
		$sql = "SELECT * FROM users where `Reported` >0 ORDER BY `Reported` DESC";
		$arrayret = array();
		$result = $this->connect()->query($sql) or die($this->connect()->error);    
		while($row = $result->fetch_assoc())
		{ 	
			array_push($arrayret,$row['UserID']);
		}
		return $arrayret;
		
	}
	public function ListOfReportedContracts(){
		
		$sql = "SELECT * FROM contracts where `Reported` >0 ORDER BY `Reported` DESC";
		$arrayret = array();
		$result = $this->connect()->query($sql) or die($this->connect()->error);    
		while($row = $result->fetch_assoc())
		{ 	
			array_push($arrayret,$row['ContractID']);
		}
		return $arrayret;
		
	}
	public function suspendUser($ID,$SuspensionDate){
		$data = array('Suspended',$SuspensionDate);
		$data = json_encode($data);
		$sql = "UPDATE `users` SET `Status`= '$data' WHERE `UserID` = '$ID' ";
		$result = $this->connect()->query($sql) or die( $this->connect()->error);    	
	}
	public function Removestatus($ID){
		$data = array('Normal','');
		$data = json_encode($data);
		$sql = "UPDATE `users` SET `Status`= '$data' WHERE `UserID` = '$ID' ";
		$result = $this->connect()->query($sql) or die( $this->connect()->error);
	}
	public function Ban($ID){
		$data = array('Banned','');
		$data = json_encode($data);
		$sql = "UPDATE `users` SET `Status`= '$data' WHERE `UserID` = '$ID' ";
		$result = $this->connect()->query($sql) or die( $this->connect()->error);
	}
	public function MakeAdmin($ID){
		$sql = "UPDATE `users` SET `AccountType`='Administrator' WHERE `UserID` = '$ID' ";
		$result = $this->connect()->query($sql) or die( $this->connect()->error);
	}
	public function RemoveEscrow($pubkey){
		$sql = "DELETE FROM users WHERE PublicKey='$pubkey'";
		$result = $this->connect()->query($sql) or die( $this->connect()->error);
		
	}
	public function AddEscrow($pubkey,$privatekey){
		$privatekey = preg_replace('/(\'|&#0*39;)/', '', $privatekey);
		while(true){					
					$UserID = "Escrow". substr(rand(0000,9999), 2, 4);
					$result = $this->connect()->query("SELECT count(*) as 'c' FROM users WHERE UserID='".$UserID."'");
					$count = $result->fetch_object()->c;
					if ($count==0)
					  {
						break;
					  }
				}
				$sql = "INSERT INTO users (UserID,PublicKey,PrivateKey,AccountType)VALUES('".$UserID."','".$pubkey."','".$privatekey."','Escrow' )";
				$result = $this->connect()->query($sql) or die( $this->connect()->error);    	
				
	}
	
}