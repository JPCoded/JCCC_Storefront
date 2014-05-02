<?php
	require_once '../include/Body.php';
?>
<html>
	<head>
		<link rel='stylesheet' type='text/css' href='css/all_pages.css' />
	</head>
	<body>

		<div align="right">
			<form id="do_login" action="" name="do_login">
				<div id="user">
					User Name: <input name="myusername" type="text" id="myusername" />
				</div>
				<div id="pass">
					Password: <input name="mypassword" type="password" id="mypassword" />
				</div>
				<div id="create">
					<a href="myAccount.php" >Create an Account</a><br/>
					<a href="#">Retrieve Password</a>
				</div>
			</form>
			<button id="login_btn">Login</button>
			<button id="cancel_btn">Cancel</button>
		</div>
		<script type="text/javascript">
		<!--
			$(document).ready(function()
			{
				$("#myusername").focus();
			});

			$('#mypassword').keyup(function(e)
			{
				if(e.keyCode == 13)
				{
					$("#login_btn").click();
				}
			});

			$("#login_btn").click(function()
			{
				$.post('parts/login_popup.php', $("#do_login").serialize(), function(data)
				{
					$("#login_box").html(data);

					if ($("#login_box:contains('Success')").length)
					{
						window.location.reload(true);
					}
					else
					{
						setTimeout("$('#login_box').load('parts/login_form.php')", 2000);
					}
				});
			});

			$("#cancel_btn").click(function()
			{
				$("#login_box").slideUp();
			});
		//-->
		</script>
			<?php
				// needed for link hovers.
				footer_defs();
			?>
	</body>
</html>
