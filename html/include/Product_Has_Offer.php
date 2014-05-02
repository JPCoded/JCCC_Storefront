<?php
require_once 'utils.php';

class Product_Has_Offer
{
	var $Product_ID;
	var $Offer_ID;

	function __construct($row)
	{
		$this->Product_ID = $row["Product_ID"];
		$this->Offer_ID = $row["Offer_ID"];
	}

	public function createSQLInsertStatement()
	{
		return "INSERT INTO `Product_has_Offer` SET
				`Offer_ID` = '$this->Offer_ID',
				`Product_ID` = '$this->Product_ID'";
	}

	public function createSQLDeleteStatement()
	{
		return "DELETE FROM `Product_has_Offer` WHERE
				`Offer_ID` = '$this->Offer_ID' AND
				`Product_ID` = '$this->Product_ID'";
	}

	public static function loadFromDB($id)
	{
		$phos = array();

		$con1 = db_connection_init();

		$result = mysql_query("SELECT * FROM `Product_Has_Offer` WHERE `Offer_ID` = '$id'", $con1);

		if (!$result)
		{
			return null;
		}

		while ($a = mysql_fetch_array($result))
		{
			$phos[] = new Product_Has_Offer($a);
		}

		return $phos;
	}
}
?>
