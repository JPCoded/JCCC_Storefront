<?php
	require_once 'include/utils.php';

	$con = db_connection_init();

	$myusername=$_POST['myusername'];
	$mypassword=$_POST['mypassword'];

	$sql = "SELECT * FROM `Customer` WHERE `User_ID`='$myusername' AND `User_PWD`='$mypassword'";

	$result = mysql_query($sql, $con);
	$count = mysql_num_rows($result);

	if($count == 1)
	{
		session_register("myusername");
		session_register("mypassword");

		$_SESSION['myusername'] = $myusername;

		echo $_POST["ref"];
		
		if ($_POST["ref"] == "")
			header("location:" . $_POST["ref"]);
		else
			header("location:index.php");
	}
	else
	{
		header("location:myAccount.php?error=loginerror");
	}

	mysql_close($con);
?>