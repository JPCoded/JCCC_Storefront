<?php
	require_once 'include/utils.php';
	require_once 'include/Body.php';

	$valid_pwd = (($_SERVER['REQUEST_METHOD'] == 'POST') && ($_POST["pwd"] == "1234")) ? TRUE : FALSE;


	$pwd_prompt = "
		<form action='admin.php' method='post'>
			<table style='border-width: 1; border-style: solid;'>
				<tr>
					<th>Password</th>
				</tr>
				<tr>
					<td><input type='password' name='pwd' /></td>
				</tr>
			</table>
			<p>
				<input type='submit' value='Continue &rarr;'/>
			</p>
		</form>";

	doctype_def();
?>

<html>
	<head>
		<?php header_defs("admin"); ?>
		<title>Administrator Access</title>
	</head>
	<body id="admin" onload="">
		<div id="wrapper">
			<div id="main">
				<?php menu_bar(); ?>

				<div id="adminBox" align="center">
					<h2>Admin Access</h2>
					<?php
						if ($valid_pwd == true)
						{
					?>
					<table style='border-width: 1; border-style: solid;'>
						<tr>
							<th>Admin Links</th>
						</tr>
						<tr>
							<td>
								<button id="addPhone">Add Phone</button>
							</td>
						</tr>
						<tr>
							<td>
								<button id="addOffer">Add Special Offer</button>
							</td>
						</tr>
					</table>

					<?php
						}
						else
						{
					?>

					<form action='admin.php' method='post'>
						<table style='border-width: 1; border-style: solid;'>
							<tr>
								<th>Password</th>
							</tr>
							<tr>
								<td><input type='password' name='pwd' /></td>
							</tr>
						</table>
						<p>
							<input type='submit' value='Continue &rarr;'/>
						</p>
					</form>

					<?php
						}
					?>
				</div>

				<!-- LoadArea is where the admin forms will appear. -->
				<div id="loadArea">&nbsp;</div>

				<div id="goBack">
					<button id="goBackBtn">Go Back</button>
				</div>

				<br />
			</div>
			<?php
			footer_defs();
			?>
		</div>

		<script type="text/javascript" language="javascript">
			// load "add phone" dialog.
			$("#goBack").hide();

			$("#addPhone").click(function()
			{
				$("#adminBox").hide();

				$.post('admin/addPhone.php', function(data)
				{
					$("#loadArea").html(data);
					$("#goBack").show();
				});
			});

			$("#addOffer").click(function()
			{
				$("#adminBox").hide();

				$.post('admin/addOffer.php', function(data)
				{
					$("#loadArea").html(data);
					$("#goBack").show();

				});
			});


			$("#goBack").click(function()
			{
				$("#goBack").hide();
				$("#loadArea").html("");

				$("#adminBox").show();
			});
		</script>
	</body>
</html>
