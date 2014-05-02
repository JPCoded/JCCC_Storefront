<?php
require_once 'include/utils.php';
require_once 'include/Favorite.php';
require_once 'include/Customer.php';
require_once 'include/Product.php';
require_once 'include/Order.php';
require_once 'include/MySQLDB.php';
require_once 'include/Review.php';

$c = loadCustomerFromDB($_SESSION['myusername']);

?>

<table class="max_width bordered" style="margin-left: 4px; margin-top: 4px;">
	<tr>
		<th colspan="4" height="28px" valign="bottom">
			<div style="font-size: 20px;" align="center">Customer Information</div>
		</th>
	</tr>
	<tr>
		<td colspan="4">
			<hr />
		</td>
	</tr>
	<tr>
		<td colspan="2" valign="top">
			<table>
				<tr>
					<td style="min-width:100px;">Name:</td>
					<td>
						<?php
							echo $c->FirstName . " " . $c->LastName;
						?>
					</td>
				</tr>
				<tr>
					<td valign="top">Address:</td>
					<td>
						<?php
							echo $c->BillingAddress . "<br/>" . $c->BillingCity . ", " . $c->BillingState
								. " " . $c->BillingZip;
						?>
					</td>
				</tr>
				<tr>
					<td>
						Email Address:
					</td>
					<td>
						<?php echo $c->Email; ?>
					</td>
				</tr>
				<tr>
					<td>
						Phone Number:
					</td>
					<td>
						<?php echo format_phone($c->PhoneNumber); ?>
					</td>
				</tr>
			</table>
		</td>
		<td width="340px"></td>
		<td>
			<table class="bordered">
				<tr>
					<th><span style="font-size: 15px;">Recent Purchases</span></th>
				</tr>
				<tr height="140px">
					<td width="600px">
						<table style="border: outset; border-width: 1px;">
							<tr>
								<th width="100px" style="border: inset; border-width: 1px;">Order Placed</th>
								<th style="border: inset; border-width: 1px;">Tracking Number</th>
								<th style="border: inset; border-width: 1px;">Payment Type</th>
								<th style="border: inset; border-width: 1px;">Order Total</th>
							</tr>
						<?php
							$db = new MySQLDB();

							$r = $db->ssResults("SELECT
													*
												FROM
													`Order`
												WHERE
													`Customer_ID`='$c->Customer_ID'
												ORDER BY
													`OrderDate` DESC
												LIMIT 5
												");

							while ($o = mysql_fetch_assoc($r))
							{
							?>
							<tr>
								<td style="border: inset; border-width: 1px;">
									<?php echo getTime("M d, Y", $o["OrderDate"]); ?>
								</td>
								<td style="border: inset; border-width: 1px;">
									<?php echo $o["PackageTrackingNumber"]; ?>
								</td>
								<td style="border: inset; border-width: 1px;">
									<?php echo ucwords($o["PaymentType"]); ?>
								</td>
								<td align="right" style="border: inset; border-width: 1px;">
									$<?php echo $o["OrderTotal"]; ?>
								</td>
							</tr>
							<?php
							}
						?>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td colspan="4">
			<hr />
		</td>
	</tr>
	<tr>
		<td width="100px" valign="top"><b>Favorites</b></td>
		<td colspan="3">
			<?php

			foreach (Favorite::loadFromDB(getLoggedInCustomer()->Customer_ID) as $f)
			{
				$p = Product::loadFromDB($f->Product_ID);
			?>

			<form name="remFav" action="include/editFavorite.php" method="POST">
				<input type="hidden" name="Product_ID" value="<?php echo $p->Product_ID; ?>" />
				<input type="hidden" name="Customer_ID" value="<?php echo getLoggedInCustomer()->Customer_ID; ?>" />
				<input type="hidden" name="ref" value="<?php echo getPageURL(); ?>" />
				<input type="hidden" name="mode" value="remove" />

				<div id="HoverMouse">
					<div class="sm_phone" onclick="document.location.href='viewPhone.php?Product_ID=<?php echo $p->Product_ID; ?>';">
						<img class="sm_phone" src="phone_img/<?php echo $p->Product_ID . ".png"; ?>" />
						<div style="float: left;">
							<label class="PhoneModel">
								<?php echo $p->Model; ?>
							</label>
							<br />
							<label class="Make">
								By <?php echo $p->Manufacturer; ?>
							</label>
						</div>
						<span class="rem_favorite">
							<input type="image" width="16px" height="16px" src="images/red_x.png" />
						</span>
					</div>
				</div>
			</form>

			<?php
			}
			?>

		</td>
	</tr>
	<tr>
		<td colspan="4">
			<hr />
		</td>
	</tr>
	<tr>
		<td width="100px" valign="top"><b>Reviews</b></td>
		<td colspan="3">
			<?php

			foreach (Review::loadFromDB(getLoggedInCustomer()->Customer_ID) as $r)
			{
				$p = Product::loadFromDB($r->Product_ID);

			?>

			<form name="remRev" action="include/editReview.php" method="POST">
				<input type="hidden" name="Product_ID" value="<?php echo $p->Product_ID; ?>" />
				<input type="hidden" name="Customer_ID" value="<?php echo getLoggedInCustomer()->Customer_ID; ?>" />
				<input type="hidden" name="ref" value="<?php echo getPageURL(); ?>" />
				<input type="hidden" name="mode" value="remove" />

				<div id="HoverMouse">
					<div class="sm_phone" onclick="document.location.href='viewPhone.php?Product_ID=<?php echo $p->Product_ID; ?>';">
						<img class="sm_phone" src="phone_img/<?php echo $p->Product_ID . ".png"; ?>" />
						<div style="float: left;">
							<label class="PhoneModel">
								<?php echo $p->Model; ?>
							</label>
							<br />
							<label class="Make">
								By <?php echo $p->Manufacturer; ?>
							</label>
							<br />
							<div class='classification' style="margin-top: 5px;">
								<div class='cover'></div>
								<div class='progress' style='width: <?php echo $r->Rating*20; ?>%;'></div>
							</div>
						</div>
						<span class="rem_favorite">
							<input id="rem_review" type="image" width="16px" height="16px" src="images/red_x.png" />
						</span>
					</div>
				</div>
			</form>

			<?php
			}
			?>

		</td>
	</tr>
</table>
