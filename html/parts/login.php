<table class='login'>
	<tr>
		<th colspan="2">
			<div align='center'>
				<h3>Customer Sign In</h3>
			</div>
		</th>
	</tr>
	<tr>
		<td width="512px" valign="top">
			<div align="center">
			<form name="form1" method="post" action="parts/checklogin.php">
				<input type="hidden" name="ref" value="<?php echo $_POST["ref"]; ?>" />
				<table width="300px" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
					<tr>
						<td colspan="3" align="center">
							<strong>Member Login</strong>
						</td>
					</tr>
					<tr>
						<td width="78">
							Username
						</td>
						<td width="6">
							:
						</td>
						<td width="294">
							<input name="myusername" type="text" id="myusername">
						</td>
					</tr>
					<tr>
						<td>
							Password
						</td>
						<td>
							:
						</td>
						<td>
							<input name="mypassword" type="password" id="mypassword">
						</td>
					</tr>
					<tr>
						<td>
							&nbsp;
						</td>
						<td>
							&nbsp;
						</td>
						<td>
							<input type="submit" name="Submit" value="Login">
						</td>
					</tr>
<?php
	// if sent back from checklogin.php, because the login failed
	if (isset($_GET['error']) && $_GET['error'] == 'loginerror') {
?>
					<tr>
						<td colspan="3" align="center">
							<div class='errortext'>
								Wrong Username or Password
							</div>
						</td>
					</tr>
<?php
	}
?>
				</table>
			</form>
			</div>
		</td>
		<td>
			<?php
				include 'addCustomer.php';
			?>
		</td>
	</tr>
</table>
