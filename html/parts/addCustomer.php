<?php
	// FIXME: This is CRAZY hinky. the add customer form and the add customer code should be in two different
	// files. this currently works, but is seven different kinds of bad form.
	if (!file_exists('include/utils.php'))
		require_once '../include/utils.php';

	require_once 'include/Customer.php';
	require_once 'include/MySQLDB.php';

	if (!isset($_POST["User_ID"]))
	{
		include 'signupForm.php';
	} // end if not post
	else
	{
		$DB = new MySQLDB();
		// create a new Customer object from post.
		// TODO: assert that $_POST contains all neccessary customer fields.
		$c = new Customer($_POST);

		// flags for validating the post data
		$errorFlagRequiredFieldsLeftBlank = false;
		$errorFlagUsernameTaken = false;
		$errorFlagInvalidShippingZip = false;
		$errorFlagInvalidBillingZip = false;
		$errorFlagInvalidEmail = false;
		$errorFlagEmailTaken = false;
		$errorFlagInvalidPhone = false;

		// check to see if the requested username is already in the database
		// if so, set the error flag
		if ($DB->rowsUsed("SELECT `User_ID` FROM `s406393_storefront`.`Customer` WHERE `User_ID` = '" . $c->User_ID . "'") > 0)
		{
			$errorFlagUsernameTaken = true;
		}

		// check to see if the requested email address is already in the database
		// if so, set the error flag

		if ($DB->rowsUsed("SELECT `Email` FROM `s406393_storefront`.`Customer` WHERE `Email` = '" . $c->Email . "'") > 0)
		{
			$errorFlagEmailTaken = true;
		}

		if (!$errorFlagRequiredFieldsLeftBlank &&
			!$errorFlagUsernameTaken &&
			!$errorFlagInvalidShippingZip &&
			!$errorFlagInvalidBillingZip &&
			!$errorFlagInvalidEmail &&
			!$errorFlagEmailTaken &&
			!$errorFlagInvalidPhone)  // if post data passed validation - no flags were set
		{
			// Insert the new customer.
			$DB->addStatement($c->createSQLInsertStatement());

			if (!$DB->transaction())
			{
				echo("<P>There was an error inserting the customer: ".  mysql_error() . "</P>");

				?>

				<script type="text/javascript">
					setTimeout(function()
					{
				    	window.location.href = "myAccount.php";
				    }, 3000);
				</script>

				<?php
				exit;
			}

			// Automatically login

			$_SESSION['myusername'] = $c->User_ID;
?>

<div align="center">
	<h2>Customer '<?php echo $c->User_ID; ?>' Added Successfully.</h2>
	Returning you to your previous page momentarily...
</div>

<script type="text/javascript">
	setTimeout(function()
	{
    	window.location.href = "<?php echo $_POST["ref"]; ?>"
    }, 3000);
</script>

<?php
			exit;
		}

		// post did not contain a valid signup form, so say what the errors were, then re-display the form
		// and give the user a chance to re-submit it

?>
<div align="center" name="SignupErrorsTableDiv">
	<table class='signupErrors' name="SignupErrorsTable">
<?php
		if ($errorFlagRequiredFieldsLeftBlank) {
?>
		<tr>
			<td align="center">
				<div class='errortext'>
					One or more required fields left blank
				</div>
			</td>
		</tr>
<?php
		}
		if ($errorFlagUsernameTaken) {
?>
		<tr>
			<td align="center">
				<div class='errortext'>
					User Name '<?php echo $_POST['User_ID']; ?>' not available
				</div>
			</td>
		</tr>
<?php
		}
		if ($errorFlagInvalidShippingZip) {
?>
		<tr>
			<td align="center">
				<div class='errortext'>
					Invalid Shipping Zip Code
				</div>
			</td>
		</tr>
<?php
		}
		if ($errorFlagInvalidBillingZip) {
?>
		<tr>
			<td align="center">
				<div class='errortext'>
					Invalid Billing Zip Code
				</div>
			</td>
		</tr>
<?php
		}
		if ($errorFlagInvalidEmail) {
?>
		<tr>
			<td align="center">
				<div class='errortext'>
					Invalid Email Address
				</div>
			</td>
		</tr>
<?php
		}
		if ($errorFlagEmailTaken) {
?>
		<tr>
			<td align="center">
				<div class='errortext'>
					Email Address '<?php echo $_POST['Email']; ?>' not available
				</div>
			</td>
		</tr>
<?php
		}
		if ($errorFlagInvalidPhone) {
?>
		<tr>
			<td align="center">
				<div class='errortext'>
					Invalid Phone Number
				</div>
			</td>
		</tr>
<?php
		}
?>
	</table>
</div>

<?php
		include 'signupForm.php';
	}
?>
