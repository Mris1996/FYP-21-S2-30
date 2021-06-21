<?php
class Couriers
{

	public $CourierName;							

	public $DeliveryName;				

	public $Price;				

	public $EstimatedTime;				

	
	public function connect(){
		$servername= "localhost";
		$username = "root";
		$password = "";
		$dbname = "sticdb";
		$conn = new mysqli($servername, $username, $password, $dbname);
		return $conn;
		
	}
	
	public function InitialiseCouriers($CName)
	{
		$sql = "SELECT * FROM courier WHERE CourierName ='".$CName."'" ;
		$result = $this->connect()->query($sql) or die($this->connect()->error); 
		if ($result->num_rows == 0) 
			{
				return false;

			}	
		while($row = $result->fetch_assoc())
		{ 	
			
			$this->CourierName = $row["CourierName"];		
 
			$this->DeliveryName	= $row["DeliveryName"];	

			$this->Price	= $row["Price"];			

			$this->EstimatedTime  = $row["EstimatedTime"];		
	}

		return true;
	}

}
	
?>