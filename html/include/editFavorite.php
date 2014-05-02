<?php
	require_once 'utils.php';
	require_once 'Favorite.php';
	require_once 'Customer.php';

	$con = db_connection_init();

	$fav = new Favorite($_POST);

	$result = "";

	switch ($_POST["mode"])
	{
		case "add":
			$result = mysql_query($fav->createSQLInsertStatement(), $con);
			break;
		case "remove":
			$result = mysql_query($fav->createSQLDeleteStatement(), $con);
			break;
	}

	if (!$result)
	{
		echo mysql_error($con);
		exit;
	}
	else
	{
		$ref = $_POST["ref"];
		header("location:$ref");
	}
?>