<?php
require_once 'utils.php';

class Customer
{
	var $Customer_ID;
	var $User_ID;
	var $User_PWD;
	var $FirstName;
	var $LastName;
	var $ShippingAddress;
	var $ShippingCity;
	var $ShippingState;
	var $ShippingZip;
	var $BillingAddress;
	var $BillingCity;
	var $BillingState;
	var $BillingZip;
	var $Email;
	var $PhoneNumber;

	var $row;

	function __construct($row)
	{
		$this->Customer_ID = (!isset($row["Customer_ID"]) ? "" : $row["Customer_ID"]);
		$this->User_ID = $row["User_ID"];
		$this->User_PWD = $row["User_PWD"];
		$this->FirstName = $row["FirstName"];
		$this->LastName = $row["LastName"];
		$this->ShippingAddress = $row["ShippingAddress"];
		$this->ShippingCity = $row["ShippingCity"];
		$this->ShippingState = $row["ShippingState"];
		$this->ShippingZip = $row["ShippingZip"];
		$this->BillingAddress = $row["BillingAddress"];
		$this->BillingCity = $row["BillingCity"];
		$this->BillingState = $row["BillingState"];
		$this->BillingZip = $row["BillingZip"];
		$this->Email = $row["Email"];
		$this->PhoneNumber = $row["PhoneNumber"];
	}

	function createSQLInsertStatement()
	{
		if ($this->User_ID == "")
			return null;

		$sql = "INSERT INTO `Customer` SET
					`User_ID`			= '$this->User_ID',
					`User_PWD`			= '$this->User_PWD',
					`FirstName`			= '$this->FirstName',
					`LastName`			= '$this->LastName',
					`ShippingAddress`	= '$this->ShippingAddress',
					`ShippingCity`		= '$this->ShippingCity',
					`ShippingState`		= '$this->ShippingState',
					`ShippingZip`		= '$this->ShippingZip',
					`BillingAddress`	= '$this->BillingAddress',
					`BillingCity`		= '$this->BillingCity',
					`BillingState`		= '$this->BillingState',
					`BillingZip`		= '$this->BillingZip',
					`Email`				= '$this->Email',
					`PhoneNumber`		= '$this->PhoneNumber'";

		return $sql;
	}
}

function customerIsLoggedIn()
{
	if (isset($_SESSION["myusername"]))
		return true;

	return false;
}

function getLoggedInCustomer()
{
	if (customerIsLoggedIn())
		return loadCustomerFromDB($_SESSION["myusername"]);
	else
		return null;
}

function loadCustomerFromDB($UID)
{
	$con1 = db_connection_init();

	$result = mysql_query("SELECT * FROM  `Customer` WHERE  `User_ID` = '" . $UID . "'", $con1);

	if (!$result)
		echo mysql_error($con1);

	$a = mysql_fetch_array($result);

	//mysql_close($con1);

	return new Customer($a);
}

?>
