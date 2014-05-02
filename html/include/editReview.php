<?php
	require_once 'utils.php';
	require_once 'Review.php';
	require_once 'MySQLDB.php';

	$con = new MySQLDB();

	$rev = Review::loadFromDB($_POST["Customer_ID"], $_POST["Product_ID"]);

	$result = "";

	switch ($_POST["mode"])
	{
		case "remove":
			$result = $con->ssResults($rev->createSQLDeleteStatement());
			break;
	}


	if (!$result)
	{
		echo mysql_error($con->getConn());
		exit;
	}
	else
	{
		$ref = $_POST["ref"];
		header("location:$ref");
	}
?>
