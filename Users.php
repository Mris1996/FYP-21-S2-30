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
				$sql = "SELECT * FROM users WHERE UserID='".$ID."'" ;
				$result = $this->connect()->query($sql) or die($this->connect()->error); 
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
				}
				return true;
			}
			else{
				return false;
			}
		}
		
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
		$raw_data = file_get_contents('http://10.148.0.3:3000/getBalance');
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
		$raw_data = file_get_contents('http://10.148.0.3:3000/GetNewAccount');
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
		
	
		//$sql = "INSERT INTO users (UserID,FirstName,LastName,Email,ContactNumber,Password,AccountType,DisplayName,Address,DateOfBirth,PublicKey,PrivateKey)VALUES('".$ID."','".$FName."','".$LName."','".$Email."' ,'".$ContactNumber."','".$HPass."','".$Type."','".$DispName."','".$Address."','".date('d/m/Y', strtotime($DOB))."','".$this->PubKey."','".$this->PrivateKey."' )";
		//$result = $this->connect()->query($sql) or die( $this->connect()->error);    	
		//echo $this->connect()->error;
		
		return "validated";
	}
	
	public function getUID(){
		return 	$this->UID;
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
					  <hr>
					  <p>Name: '.$row["ProductName"].'</p>
					  <p>Category: '.$row["ProductCategory"].'</p>
					  <p>Status: '.$row["Status"].'</p><hr>
					  <p style="text-align:center">'.$row["ProductCaption"].'</p>
					  <p style="text-align:center">Description:'.$row["ProductDescription"].'</p><hr>
					  <h2 style="text-align:center">Initital Cost: '.$row["ProductInitialPrice"].'</h2></div>';
					$Data = $row['Review'];
		
		
		
			}
			echo 
			'';
			if($Data!=null){
			$Data = json_decode($Data, true);
			for($i =0;$i<sizeof($Data);$i++){
			
			echo'
			<div class="media border p-3" style="margin-top:5px;width:40%;margin:auto;">
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
	public function ViewAllProduct($sortby,$Order){
		
	
			$sql = "SELECT * FROM product ORDER BY $sortby $Order" ;
			$result = $this->connect()->query($sql) or die($this->connect()->error); 
			while($row = $result->fetch_assoc())
			{ 
			echo'
			<div class="container">
			<img src="'.$row["Image"].'" class="image" style="width:100%">
			<div class="middle">
			<div class="text">Product Name:'.$row["ProductName"].'</div>
			<div class="text">Category:'.$row["ProductCategory"].'</div>
			<div class="text">Date Listed:<i>'.date('d-m-Y',strtotime($row["DateOfListing"])).'</i></div>
			<div class="text">Initial Price:'.$row["ProductInitialPrice"].'</div>
			<form action="Product.php?ID='.$row["ProductID"].'" method="post">
			<input type="submit" value="Product Page"/>
			</form>
			</div>
			</div>';
		
			}
			
		
			
	}
	
	

}


class StandardUser extends BaseUser 
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
			$raw_data = file_get_contents('http://10.148.0.3:3000/CheckAccount');
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
		$raw_data = file_get_contents('http://10.148.0.3:3000/ConvertToSTICoin');
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
		$raw_data = file_get_contents('http://10.148.0.3:3000/ConvertToETH');
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
				
				$sql = "INSERT INTO `product`(`ProductID`, `ProductCategory`, `ProductDescription`, `ProductCaption`, `ProductInitialPrice`, `Image`,  `ProductName`,`SellerUserID`) VALUES ('".$ProductID."','".$Category."','".$Description."','".$Caption."','".$Cost."','".$File."','".$Name."','".$this->getUID()."')";
				$result = $this->connect()->query($sql) or die( $this->connect()->error);    	
	
				return $ProductID;
	}

}

class Admin extends BaseUser 
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
	
	public function connect(){
		$servername= "localhost";
		$username = "root";
		$password = "";
		$dbname = "music-to-go";
		$conn = new mysqli($servername, $username, $password, $dbname);
		return $conn;
		
	}

	
}