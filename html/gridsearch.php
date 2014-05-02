<?php
require_once 'include/utils.php';
require_once 'include/Body.php';
require_once 'include/Product.php';

if (array_key_exists('Model', @$_GET))
	$search["Model"] = trim(@$_GET['Model']); //trim whitespace from stored variable

if (array_key_exists('Manufacturer', @$_GET))
	$search["Manufacturer"] = trim(@$_GET['Manufacturer']);

$orderby = trim(@$_GET['OrderBy']);
$asc = trim(@$_GET['Asc']);
$page = (isset($_GET['Page']) ? $_GET['Page'] : 1);

if (array_key_exists('ReleaseDate', @$_GET))
	$search["ReleaseDate"] = trim(@$_GET['ReleaseDate']);

if (array_key_exists('Favorites', @$_GET))
{
	if (getLoggedInCustomer())
		$search["Favorites"] = trim(@$_GET['Favorites']);
	else
		header("location:.");
}

if (array_key_exists('Offers', @$_GET))
	$search["Offers"] = trim(@$_GET['Offers']);

if (array_key_exists('OS', @$_GET))
	$search["OS"] = trim(@$_GET['OS']);

if (! isset($search))
	$search["Model"] = "";

$DB = new MySQLDB();

$results = $DB->ssResults(createProductSearch($search, $orderby, $asc),TRUE);

if (!$results)
	echo mysql_error($DB->getConn());

$numPhones = $DB->rowsUsed();

$phone = array();

while($row = $DB->fetchArray())
{
	$phone[] = $row;
}

/**
 * getParams() rebuilds the GET parameters for this page so that everything can be tracked from
 * one page to the next.
 */
function getParams($page)
{
	global $search;
	global $orderby;
	global $asc;

	$param = "?";

	if (array_key_exists('Favorites', @$_GET))
	{
		$param .= "Favorites";
	}
	else
	{
		$param .= "Model=" . $search["Model"];

		if (isset($search['Manufacturer']))
			$param .= "&Manufacturer=" . $search["Manufacturer"];
	}
	$param .= "&Page=" . $page;


	return $param;
}

/**
 * flipAsc() toggles between ascending and descending mode.
 */
function flipAsc()
{
	global $asc;

	return ($asc == "TRUE" ? "FALSE" : "TRUE");
}

$ctr = ($page * 6) - 6;

/**
 * prevNextLinks merely generates the previous next buttons on the top and bottom of the searh grid.
 */
function prevNextLinks()
{
	global $ctr;
	global $page;
	global $numPhones;

	echo "<table width='1024px;'><tr><td align='left'>";

	if ($ctr >= 6)
	{
		echo "<a href='gridsearch.php" . getParams($page - 1) . "'>Previous</a>";
	}

	echo "</td><td align='right'>";

	if ($numPhones > $ctr + 6)
	{
		echo "<a href='gridsearch.php" . getParams($page + 1) . "'>Next</a>";
	}

	echo "</td></tr></table>";

}

doctype_def();
?>

<html>
	<head>
		<?php
			header_defs("gridsearch","star","viewPhone");
		?>
		<title>Search Results</title>
	</head>
	<body>
		<div id="wrapper">
			<div id="main">
			<?php
				menu_bar();

				if ($numPhones > 0)
				{
			?>
				<table width="1024">
					<tr>
						<td colspan="3" class="MainText">
							<?php prevNextLinks(); ?>
						</td>
					</tr>
					<tr height="260">
						<?php
							for ($i = $ctr; $i < $ctr + 6 && $i < $numPhones; $i++)
							{
								$cp = new Product($phone[$i]);

								if ($i == $ctr + 3)
									echo "</tr><tr height='260'>";
						?>
						<td id="HoverMouse">
							<table class="search_grid" >
								<tr id="gs_<?php echo $cp->Product_ID; ?>">
									<td width="170px">
										<table>
											<tr>
												<td>
													<label class="PhoneModel">
														<?php echo $cp->Model; ?>
													</label>
												</td>
											</tr>
											<tr>
												<td>
													<label class="Make">
														<?php echo $cp->Manufacturer; ?>
													</label>
												</td>
											</tr>
											<tr height="180px">
												<td align="center">
													<a class="simple" href='viewPhone.php?Product_ID=<?php echo $cp->Product_ID; ?>'>
														<img src="phone_img/<?php echo $cp->Product_ID; ?>.png" class='search_img' alt="Error: No Image Found!" />
													</a>
												</td>
											</tr>
										</table>
									</td>
									<td width="171">
										<table width="100%">
											<tr>
												<td height="48" align="right">
													<?php
														if ($cp->isFavorite())
														{
														?>
															<img width="20px" height="20px" src="images/favorites.png" />
														<?php
														}
													?>
												</td>
											</tr>
											<tr>
												<td height="45" align="right">
													<?php
														$avg = getAverageRating($cp->Product_ID, $DB->getConn());
														if ($avg > "")
														{
															echo "<span style='font-size: 14px;'>Average Rating</span>";
															echo $avg;
														}
														else
														{
															echo "<span style='font-size: 14px;'>Not Yet Rated</span>";
														}
													?>
												</td>
											</tr>
											<tr>
												<td height="102" align="right">
													<label class="DescriptionText">
														<?php
															$outstring = "";
															$words = explode(" " , $cp->Description);

															$linelen = 0;
															foreach ($words as $word)
															{
																if ($linelen + strlen($word) > 117)
																	break;
																else
																{
																	$outstring .= $word . " ";
																	$linelen += strlen($word);
																}
															}
															echo $outstring . (strlen($outstring) < strlen($cp->Description) ? "..." : "");

														?>
													</label>
												</td>
											</tr>
											<tr>
												<td height="45" align="right">
													<?php
														if ($cp->getCurrentDiscount() > 0)
														{
														?>
														<div>
															<span class='MainText original_retail_sm'><?php echo number_format( $cp->Retail, 2); ?></span>
														</div>
														<?php
														}
													?>

													<div class="MainText" style="font-size: 20px;">
														$<?php echo $cp->getActiveRetail();?>
													</div>
												</td>
											</tr>

											<tr>
												<td height="50" align="right">
													<form name="Addto_<?php echo $cp->Product_ID; ?>" id="Addto_<?php echo $cp->Product_ID; ?>" action="shopping_cart.php" method="POST">
														<input type="hidden" name="ref" value="<?php echo getPageURL(); ?>" />
														<input type="hidden" name="Product_ID" value="<?php echo $cp->Product_ID; ?>" />
														<input type="hidden" name="action" value="add" />
														<?php getButton("AddToCart","Add to Cart"); ?>
													</form>

												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
							<script type="text/javascript">
								/**
								* Fixes the add to cart problem
								*/
								$("#gs_<?php echo $cp->Product_ID; ?>").click(function(event)
								{
									if ($(event.target).is("#AddToCart"))
									{
										document.Addto_<?php echo $cp->Product_ID; ?>.submit();
									}
									else
									{
										document.location.href='viewPhone.php?Product_ID=<?php echo $cp->Product_ID; ?>';
									}
								});

							</script>
						</td>
						<?php
							}
							if ($numPhones < 3)
							{
								for ($j = 0; $j < 3 - $numPhones; $j++)
								{
									echo "<td width='337px' class='search_grid'></td>";
								}
							}
						?>
					<tr>
						<td colspan="3" class="MainText">
							<?php if ($numPhones - $ctr > 3) prevNextLinks(); ?>
						</td>
					</tr>
				</table>
			<?php
				} // end if $numPhones > 0
				else
				{
				?>
					<div align="center" style="height: 470px;">
						<h3>Sorry, your search returned no results.</h3>
					</div>
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
