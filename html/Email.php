<?php //Email sending outline right now
require_once 'include/utils.php';
require_once 'include/Body.php';

$Name = (isset($_REQUEST['name']) && $_REQUEST['name'] != "") ? $_REQUEST['name'] : "Jon Doe";
$Email = (isset($_REQUEST['mail']) && $_REQUEST['mail'] != "") ? $_REQUEST['mail'] : "JonDoe@place.com";
$MSG = isset($_REQUEST['comment']) ? $_REQUEST['comment'] : "Where are my pants?!";
$to = 'nerd.johnny.boy@gmail.com';
$subject = 'User Comment';
$time = getTime("y-m-d G:i:s");

doctype_def();
?>

<html>
	<head>
	<?php header_defs(); ?>
		<title>Email</title>
	</head>
	<body>
		<div class="wrapper">
			<div class="main">
			<?php menu_bar();?>
			<div class="PITA" >
			<?php
			$message = "
				<html>
				<head>
				  <title>User Comment</title>
				</head>
				<body>
				  <p>User Comment</p>
				  <b>From:</b> $name <br />
				  <b>Email:</b> $mail <br />
				  <b>Comment:</b> $MSG <br /><br />
				  <p>Time: $time</p>
				</body>
				</html>";
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

				// Additional headers
				$headers .= 'To: Storefrontjccc <storefrontjccc@gmail.com>' . "\r\n";
				mail($to,$subject,$MSG,$headers);
			?>
			</div>
			<?php footer_defs(); ?>
			</div>
		</div>
	</body>
</html>
