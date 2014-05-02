<?php
require_once 'include/utils.php';
require_once 'include/Body.php';
require_once 'include/MySQLDB.php';

function WhatsNew($NEW = "Products")
{
	$DB = new MySQLDB();
	if($NEW == "Products")
		$DB->ssResults("SELECT * FROM Product ORDER BY ReleaseDate DESC LIMIT 4");
	else
		$DB->ssResults("SELECT * FROM Offer, Product_has_Offer, Product WHERE Offer.Offer_ID = Product_has_Offer.Offer_ID AND Product_has_Offer.Product_ID = Product.Product_ID ORDER BY ReleaseDate DESC LIMIT 4");

	$a = "<ul class='lower_menu' id='lm_alt'>";
		while($row = $DB->fetchArray())
		{
			if($NEW == "Products")
			{
				$a .= "<li><a href='viewPhone.php?Product_ID=".$row['Product_ID']."'>".$row['Model']." by ".$row['Manufacturer']."</a></li>";
			}
			else
			{
				$per = ($row['PercentOff'] * 100);
				$a .= "<li><a href='viewPhone.php?Product_ID=".$row['Product_ID']."'>".$per."% off of ".$row['Model']."</a></li>";
			}
		}
	$a.= "</ul>";
	return $a;
}

doctype_def();
?>

<html>
	<head>
		<title>Home</title>
		<?php
			header_defs("index");
		?>
	</head>
	<body>
		<div id="wrapper">
			<div id="main">
				<?php
					menu_bar();
				?>
				<table id="dynamic">
					<tr >
						<td valign="top">
							<?php
								echo file_get_contents("news.txt"); //read and display file
							?>
						</td>
					</tr>
				</table>

				<table id="lower_menu">
					<tr>
						<td>
							<div class="OO"></div>
							<strong>Order Online</strong>
						</td>
						<td>
							<div class="SO"></div>
							<strong>Special Offers</strong>
						</td>
						<td>
							<div class="WN"></div>
							<strong>What&#39;s New</strong>
						</td>
						<td>
							<div class="SP"></div>
							<strong>Support</strong>
						</td>
					</tr>
					<tr>
						<td>
							<ul id="lm_online">
								<li><a href="browse.php?browseBy=Manufacturer">Browse By Manufacturer</a></li>
								<li><a href="browse.php?browseBy=OS">Browse By OS</a></li>
								<li><a href="#">Browse By Style</a></li>
								<li><a href="#">Browse By Color</a></li>
							</ul>
						</td>
						<td>
							<?php
								echo WhatsNew("Offers");
							?>
						</td>
						<td>
							<?php
								echo WhatsNew();
							?>
						</td>
						<td>
							<ul id="lm_support">
								<li><a href="#">About</a></li>
								<li><a href="Contact.php">Contact</a></li>
								<li><a href="#">FAQ</a></li>
								<li><a href="#">Privacy Policy</a></li>
							</ul>
						</td>
					</tr>
				</table>
			</div>
			<?php
				footer_defs();
			?>
		</div>
	</body>
</html>
