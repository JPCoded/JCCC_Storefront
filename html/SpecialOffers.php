<?php
require_once 'include/utils.php';
require_once 'include/Offer.php';
require_once 'include/Product_Has_Offer.php';
require_once 'include/Body.php';

doctype_def();
?>

<html>
	<head>
		<title>Home</title>
		<?php
			header_defs("SpecialOffer");
		?>
	</head>
	<body>
		<div id="wrapper">
			<div id="main">
				<?php
					menu_bar();
				?>

				<div class="currentOffer">
					This is a test of css3 border rounding and box-shadowing.
					<div class="header">
					HI<br />
					Hello!
					</div>
				</div>

				Current Offers
				<hr />
				<?php
					$offers = Offer::loadFromDB();

					foreach ($offers as $o)
					{
						$phos = Product_Has_Offer::loadFromDB($o->Offer_ID);

						echo "Offer_ID: " . $o->Offer_ID . "<br />";
						echo "&nbsp;&nbsp;- Products Associated: ";

						foreach ($phos as $pho)
						{
							echo " " . $pho->Product_ID;
						}

						echo "<br />";

						echo spacer(4) . "- Percent Off: " . $o->PercentOff * 100.0 . "%";

						echo "<hr />";
					}

				?>

			</div>
			<?php
				footer_defs();
			?>
		</div>
	</body>
</html>
