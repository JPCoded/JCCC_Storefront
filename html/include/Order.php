<?php
class Order
{
	private $TrackingNumber;
	private $Total;
	private $PaymentType;
	private $CustomerID;
	private $OrderDate;
	private $OrderID;


	function __construct($TT,$PT,$CI,$OD,$ID)
	{
		$this->TrackingNumber = mt_rand(1000000000,9999999999);
		$this->Total = $TT;
		$this->PaymentType = $PT;
		$this->CustomerID = $CI;
		$this->OrderDate = $OD;
		$this->OrderID = $ID;
	}

	function getTrackingNumber()
	{ return $this->TrackingNumber;}
	
	function getTotal()
	{ return $this->Total;}
	
	function getPaymentType()
	{ return $this->PaymentType; }
	
	function getCustomerID()
	{ return $this->CustomerID; }
	
	function getOrderDate()
	{ return $this->OrderDate; }
	
	function getOrderID()
	{ return $this->OrderID; }
	
	function createOrderInsert()
	{
		return "INSERT INTO `Order` SET
		`Order_ID` = '$this->OrderID',
		`OrderDate` = '$this->OrderDate',
		`PackageTrackingNumber` = '$this->TrackingNumber',
		`OrderTotal` = '$this->Total',
		`PaymentType` = '$this->PaymentType',
		`Customer_ID` = '$this->CustomerID'";
	}
}

?>
