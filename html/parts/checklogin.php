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

		header("location:" . $_POST["ref"], true);
	}
	else
	{
		header("location:../myAccount.php?error=loginerror");
//		echo "Wrong Username or Password<br>";
//		echo "<a href='login'>return to login page</a>";
	}
?>
