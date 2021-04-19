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


	
	

}


class StandardUser extends BaseUser 
{


	public function __construct($Object){
	
		$this->UID = $Object->getUID();
		$this->DisplayName =  $Object->getDisplayName();
		$this->PubKey =  $Object->getDisplayName();
		$this->Email = $Object->getEmail();
		$this->FirstName =  $Object->getFirstName();
		$this->LastName =  $Object->getLastName();
		$this->DOB =  $Object->getDOB();
		$this->ContactNumber =  $Object->getContactNumber();
		$this->Address =  $Object->getAddress();
		$this->AccountType =  $Object->getAccountType();
		$this->AccountBalance = $Object->getAccountBalance();
		
	}
		public function ConvertToSTICOIN($amount,$WalletPubkey,$WalletPrivateKey){
		$host    = "localhost";
		$port    = 8080;
		$arr = array('REQUEST' => "ConvertToSTICoin",'PUBKEY' =>$this->getPubKey(),'AMOUNT'=>$amount,'WALLETPUBKEY'=>$WalletPubkey,'WALLETPRIVATEKEY'=>$WalletPrivateKey);
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
		$this->AccountBalance  =  $data['sticoin'];
		
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