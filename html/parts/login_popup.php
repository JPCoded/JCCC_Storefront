<?php
	require_once '../include/utils.php';
	require_once '../include/Customer.php';
	require_once '../include/MySQLDB.php';

	$DB = new MySQLDB();

	$myusername=$_POST['myusername'];
	$mypassword=$_POST['mypassword'];

	$DB->ssResults("SELECT * FROM `Customer` WHERE `User_ID`='$myusername' AND `User_PWD`='$mypassword'");

	$count = $DB->rowsUsed();

	if($count == 1)
	{
		session_register("myusername");
		session_register("mypassword");
		//for now used in checkout to reduce calls to database
		$person = $DB->fetchArray();
		$customer = new Customer($person);
		$_SESSION['customer'] = serialize($customer);

		$_SESSION['myusername'] = $myusername;

		echo "Login Successful!";
	}
	else
	{
		echo "Wrong Username or Password";
	}
?>
