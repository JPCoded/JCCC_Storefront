<?php
/**
 * Reviews shows the user the most recent reviews, and breif phone data and a link to that phone's page.
 */

require_once 'include/utils.php';
require_once 'include/Body.php';
require_once 'include/MySQLDB.php';
require_once 'include/Review.php';
require_once 'include/Product.php';

doctype_def();
?>

<html>
	<head>
		<title>Recent Reviews</title>
		<?php
			header_defs("reviews", "gridsearch");
		?>
	</head>
	<body>
		<div id="wrapper">
			<div id="main">
			<?php
				menu_bar();

			?>
				<div align="center" style="font-size: 20px; font-weight: bold; margin: 4px; margin-top: 8px;">
					Recently Reviewed Phones
				</div>
			<?php

				$db = new MySQLDB();

				// This was rediculously complicated and difficult to figure out, but it returns
				// a result set of phone, joined to review, where the review is the most recent review
				// for that phone, and the starts with the most recent review and works back.
				$db->ssResults("
					SELECT
						*
					FROM
						`Product` p1
					LEFT JOIN
						(
							SELECT
								*
							FROM
								`Review`
							WHERE
								`Date` < now()
							ORDER BY
								`Date` DESC
						) r1
					ON
						p1.`Product_ID` = r1.`Product_ID`
					GROUP BY
						r1.`Product_ID`
					HAVING
						r1.`Product_ID` IS NOT NULL
					ORDER BY
						r1.`Date` DESC
					LIMIT
						4
				");

				// List out all the reviews returned.
				while ($row = $db->fetchArray())
				{
					$review = new Review($row);

					// get the related product.
					$cp = Product::loadFromDB($review->Product_ID);
			?>
					<div id="p_<?php echo $cp->Product_ID; ?>">
						<div id="HoverMouse" style="padding-top: 4px;">
							<div class="review_box centered">
								<a class="simple" href='viewPhone.php?Product_ID=<?php echo $cp->Product_ID; ?>'>
									<img src="phone_img/<?php echo $cp->Product_ID; ?>.png" class='review_img' alt="Error: No Image Found!" />
								</a>
								<div class="phone_data">
									<div>
										<label class="PhoneModel">
											<?php echo $cp->Model; ?>
										</label>
										<br />
										<label class="Make">
											<?php echo $cp->Manufacturer; ?>
										</label>
									</div>
									<div>
										<?php
											if ($cp->getCurrentDiscount() > 0)
											{
										?>
											<div>
												<span class='original_retail_sm'><?php echo number_format( $cp->Retail, 2); ?></span>
											</div>
										<?php
											}
										?>
										<span class="retail">
											$<?php echo $cp->getActiveRetail(); ?>
										</span>
									</div>
								</div>
								<div class="review_data">
									<div>
										<b>Rating:</b>
										<div class='classification'>
											<div class='cover'></div>
											<div class='progress' style='width: <?php echo $review->Rating*20; ?>%;'></div>
										</div>
									</div>
									<div>
										<b>Subject:</b> <?php echo $review->Subject; ?>
									</div>
									<div style="margin-top: 6px;">
										<?php echo $review->Body; ?>
									</div>
									<div style="margin-top: 10px;">
										Review Added: <?php echo getTime("M d, Y", $review->Date); ?>
									</div>
								</div>
							</div>
						</div>
					</div>

					<script type="text/javascript">
						$("#p_<?php echo $cp->Product_ID; ?>").click(function()
						{
							document.location.href='viewPhone.php?Product_ID=<?php echo $cp->Product_ID; ?>';
						});
					</script>
			<?php
				}
			?>
			</div>

			<?php
				footer_defs();
			?>
		</div>
	</body>
</html>
