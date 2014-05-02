<?php
//a dummy page for now. shows stuff but doesn't really do anything. only real use so far is shipping cost
require_once 'include/utils.php';
require_once 'include/Cart.php';
require_once 'include/Body.php';
if(!cartIsSet())
{
	header('location:shopping_cart.php');
	exit;
}
if($_SESSION['myusername'] == "")
{
	session_register("checkout");
//	header('location:myAccount.php');

	doctype_def();

?>
<html>
	<head>
		<title>Check Out</title>
		<?php
			header_defs("payment");
		?>
	</head>
	<body>
		<div id="wrapper">
			<div id="main">
				<?php
					menu_bar();
				?>
				<br />
				<form action="myAccount.php" method="post" name="login_redirect">
					<input type="hidden" name="ref" value="<?php echo getPageURL(); ?>" />
				</form>
				<div align="center">
					Redirecting to customer login page...
				</div>
				<script type="text/javascript">
					setTimeout(function()
					{
					document.login_redirect.submit();
					}, 2000);
				</script>
			</div>
			<?php footer_defs(); ?>
		</div>
	</body>
</html>
<?php
	exit;
}

doctype_def();
?>
<html>
	<head>
		<title>Check Out</title>
		<?php
			header_defs("payment");
		?>
	</head>
	<body>
		<div id="wrapper">
			<div id="main">
				<?php
					menu_bar();
				?>
				<br />
				<div id="PAYMENT">
				<form name="pymnt" action="check_out.php" method="post">
					<fieldset class="fieldset-auto-width">
						<legend>
							<strong>Credit/Debit Card</strong>
						</legend>
							<table id="credtb" >
								<tr>
									<td class='right'>Cards Accepted:</td>
									<td><img src='images/CreditCards.gif' width='250px' height='40px' /></td>
								</tr>
								<tr>
									<td class='right'>Card Holder Name:</td>
									<td><input type="text" name="holder" /></td>
								</tr>
								<tr>
									<td class='right'>Card Type:</td>
									<td>
										<select name="cards">
											<option value="Discover">Discover</option>
											<option value="Master">MasterCard</option>
											<option value="Visa">Visa</option>
											<option value="American">American Express</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class='right'>Card Number:</td>
									<td>
										<input type="text" maxlength="19" name="cnumber"/>
									</td>
								</tr>
								<tr>
									<td class='right'>Card Expiry Date:</td>
									<td>
										<select name="ex_month">
											<?php
												$months = array("January","February","March","April","May","June","July","August","September","October","November","December");
												for($i=0;$i < 12; $i++)
													echo "<option value='".$months[$i] ."'>" . $months[$i] . "</option>";
											?>
										</select>
										<select name="ex_year">
											<?php
												for($i=2000;$i <= 2013; $i++)
													echo "<option value='". $i ."'>" . $i . "</option>";
											?>
										</select>
									</td>
								</tr>
								<tr>
									<td class='right'>CVV Number</td>
									<td>
										<input type="text" size="2" maxlength="4" name="CVV" />
									</td>
								</tr>
								<tr>
									<td class='right'>Card Start Date (If on card):</td>
									<td>
										<select name="cSD">
											<?php
												$months = array("Month","January","February","March","April","May","June","July","August","September","October","November","December");
												for($i=0;$i <= 12; $i++)
													echo "<option value='".$months[$i] ."'>" . $months[$i] . "</option>";
											?>
										</select>
										<select name="ex_year">
											<?php
												echo "<option value='year'>Year</option>";
												for($i=2000;$i <= 2013; $i++)
													echo "<option value='". $i ."'>" . $i . "</option>";
											?>
										</select>
									</td>
								</tr>
								<tr>
									<td class='right'>Card Issue No. (If on card):</td>
									<td>
										<input size="2" maxlength="4" type="text" name="CIN"/>
									</td>
								</tr>
							</table>
					</fieldset>
					<br /><br />
					<fieldset class="fieldset-auto-width">
						<legend>
							<strong>Shipping</strong>
						</legend>
							<input type="radio" name="shipping" value="10" CHECKED /> $10 - Normal<br />
							<input type="radio" name="shipping" value="15" /> $15 - Fast<br />
							<input type="radio" name="shipping" value="20" /> $20 - Faster <br />
							<input type="radio" name="shipping" value="30" /> $30 - Have It There Yesterday <br />
					</fieldset>
					<br /><br />
					<input type="submit" value="Proceed" />
				</form>
				</div>
			</div>
			<?php footer_defs(); ?>
		</div>
	</body>
</html>
