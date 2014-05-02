<?php
	require_once '../include/Offer.php';
	require_once '../include/Product_Has_Offer.php';

	$failed = false;

	if (!isset($_POST["ProductList"]))
	{
		exit;
	}

	$arr = $_POST["ProductList"];

	$_POST["PercentOff"] /= 100.0;

	$o = new Offer($_POST);

	if (trim($o->Description) == "")
	{
		echo "Error Empty Description!<br />";
		exit;
	}

	$c = db_connection_init();

	mysql_query("BEGIN", $c);

	echo "Adding Offer...<br />";
	//echo $o->createSQLInsertStatement() . "<br />";

	$result = mysql_query($o->createSQLInsertStatement(), $c);

	if (!$result)
	{
		echo "ERROR Adding Offer!<br />";
		$failed = true;

		mysql_error($c);
		mysql_query("ROLLBACK", $c);
	}
	else
	{
		$result = mysql_query($o->getOfferIDSQL(), $c);

		$r = mysql_fetch_array($result);

		foreach ($arr as $p)
		{

			echo "Adding Product: $p...<br />";

			$data["Product_ID"] = $p;
			$data["Offer_ID"] = $r["Offer_ID"];

			$pho = new Product_Has_Offer($data);

			//echo $pho->createSQLInsertStatement() . "<br />";

			$result = mysql_query($pho->createSQLInsertStatement(), $c);

			if (!$result)
			{
				echo "ERROR Adding Product to Offer<br />";
				$failed = true;

				echo mysql_error($c);
				mysql_query("ROLLBACK", $c);
			}
		}
	}

	mysql_query("COMMIT", $c);

	if (!$failed)
		echo "<p>Offer Successfully Added!</p>";
	else
		echo "<p>Offer Could Not Be Added!</p>";
?>