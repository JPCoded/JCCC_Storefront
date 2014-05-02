<?php
require_once 'include/utils.php';
require_once 'include/Body.php';
doctype_def();
?>
<html>
	<head>
		<title>Contact Us</title>
		<?php header_defs("Contact"); ?>
	</head>
	<body>
		<div class="wrapper">
			<div class="main">
			<?php
				menu_bar();
			?>
			<br />
				<table width="800" align="center">
					<tr>
						<td>
							<div class="contact">Contact Us</div>
							<br />
							<div class="Main MainText">Hi, we are happy to hear from you!</div>
							<br />
							<div align="left">Use our address below to contact us by<br/>mail, or send an email using the form.<br /></div>
							<br />
							<div class="Main MainText">
								12345 College Blvd<br />
								Overland Park, KS, 66210 - 1299<br />
								(913) 469 - 8500
							</div>
						</td>
						<td >
							<form id="ContactUs" name="ContactUs" method="post" action="Email.php" enctype="text/plain" >
								Name:<br />
								<input type="text" name="name" value="your name" /><br />
								E-mail:<br />
								<input type="text" name="mail" value="your email" /><br />
								Comment:<br />
								<input type="text" name="comment" value="your comment" size="50" />
								<br /><br />
								<input type="submit" value="Send">
								<input type="reset" value="Reset">
							</form>
					   </td>
					</tr>
				</table>
			</div>
			<?php footer_defs(); ?>
		</div>
	</body>
</html>
