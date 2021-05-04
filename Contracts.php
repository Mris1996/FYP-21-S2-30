<?php
class Contracts
{

	public $TransactionID;							

	public $TransactionOpenDate;				

	public $TransactionCloseDate;				

	public $ContractID;				

	public $BuyerUserID;		

	public $SellerUserID;

	public $ProductID;			

	public $DateRequired;			

	public $InitialOffer;				

	public $NewOffer;				
	
	public $Status;
	
	public $PaymentMode;
	
	public $TotalAccepted;
	
	public $Transaction;
	
	public function connect(){
		$servername= "localhost";
		$username = "root";
		$password = "";
		$dbname = "sticdb";
		$conn = new mysqli($servername, $username, $password, $dbname);
		return $conn;
		
	}
	
	public function InitialiseContract($ContractID)
	{
		$sql = "SELECT * FROM contracts WHERE ContractID ='".$ContractID."'" ;
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		if ($result->num_rows == 0) 
			{
				return false;

			}	
		while($row = $result->fetch_assoc())
		{ 	
			
			$this->TransactionID = $row["TransactionID"];		
 
			$this->TransactionOpenDate	= $row["TransactionOpenDate"];	

			$this->TransactionCloseDate	= $row["TransactionCloseDate"];			

			$this->ContractID  = $row["ContractID"];		

			$this->BuyerUserID = $row["BuyerUserID"];

			$this->SellerUserID	= $row["SellerUserID"];

			$this->ProductID  = $row["ProductID"];

			$this->DateRequired  = $row["DateRequired"];			

			$this->InitialOffer	 = $row["InitialOffer"];		

			$this->NewOffer = $row["NewOffer"];		
			
			$this->Status = $row["Status"];	

			$this->PaymentMode = $row["Payment Mode"];	
			
			$this->TotalAccepted = $row["TotalAccepted"];	
			
			$this->Transaction = $row["Transaction"];	
	
	}

		return true;
	}

}
	
?>