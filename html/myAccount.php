<?php
	require_once 'include/utils.php';
	require_once 'include/Body.php';

	doctype_def();

	if (!isset($_POST["ref"]) || $_POST["ref"] == "")
	{
		$_POST["ref"] = $_SERVER['HTTP_REFERER'];  // may not be ideal -- relies on the user agent to set $_SERVER['HTTP_REFERER']
								// (see http://www.php.net/manual/en/reserved.variables.server.php)
	}
?>

<html>
	<head>
		<?php
			header_defs("login", "gridsearch", "viewPhone");
		?>
	</head>
	<body>
		<div id="wrapper">
			<div id="main">
			<?php
				menu_bar();

				if (isset($_POST['logout']) && customerIsLoggedIn())
				{
					require_once 'include/Cart.php';

					include 'parts/logout.php';
				}
				elseif (customerIsLoggedIn())
				{
					include 'parts/accountDetails.php';
				}
				else
				{
					include 'parts/login.php';
				}
			?>
			</div>
			<?php footer_defs(); ?>
		</div>
	</body>
</html>
