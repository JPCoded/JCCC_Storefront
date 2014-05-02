<?php
require_once 'include/utils.php';
require_once 'include/Body.php';
require_once 'include/MySQLDB.php';

$DB = new MySQLDB();

$searchField = (isset($_GET['browseBy']) && $_GET['browseBy'] != '') ? $_GET['browseBy'] : 'Manufacturer';

if ($searchField != 'Manufacturer' &&
    $searchField != 'OS') {
	header("location:browse.php?browseBy=Manufacturer");
}

$queryResult = $DB->ssResults("SELECT DISTINCT `$searchField` FROM `Product` ORDER BY `$searchField`");

if ($queryResult) {

	$numOptions = $DB->rowsUsed();

	$options = array();

	while($row = $DB->fetchArray())
	{
		$options[] = $row;
	}
}

doctype_def();

?>
<html>
	<head>
		<title>Browse by <?php echo $searchField; ?></title>
<?php
			header_defs();
?>
	</head>
	<body>
		<div id="wrapper">
			<div id="main">
<?php
					menu_bar();
?>
				<br />
<?php

if ($queryResult && $numOptions > 0) {

?>				<form action="gridsearch.php" method="get">
					<p>
						<label>
							Select <?php switch ($searchField) {
									case 'Manufacturer':
										echo 'a Manufacturer';
										break;
									case 'OS':
										echo 'an OS';
										break;
								} ?>:
						</label>
						<select name="<?php echo $searchField; ?>">
<?php
	for ($i = 0; $i < $numOptions; $i++) {

		$optionName = $options[$i][0];

?>							<option value="<?php echo $optionName; ?>"><?php echo $optionName; ?></option>
<?php

	}  // end for

?>						</select>
					</p>
					<input type="submit">
				</form>
<?php

}  // end if

else {

?>				<div align="center">
					Error retrieving <?php echo $searchField; ?>s, redirecting to home page...
				</div>
				<script type="text/javascript">
					setTimeout(function()
					{
					window.location.href = "index.php";
					}, 3000);
				</script>
<?php

}

?>			</div>
			<?php footer_defs(); ?>
		</div>
	</body>
</html>
