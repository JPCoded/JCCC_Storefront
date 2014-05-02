<?php
require_once 'utils.php';

class Favorite
{
	var $Customer_ID;
	var $Product_ID;

	function __construct($row)
	{
		$this->Customer_ID = $row["Customer_ID"];
		$this->Product_ID = $row["Product_ID"];
	}

	public function createSQLInsertStatement()
	{
		return "INSERT INTO `Favorite` SET
				`Customer_ID` = '$this->Customer_ID',
				`Product_ID` = '$this->Product_ID'";
	}

	public function createSQLDeleteStatement()
	{
		return "DELETE FROM `Favorite` WHERE
				`Customer_ID` = '$this->Customer_ID' AND
				`Product_ID` = '$this->Product_ID'";
	}
	
	public static function loadFromDB($CID)
	{
		$favs = array();
	
		$con1 = db_connection_init();
	
		$result = mysql_query("SELECT * FROM `Favorite` WHERE `Customer_ID` = '$CID'", $con1);
	
		if (!$result)
			echo mysql_error($con1);
	
		while ($a = mysql_fetch_array($result))
		{
			$favs[] = new Favorite($a);
		}
	
		return $favs;
	}
}
?>
