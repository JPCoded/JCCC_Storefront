<?php
require_once 'utils.php';

class Offer
{
	var $Offer_ID;
	var $Description;
	var $U_BeginDate;
	var $U_EndDate;
	var $BeginDate;
	var $EndDate;
	var $PercentOff;

	function __construct($row)
	{
		if (isset($row["Offer_ID"]))
			$this->Offer_ID = $row["Offer_ID"];

		$this->Description = $row["Description"];
		$this->BeginDate = $row["BeginDate"];
		$this->EndDate = $row["EndDate"];
		$this->PercentOff = $row["PercentOff"];

		if (isset($row["U_BeginDate"]))
			$this->U_BeginDate = $row["U_BeginDate"];

		if (isset($row["U_EndDate"]))
			$this->U_EndDate = $row["U_EndDate"];
	}

	public function createSQLInsertStatement()
	{
		return "INSERT INTO
					`Offer`
				SET
					`Description`='$this->Description',
					`BeginDate`='$this->BeginDate',
					`EndDate`='$this->EndDate',
					`PercentOff`='$this->PercentOff'
				";
	}

	public function getOfferIDSQL()
	{
		return "SELECT
					`Offer_ID`
				FROM
					`Offer`
				WHERE
					`Description`='$this->Description'	AND
					`BeginDate`='$this->BeginDate'		AND
					`EndDate`='$this->EndDate'			AND
					`PercentOff`='$this->PercentOff'
				ORDER BY
					`Offer_ID`	DESC
				LIMIT 1
				";
	}

	public static function loadFromDB($id = null, $currentOnly = false)
	{
		if ($id)
		{
			$c1 = db_connection_init();

			$current = "";

			if ($currentOnly)
			{
				$current = "AND `BeginDate` <= now()
							AND `EndDate` >= now()";
			}

			$result = mysql_query("SELECT
										*,
										unix_timestamp(`BeginDate`) AS `U_BeginDate`,
										unix_timestamp(`EndDate`) AS `U_EndDate`
									FROM
										`Offer`
									WHERE
										`Offer_ID`='$id'
										$current
									");

			if (!$result)
				echo mysql_error($c1);

			$o = mysql_fetch_assoc($result);

			return new Offer($o);
		}
		else
			return Offer::getCurrentOffers();
	}

	private static function getCurrentOffers()
	{
		$c1 = db_connection_init();

		$offers = array();

		$result = mysql_query("SELECT * FROM `Offer` WHERE `BeginDate` <= now() AND `EndDate` >= now()", $c1);

		if (!$result)
			echo mysql_error($c1);

		while ($a = mysql_fetch_array($result))
		{
			$offers[] = new Offer($a);
		}

		mysql_close($c1);

		return $offers;
	}
}
?>
