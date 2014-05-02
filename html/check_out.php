<?php
	require_once 'include/utils.php';
	require_once 'include/Customer.php';
	require_once 'include/Cart.php';
	require_once 'include/Order.php';
	require_once 'include/Body.php';
	require_once 'include/MySQLDB.php';

	if($_SESSION['myusername'] == "")
	{
		session_register("checkout");
		header('location:myAccount.php');
	}

	$DB = new MySQLDB();
	$info = $DB->fetchArray("SELECT * FROM `Order` ORDER BY Order_ID DESC LIMIT 1");
	$OrderID = $info['Order_ID'] + 1;
	//$DB->close();

	$tax = round(($_SESSION['subTotal'] * .074),2);
	$total = $_SESSION['subTotal'] + $_POST['shipping'] + $tax;

	$customer = unserialize($_SESSION['customer']);
	$order = new Order($total,"Credit",$customer->Customer_ID,getTime("y-m-d G:i:s"),$OrderID);
	$_SESSION['order'] = serialize($order);

	$INVNUM = mt_rand(1000,9999);
	doctype_def();
?>

<html>

	<head>
		<title>Check Out</title>
		<?php header_defs("checkout"); ?>

		<script type="text/javascript" language="javascript">
			//used to hide header and footer in check out printable view
			$(document).ready(function(){
				$(".Printable").hide(); //hide printable table by default

			$(".flip").click(function(){
				if(document.getElementById("flip").innerHTML == "Printable Version")
				{
					document.getElementById("flip").innerHTML = "Regular Version"; //change text on button to Regular Version
					$(".Regular").slideToggle("slow"); // Hide regular table
					$(".Printable").slideToggle("slow"); // Show Printable table
				}
				else
				{
					document.getElementById("flip").innerHTML = "Printable Version"; //change text to Printable Version
					$(".Regular").slideToggle("slow"); // Show regular version
					$(".Printable").slideToggle("slow"); //Hide Printable Version
				}

			    $(".panel").slideToggle("slow"); //Hide/Show the Menubar and Footer
			  });
			});
		</script>
	</head>

	<body>
		<div id="wrapper">
			<div id="main">
				<div class="panel">
					<?php menu_bar(); ?>
				</div>
			<div style="padding-top:1px"></div>
			<div id="PITA">
				<table id="tblHeader">
					<tr>
						<td>
							<b>Please Verify the Order:</b>
						</td>
						<!-- TOP BUTTONS -->
						<td class="alt">
							<a class="alt" href="javascript:javascript:history.go(-1)">Back</a> |
							<a class="flip" id="flip" href="javascript:void(0)">Printable Version</a> |
							<a class="alt" href="OrderComplete.php">Checkout</a>
						</td>
					</tr>
				</table>
				<!-- REGULAR TABLE START -->
				<div class="Regular">
					<table id="tblContainer">
						<tr>
							<td>
								<!-- Table containing Customer Details -->
								<table id="tblDetails">
									<tr>
										<td class="alt">
											<b>Email Address:</b>
										</td>
										<td>
											<?php echo spacer(1) . $customer->Email; ?>
										</td>
									</tr>
									<tr>
										<td class="alt">
											<b>Billing Address:</b>
										</td>
										<td>
											<?php
												echo spacer(1) . $customer->FirstName . spacer(1) . $customer->LastName . "<br />";
												echo spacer(1) . $customer->BillingAddress . "<br />";
												echo spacer(1) . $customer->BillingCity . ", " . $customer->BillingState . spacer(1) . $customer->BillingZip . "<br />";
											?>
										</td>
									</tr>
									<tr>
										<td class="alt">
											<b>Shipping Address:</b>
										</td>
										<td>
											<?php
												echo spacer(1) . $customer->FirstName . spacer(1) . $customer->LastName . "<br />";
												echo spacer(1) . $customer->ShippingAddress . "<br />";
												echo spacer(1) . $customer->ShippingCity . ", " . $customer->ShippingState . spacer(1) . $customer->ShippingZip . "<br />";
											?>
										</td>
									</tr>
									<tr>
										<td class="alt">
											<b>Telephone:</b>
										</td>
										<td>
											<?php echo spacer(1) . $customer->PhoneNumber ?>
										</td>
									</tr>
									<tr>
										<td class="alt">
											<b>Purchase Total:</b>
										</td>
										<td class="alt">
											<?php echo $_SESSION['subTotal']; ?>
										</td>
									</tr>
									<tr>
										<td class="alt">
											<b>Shipping &#38; Handling:</b>
										</td>
										<td class="alt">
											<?php
												switch($_POST['shipping'])
												{
													case 10;
														echo "Normal 10.00";
														break;
													case 15:
														echo "Fast 15.00";
														break;
													case 20:
														echo "Faster 20.00";
														break;
													case 30;
														echo "Have It There Yesterday 30.00";
														break;
												}
											?>
										</td>
									</tr>
									<tr>
										<td class="alt">
											<b>Total Tax:</b>
										</td>
										<td class="alt">
											<?php echo $tax; ?>
										</td>
									</tr>
									<tr>
										<td class="alt">
											<b>Total Sales Cost:</b>
										</td>
										<td class="alt">
											<?php echo $total; ?>
										</td>
									</tr>
								</table>
							</td>
							<td>
								<!-- Table contaning Invoice data -->
								<table id="tblInvoice">
									<tr>
										<th colspan=2>Invoice</th>
									</tr>
									<tr>
										<th>Date</th>
										<th>Number</th>
									</tr>
									<tr>
										<td><?php echo getTime("m/d/y"); ?></td>
										<td><?php echo $INVNUM; ?></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td colspan=2>
								<!-- Table containing the Items ordered -->
								<table id="tblItem">
									<tr class="alt">
										<th>Item No.</th>
										<th>Item Description</th>
										<th>Unit Price</th>
										<th>Offer Price</th>
										<th>Qty</th>
										<th>Total</th>
									</tr>
									<?php
										$count = countCart();
										for($i=0;$i<$count;$i++)
										{
											$cart = U_Cart($i);
											echo "<tr>
											<td>" . $cart->getPID() . "</td>
											<td>" . $cart->getModMan() .  "</td>
											<td class='alt'>" . $cart->getRetail() . "</td>
											<td class='alt'>" . ($cart->hasOffer() ? "--" : $cart->getOfferPrice()) . "</td>
											<td class='alt'>" . $cart->getQuantity() . "</td>
											<td class='alt'>" . $cart->getPrice() . "</td>
											</tr>";
										}
									?>
								</table>
							</td>
						</tr>
					</table>
				</div>
			<!-- REGULAR TABLE END -->
			<!-- PRINTABLE TABLE START-->
			<div class="Printable">
			<table >
				<tr>
					<td class="alt"><b>Invoice Date:</b></td>
					<td><?php echo getTime("m/d/y"); ?></td>
				</tr>
				<tr>
					<td class="alt"><b>Invoice Number:</b></td>
					<td><?php echo spacer(1) . $INVNUM; ?></td>
				</tr>
				<tr>
					<td class="alt">
						<b>Email Address:</b>
					</td>
					<td>
						<?php echo spacer(1) . $customer->Email; ?>
					</td>
				</tr>
				<tr>
					<td class="alt">
						<b>Billing Address:</b>
					</td>
					<td>
						<?php
							echo spacer(1) . $customer->FirstName . spacer(1) . $customer->LastName . "<br />";
							echo spacer(1) . $customer->BillingAddress .  "<br />";
							echo spacer(1) . $customer->BillingCity . ", " . $customer->BillingState . spacer(1) . $customer->BillingZip . "<br />";
						?>
					</td>
				</tr>
				<tr><td></td></tr>
				<tr>
					<td class="alt">
						<b>Shipping Address:</b>
					</td>
					<td>
						<?php
							echo spacer(1) . $customer->FirstName . spacer(1) . $customer->LastName . "<br />";
							echo spacer(1) . $customer->ShippingAddress . "<br />";
							echo spacer(1) . $customer->ShippingCity . ", " . $customer->ShippingState . spacer(1) . $customer->ShippingZip . "<br />";
						?>
					</td>
				</tr>
				<tr><td></td></tr>
				<tr>
					<td class="alt">
						<b>Telephone:</b>
					</td>
					<td>
						<?php echo spacer(1) . $customer->PhoneNumber ?>
					</td>
				</tr>
				<tr>
					<td class="alt">
						<b>Purchase Total:</b>
					</td>
					<td>
						<?php echo spacer(1) . $_SESSION['subTotal']; ?>
					</td>
				</tr>
				<tr>
					<td class="alt">
						<b>Shipping &#38; Handling:</b>
					</td>
					<td>
						<?php
							switch($_POST['shipping'])
							{
								case 10;
									echo spacer(1) . "Normal 10.00";
									break;
								case 15:
									echo spacer(1) . "Fast 15.00";
									break;
								case 20:
									echo spacer(1) . "Faster 20.00";
									break;
								case 30;
									echo spacer(1) . "Have It There Yesterday 30.00";
									break;
							}
						?>
					</td>
				</tr>
				<tr>
					<td class="alt">
						<b>Total Tax:</b>
					</td>
					<td>
						<?php echo spacer(1) . $tax; ?>
					</td>
				</tr>
				<tr>
					<td class="alt">
						<b>Total Sales Cost:</b>
					</td>
					<td>
						<?php echo spacer(1) . $total; ?>
					</td>
				</tr>
			</table>
			<br />
			<strong>ITEMS</strong>
			<br />
				<!-- Table containing the Items ordered -->
				<table>
					<?php
						$count = countCart();
						for($i=0; $i < $count; $i++)
						{
							$cart = U_Cart($i);
							echo "<tr>
							<td>" . $cart->getQuantity() .
							" x " . $cart->getModMan() .
							" @ " . ($cart->hasOffer() ? $cart->getRetail() : $cart->getOfferPrice()) .
							" each.</td><td>" . spacer(5) . "Totals:  " . $cart->getPrice() . "</td>
							</tr>";
						}
					?>
				</table>
			</div>
				<table width="1024">
					<tr style="width:inherit;height:100px">
						<td></td>
					</tr>
				</table>
			</div>
			<!-- PRINTABLE TABLE END -->
			<div class="panel">
			<?php
				footer_defs();
			?>
			</div>
		</div>
		</div>
	</body>
</html>
