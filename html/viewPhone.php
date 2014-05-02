<?php
/**
 * viewPhone.php displays all information pertaining to a particular phone. It lists the product description,
 * discounts, retail and reviews. From this page, a logged-in user may add/remove this item to their favorites, add
 * a new review, or add the phone to their shopping cart.
 */

require_once 'include/utils.php';
require_once 'include/Product.php';
require_once 'include/Review.php';
require_once 'include/Favorite.php';
require_once 'include/Offer.php';
require_once 'include/Product_Has_Offer.php';
require_once 'include/Body.php';

$Product_ID = $_GET['Product_ID'];

$con = db_connection_init();

$result = mysql_query("SELECT * FROM `Product` WHERE `Product_ID`='$Product_ID' LIMIT 1", $con);

// Load product data into a Product data structure.
$prod = new Product(mysql_fetch_array($result));

doctype_def();
?>

<html>
	<head>
		<title>View Phone</title>
		<?php
			header_defs("viewPhone");
		?>
	</head>
	<body>
		<div id="wrapper">
			<?php
				menu_bar();
			?>
			<div id="main">

				<div class='prod'>
					<div class='prod_title'>
						<span class='Model'><?php echo $prod->Model; ?></span>
						<br />
						By	<?php
						echo "<a title='More phones by " . $prod->Manufacturer
							 . "...' href='gridsearch.php?Manufacturer="
							 . $prod->Manufacturer . "'>" . $prod->Manufacturer . "</a>";
						?>
					</div>
					<div class='row'>
						<div class='prod_img'>
							<img width="240px" height="240px" src='phone_img/<?php echo $prod->Product_ID; ?>.png' />
						</div>
						<div class='prod_description'>
							<?php echo $prod->Description; ?>
							<div>
								<br/>
								Technical Specifications:<br />
								<div style="padding-left: 10px;">
									Operating System: <?php echo $prod->OS; ?><br/>
									Release Date: <?php echo getTime("M d, Y", $prod->ReleaseDate); ?>
								</div>
							</div>
						</div>
						<div class='prod_rating'>
							<?php
								$avg_rating = getAverageRating($prod->Product_ID, $con);

								if ($avg_rating != "")
								{
									echo "Average Rating ";
									echo $avg_rating;
								}
								else
								{
									echo "Not Yet Rated";
								}
							?>
							<br />

							<div class='offer'>
								<?php

								$discounts = array();

								foreach ($prod->getOffers() as $o)
								{
									echo ($o->PercentOff * 100) . "% Off";

									$discounts[] = $o->PercentOff;

									echo " Through " . date("M d, Y", $o->U_EndDate);

									echo "<br />";
								}

								if (count($discounts) > 0)
								{
									echo "<hr />";
									echo "<span class='savings green'>You Save: $" . $prod->getCurrentDiscount() . "</span>";
								}
								?>
							</div>
						</div>
					</div>
					<div class='row'>
						<div>
						</div>
					</div>
					<div class='row'>
						<div class='prod_do'>
							<?php
								if ($prod->getCurrentDiscountPercent() > 0)
								{
								?>
									List Price: <span class='original_retail'>$<?php echo number_format( $prod->Retail, 2); ?></span>
									<br />
								<?php
								}
							?>
							<span class='retail'>$<?php echo number_format( $prod->getActiveRetail(), 2); ?></span>
						</div>
					</div>
					<div class='row'>
						<div class='prod_do'>
							<?php
								$c = getLoggedInCustomer();

								if ($c)
								{
									if ($prod->isFavorite())
									{
									?>
										<form name="remFav" action="include/editFavorite.php" method="POST">
											<input type="hidden" name="Product_ID" value="<?php echo $prod->Product_ID; ?>" />
											<input type="hidden" name="Customer_ID" value="<?php echo $c->Customer_ID; ?>" />
											<input type="hidden" name="ref" value="<?php echo getPageURL(); ?>" />
											<input type="hidden" name="mode" value="remove" />
										</form>

										<a class='plain' href="#" onclick="document.remFav.submit()">
											<span id="fav_img_r"><img src="images/favorites.png" title="Remove from Favorites" /></span>
										</a>
									<?php
									}
									else
									{
									?>
										<form name="addFav" action="include/editFavorite.php" method="POST">
											<input type="hidden" name="Product_ID" value="<?php echo $prod->Product_ID; ?>" />
											<input type="hidden" name="Customer_ID" value="<?php echo $c->Customer_ID; ?>" />
											<input type="hidden" name="ref" value="<?php echo getPageURL(); ?>" />
											<input type="hidden" name="mode" value="add" />
										</form>

										<a class='plain' href="#" onclick="document.addFav.submit()">
											<span><img src="images/favorites_add.png" title="Add to Favorites"/></span>
										</a>
									<?php
									}
								}
								else
								{
									//echo "Login to add to Favorites.";
								}
							?>
							<?php echo spacer(20); ?>
								<form name="Addto" id="Addto" action="shopping_cart.php" method="POST">
									<input type="hidden" name="ref" value="<?php echo getPageURL(); ?>" />
									<input type="hidden" name="Product_ID" value="<?php echo $prod->Product_ID ?>" />
									<input type="hidden" name="action" value="add" />
									<a href="#" onClick="document.Addto.submit()" >
										<?php getButton("AddToCart","Add to Cart"); ?>
									</a>
								</form>

						</div>
					</div>
				</div>
				<hr />

				<!--  -->


				<div class='review_box'>
					<span style="font-size: 18px; font-weight: bold;">Reviews</span>
					<?php

						$reviews = mysql_query("SELECT * FROM `Review` WHERE `Product_ID`='" . $prod->Product_ID . "'", $con);
						//not best way but works and reduces needed variables
						$i = 0;
						while($row = mysql_fetch_array($reviews))
						{
							$i++;
							$r = new Review($row);

						?>
						<div class='review<?php if ($i % 2 == 1) echo " odd"; ?>'>
						Rating:
							<div class='classification'>
								<div class='cover'></div>
								<div class='progress' style='width: <?php echo $r->Rating*20; ?>%;'></div>
							</div>
							<br />
							<div>
								Subject: <?php echo $r->Subject; ?>
							</div>
							<div>
								Review: <?php echo $r->Body; ?>
							</div>
						</div>
						<?php
						}

						if ($i == 0)
						{
							echo "<div class='review odd'>This Phone Has Not Yet Recieved Any Reviews</div>";
						}
					?>
				</div>

				<?php
					if (getLoggedInCustomer())
					{
						$c = getLoggedInCustomer()->Customer_ID;
						$p = $prod->Product_ID;

						$result = mysql_query("SELECT * FROM `Review` WHERE `Customer_ID`='$c' AND `Product_ID`='$p'", $con);

						if (!$result)
						{
							echo mysql_error($con);
						}

						if (customerIsLoggedIn() && mysql_num_rows($result) == 0)
						{
						?>
						<div id="addReview" style="height: 20px;">
							<button id="addReviewBtn">Add A Review...</button>
						</div>
						<?php
						}
					}
				?>
				<div id="review_area">&nbsp;</div>
			</div>
			<?php footer_defs(); ?>
		</div>


		<script type="text/javascript">

			// only show savings box if there is a savings.
			$(".offer:not(:has(.savings))").hide();

			// Manage the review area transitions.
			$("#review_area").hide();

			$("#addReviewBtn").click(function()
			{
				$("#addReview").fadeOut(function()
				{
					$.post("parts/addReview.php?Product_ID=<?php echo $prod->Product_ID; ?>", function(data)
					{
						$("#review_area").fadeIn().html(data);
					});
				});
				return false;
			});

			$("#fav_img_r > img")
				.mouseover(function()
				{
					$(this).attr("src", "images/favorites_delete.png");
				})
				.mouseout(function()
				{
					$(this).attr("src", "images/favorites.png");
				});

		</script>
	</body>
</html>

<?php
mysql_close($con);
?>
