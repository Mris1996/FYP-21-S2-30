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
	public $results_per_page = 12;  
	public function __construct($Operation)
	{
		if($Operation == "SignUp"){
			$this->createEthereumAccount();
		}
	}
	
	public function LoginValidate($ID,$Pass)
	{	$ID = filter_var($ID, FILTER_SANITIZE_STRING);
		$Pass = filter_var($Pass, FILTER_SANITIZE_STRING);
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
				
				return true;
			}
			else{
				return false;
			}
		}
		
	}
	public function ForgetPassword ($Email){
		$sql = "SELECT * FROM users WHERE Email='".$Email."'";
		$result = $this->connect()->query($sql) or die($this->connect()->error);  
		$ID = chr(rand(97,122)).chr(rand(97,122)).chr(rand(97,122)).chr(rand(97,122)).chr(rand(97,122)).chr(rand(97,122)).str_pad(rand(0000,9999),4,0,STR_PAD_LEFT). substr(rand(0000,9999), 2, 4);
						
		if ($result->num_rows == 0) 
		{
			return "Email error";
			
		}
		 $header = "From:fyp21s230@gmail.com \r\n";
         $header .= "MIME-Version: 1.0\r\n";
         $header .= "Content-type: text/html\r\n";
		$msg = "You have 5 minutes to reset your password before the link expires.Click on the link below to reset your password\n <a href ='http://localhost/STIC/ResetPassword.php?ID=".$ID."'>www.example.com</a>";
		$msg = wordwrap($msg,70);
		mail($Email,"Reset Password",$msg,$header);
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
		$raw_data = file_get_contents('http://localhost:3000/getBalance');
		$data = json_decode($raw_data, true);
		return $data['sticoin_balance'];
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
		$raw_data = file_get_contents('http://localhost:3000/GetNewAccount');
		$data = json_decode($raw_data, true);
		$this->PubKey =  $data['pubkey'];
		$this->PrivateKey = $data['privatekey'];
		
	}
	public function SignUpValidate($ID,$Email,$Pass,$FName,$LName,$ContactNumber,$DispName,$DOB,$Address){
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
		
	
		$sql = "INSERT INTO users (UserID,FirstName,LastName,Email,ContactNumber,Password,AccountType,DisplayName,Address,DateOfBirth,PublicKey,PrivateKey)VALUES('".$ID."','".$FName."','".$LName."','".$Email."' ,'".$ContactNumber."','".$HPass."','".$Type."','".$DispName."','".$Address."','".date('d/m/Y', strtotime($DOB))."','".$this->PubKey."','".$this->PrivateKey."' )";
		$result = $this->connect()->query($sql) or die( $this->connect()->error);    	
		echo $this->connect()->error;
		
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
	public function ViewProduct($ProductID){
			$ID = trim($ProductID);
			$sql = "SELECT * FROM product WHERE ProductID='".$ProductID."'" ;
			$result = $this->connect()->query($sql) or die($this->connect()->error); 
			while($row = $result->fetch_assoc())
			{ 
				echo'
					
					<div class="card">
					  <img src="'.$row["Image"].'" style="width:50%;margin:auto">
					  <h2 style="text-align:center">'.$ID.'</h2>
					  <hr style="background-color:white">
					  <p>Seller:<a href="ProfilePage.php?ID='.$row["SellerUserID"].'">'.$row["SellerUserID"].'</a></p>
					  <p>Name: '.$row["ProductName"].'</p>
					  <p>Category: '.$row["ProductCategory"].'</p>
					  <p>Status: '.$row["Status"].'</p>
					  <hr style="background-color:white">
					  <p style="text-align:center">'.$row["ProductCaption"].'</p>
					  <p style="text-align:center">Description:'.$row["ProductDescription"].'</p><hr>
					  <h2 style="text-align:center">Initital Cost: '.$row["ProductInitialPrice"].'</h2></div>';
		
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
					$sql = "SELECT * FROM product ORDER BY $sortby $Order" ;
			}
			else{
					$sql = "SELECT * FROM product WHERE ProductCategory = '".$Category."' ORDER BY $sortby $Order" ;
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
					$sql = "SELECT * FROM product ORDER BY $sortby $Order LIMIT " . $page_first_result . ',' . $this->results_per_page; 
			}
			else{
					$sql = "SELECT * FROM product WHERE ProductCategory = '".$Category."' ORDER BY $sortby $Order LIMIT " . $page_first_result . ',' . $this->results_per_page; 
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
			<div class="text">Date Listed:<i>'.date('d-m-Y',strtotime($row["DateOfListing"])).'</i></div>
			<div class="text">Initial Price:'.$row["ProductInitialPrice"].'</div>
			<form action="ProductPage.php?ID='.$row["ProductID"].'" method="post"></br>
			<input type="submit" value="Product Page"/>
			</form>
			</div>
			</div></div>';
		
			}
			echo'<div class = "pagination" >';			
			echo'<b style="bottom: 20;">Page</b></BR></BR>';
			echo '<a href = "'.$pagename.'?page=1">First </a>'; 
			for($page = 1; $page<= $number_of_page; $page++) { 
				if($page==1){

				echo '<a href = "'.$pagename.'?page=' . $page . '">' . $page . ' </a>';  
				
				}
				else{
				echo '<a href = "'.$pagename.'?page=' . $page . '">' . $page . ' </a>';  
				}
			} 
			echo '<a href = "'.$pagename.'?page=' . $number_of_page . '">Last </a>';  
			echo'</div>';
		
			
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
			<div class="text">Date Listed:<i>'.date('d-m-Y',strtotime($row["DateOfListing"])).'</i></div>
			<div class="text">Initial Price:'.$row["ProductInitialPrice"].'</div>
			<form action="ProductPage.php?ID='.$row["ProductID"].'" method="post"></br>
			<input type="submit" value="Product Page"/>
			</form>
			</div>
			</div>';
		
			}	
			echo'<div class = "pagination" >';	
			echo'<b style="bottom: 20;">Page</b></BR>';
			echo '<a href = "SearchPage.php?page=1">First </a>'; 
			for($page = 1; $page<= $number_of_page; $page++) { 
				if($page==1){

				echo '<a href = "SearchPage.php?page=' . $page . '">' . $page . ' </a>';  
				
				}
				else{
				echo '<a href = "SearchPage.php?page=' . $page . '">' . $page . ' </a>';  
				}
			} 
			echo '<a href = "SearchPage.php?page=' . $number_of_page . '">Last </a>';  
			echo'</div>';
		
			
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
			<div class="text">Date Listed:<i>'.date('d-m-Y',strtotime($row["DateOfListing"])).'</i></div>
			<div class="text">Initial Price:'.$row["ProductInitialPrice"].'</div>
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
	
	public function RetrieveChat($User1,$User2){
	
		$sql = "SELECT * FROM negotiation WHERE UserID='".$User1."' AND UserID2='".$User2."' OR UserID='".$User2."' AND UserID2='".$User1."'";

		$result = $this->connect()->query($sql) or die($this->connect()->error); 

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
				echo'<span class="author">'.$Msg [$x]['User'].':</span>
				<span class="messsage-text">'.$Msg [$x]['Message'].'</span></br>';
		
				echo'</div>';
			}
		}
		
	}
	public function InsertChat($User1,$User2,$Message){

		$Message = array("Message"=>$Message , "User"=>$User1 , "Time"=>Time());
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
		
		}
		public function getEscrow(){
		$sql = "SELECT * FROM escrow" ;
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		while($row = $result->fetch_assoc())
		{ 
			return $row["PublicKey"];

		}
		}
		
		public function getEscrowPrivate(){
		$sql = "SELECT * FROM escrow" ;
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		while($row = $result->fetch_assoc())
		{ 
			return $row["PrivateKey"];

		}
		}
		public function addNewReview($Reviw,$ProductID){
			$sql = "SELECT * FROM product WHERE ProductID='".$ProductID."'" ;
			$result = $this->connect()->query($sql) or die($this->connect()->error); 
			while($row = $result->fetch_assoc())
			{ 
				$Data = $row['Review'];
			}
			$Data = json_decode($Data, true);
			$NewData= array("Review"=>$Reviw, "ProductID"=>$ProductID, "User"=>$this->getUID());
			array_push($Data,$NewData);
			$JData = json_encode($Data);
			$sql="UPDATE `product` SET `Review`='".$JData."' WHERE `ProductID`='".$ProductID."'";
			$result = $this->connect()->query($sql) or die($this->connect()->error);    
		}
		public function RemoveProduct($ProductID){
			
			$sql="DELETE FROM product WHERE ProductID='$ProductID'";
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
			$raw_data = file_get_contents('http://localhost:3000/CheckAccount');
			$data = json_decode($raw_data, true);
			if ($data['RESPONSE']){
				return true;
				
			}
			else{
				return false;
			}
			
			
		}
		public function ConvertToSTICOIN($amount,$WalletPubkey,$WalletPrivateKey){
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
		$raw_data = file_get_contents('http://localhost:3000/ConvertToSTICoin');
		$data = json_decode($raw_data, true);
		if($data['Transaction']== "Success"){
			$this->AccountBalance  = $data['sticoin'];
			return $data['Transaction'];
		}
		else{
			return $data['Transaction'];
		}
	}
		public function ConvertToETH($amount,$WalletPubkey){
		$host    = "localhost";
		$port    = 8080;
		date_default_timezone_set('UTC');
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
		$raw_data = file_get_contents('http://localhost:3000/ConvertToETH');
		$data = json_decode($raw_data, true);
		if($data['Transaction']== "Success"){
			$this->AccountBalance  = $data['sticoin'];
			return $data['Transaction'];
		}
		else{
			return $data['Transaction'];
		}
	}
	
	public function ListProduct($Name,$Category,$Description,$Cost,$Caption,$File){
			while(true){					
					$ProductID = chr(rand(97,122)).chr(rand(97,122)).chr(rand(97,122)).str_pad(rand(0000,9999),4,0,STR_PAD_LEFT). substr(rand(0000,9999), 2, 4);
					$result = $this->connect()->query("SELECT count(*) as 'c' FROM product WHERE ProductID='".$ProductID."'");
					$count = $result->fetch_object()->c;
					if ($count==0)
					  {
						break;
					  }
				}
	
				$sql = "SELECT * FROM `users`ORDER BY RAND()  LIMIT 1  ";
				$result = $this->connect()->query($sql) or die( $this->connect()->error);    	
					while($row = $result->fetch_assoc())
				{ 
					$User = $row['UserID'];
				}
				
			 mysqli_query($this->connect(),"INSERT INTO `product` (`ProductID`, `ProductCategory`, `ProductDescription`, `ProductCaption`, `ProductInitialPrice`, `ProductName`,`SellerUserID`,`Image` ) VALUES ('".$ProductID."','".$Category."','".$Description."','".$Caption."','".$Cost."','".$Name."','".$User."','".$File."')") or die(mysqli_error($this->connect()));
	 	
				return $ProductID;
	}
	public function UpdateProduct($ProductID,$Name,$Category,$Description,$Cost,$Caption,$File){
			
				$sql = "UPDATE `product` SET `ProductName`= '$Name',`ProductCategory`='$Category',`ProductDescription`='$Description',`ProductCaption`='$Caption',`ProductInitialPrice`='$Cost',`Image`='$File' WHERE `ProductID` = '$ProductID'";
				$result = $this->connect()->query($sql) or die( $this->connect()->error);    	
			
				return true;
	}
	public function EditProfileValidate($Email,$FName,$LName,$ContactNumber,$DispName,$Address){
	
		$sql = "SELECT * FROM users WHERE Email='".$Email."'";
		$result = $this->connect()->query($sql) or die($this->connect()->error);    
		if ($result->num_rows > 1) 
		{
			return "Email error";
			
		}
		$ID = $this->getUID();
		$sql = "UPDATE `users` SET `DisplayName`= '$DispName',`Email`= '$Email',`FirstName`= '$FName',`LastName`='$LName',`ContactNumber`='$ContactNumber',`Address`= '$Address' WHERE `UserID` = '$ID' ";
		$result = $this->connect()->query($sql) or die( $this->connect()->error);    	
		echo $this->connect()->error;
		
		return "validated";
	}
	
	public function ChangePasswordValidate($Pass,$NewPass){
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
				$Hpass = password_hash($Pass, PASSWORD_DEFAULT);
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
	
	}
	public function ListOfUsers(){
		$sql = "SELECT * FROM users where AccountType != 'Administrator'";
		$usersarray = array();
		$result = $this->connect()->query($sql) or die($this->connect()->error);    
		while($row = $result->fetch_assoc())
		{ 	
			array_push($usersarray,$row['UserID']);
		}
		
		return $usersarray;
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
	
	
}