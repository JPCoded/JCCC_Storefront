<?php

if (!file_exists('include/utils.php'))
	require_once '../include/utils.php';
else
	require_once 'include/utils.php';

class Review
{
	var $Product_ID;
	var $Customer_ID;
	var $Rating;
	var $Subject;
	var $Body;
	var $Date;

	function __construct($row)
	{
		$this->Product_ID = $row["Product_ID"];
		$this->Customer_ID = $row["Customer_ID"];
		$this->Rating = $row["Rating"];
		$this->Subject = $row["Subject"];
		$this->Body = $row["Body"];
		$this->Date = $row["Date"];
	}

	function createSQLInsertStatement()
	{
		$sql = "INSERT INTO
					`Review`
				SET
					`Product_ID`	= '$this->Product_ID',
					`Customer_ID`	= '$this->Customer_ID',
					`Rating`		= '$this->Rating',
					`Subject`		= '" . mysql_real_escape_string($this->Subject) ."',
					`Body`			= '" . mysql_real_escape_string($this->Body) ."',
					`Date`			= now()
				";

		return $sql;
	}

	function createSQLDeleteStatement()
	{
		return "DELETE FROM
					`Review`
				WHERE
					`Product_ID`	= '$this->Product_ID'	AND
					`Customer_ID`	= '$this->Customer_ID'
				";
	}


	public static function loadFromDB($CID, $PID = null)
	{
		$reviews = array();

		$con1 = db_connection_init();

		$getProd = "";

		if ($PID != null)
		{
			$getProd = "AND `Product_ID`='$PID'";
		}

		$result = mysql_query("SELECT * FROM `Review` WHERE `Customer_ID` = '$CID' $getProd", $con1);

		if (!$result)
			echo mysql_error($con1);

		if ($PID != null)
		{
			return new Review(mysql_fetch_assoc($result));
		}

		while ($a = mysql_fetch_array($result))
		{
			$reviews[] = new Review($a);
		}

		return $reviews;
	}
}


?>
