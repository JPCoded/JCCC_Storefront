<?php
//quick and dirty code to display search results on a new page
require_once 'include/utils.php';

$search["Model"] = trim(@$_GET['Model']); //trim whitespace from stored variable
$search["Manufacturer"] = trim(@$_GET['Manufacturer']);

$orderby = trim(@$_GET['OrderBy']);
$asc = trim(@$_GET['Asc']);

if (array_key_exists('ReleaseDate', @$_GET))
	$search["ReleaseDate"] = trim(@$_GET['ReleaseDate']);

//connect to database ** INSERT OWN VALUES **
$con = mysql_connect($host, $user, $password) or die('Could not connect: ' . mysql_error());
//specify database
mysql_select_db("s406393_Storefront") or die("Unable to select database");

$results = mysql_query(createProductSearch($search, $orderby, $asc));
$numrows = mysql_num_rows($results);

function getParams()
{
	global $search;
	global $orderby;
	global $asc;

	$param = "?Model=" . $search["Model"];

	$param .= "&Manufacturer=" . $search["Manufacturer"];

	return $param;
}

function flipAsc()
{
	global $asc;

	return ($asc == "TRUE" ? "FALSE" : "TRUE");
}

doctype_def();
?>

<html>
	<head>
		<?php
			header_defs("search");
		?>
	</head>
	<body>
		<?php
			menu_bar();
		?>


		<?php

		//check to see if any matches were found
		if($numrows == 0)
		{
			echo "<h4>Results</h4>";
			echo "<p>Sorry, your search: &quot;" . @$_GET[0] . "&quot; returned zero results</p>";
		}
		else
		{
		?>
			<table class='bordered search_box'>
				<tr>
					<th>Image</th>
					<th>
						<a href="search.php<?php echo getParams(). "&OrderBy=Model&Asc=" . flipAsc(); ?>">
							Model
						</a>
					</th>
					<th>
						<a href="search.php<?php echo getParams(). "&OrderBy=Manufacturer&Asc=" . flipAsc(); ?>">
							Manufacturer
						</a>
					</th>
					<th>Description</th>
					<th>
						<a href="search.php<?php echo getParams(). "&OrderBy=ReleaseDate&Asc=" . flipAsc(); ?>">
							ReleaseDate
						</a>
					</th>
				</tr>
		<?php
			while($row = mysql_fetch_array($results))
			{
		?>
				<tr>
					<td align='center'>
						<a href='viewPhone.php?Product_ID=<?php echo $row["Product_ID"] ?>'>
							<img src="phone_img/<?php echo $row["Product_ID"] ?>.png" class='search_img' alt="Error: No Image Found!" />
						</a>
					</td>
					<td>
						<?php echo $row["Model"]; ?>
					</td>
					<td>
						<?php echo $row["Manufacturer"]; ?>
					</td>
					<td>
						<?php echo $row["Description"]; ?>
					</td>
					<td>
						<?php
							//$r = new DateTime($row["UTime"]);
							date_default_timezone_set("America/Chicago");
							$t = date("M d, Y", $row["UTime"]);
							echo $t;
						?>
					</td>
				</tr>
		<?php
			}
		?>

		</table>

		<?php
		}

		mysql_close($con);
		?>

	</body>
</html>
