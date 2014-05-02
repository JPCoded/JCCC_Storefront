<?
require_once 'utils.php';
session_start();
//fixed problem. will now redirect back to login after 10 secs
if(session_is_registered(myusername))
{
	//if user was directed from the shopping cart from the proceed to checkout button
	if(session_is_registered(checkout))
	{
		unset($_SESSION['checkout']);
		header('refresh:10; url=check_out');
	}
	else
	{
		header('refresh: 10; url=' . $_SESSION['back']);
	}
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Login Success</title>
		<?php header_defs(); ?>
	</head>
	<body>
	Login Successful<br/>
	You will be redirected in 10 seconds.
	</body>
</html>
