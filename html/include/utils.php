<?php
session_start(); //makes it so we only have to have utils.php required for all pages to use sessions
require_once 'local_connection_info.php';
require_once 'Customer.php';



/**
 * Simply echos out a string of &nbsp; The amount it echos out is determined by $s
 */
function spacer($s)
{
	$rval = "";

	for ($i=0; $i < $s; $i++)
		$rval .= "&nbsp;";

	return $rval;
}

// Database functions

function db_connection_init()
{
	global $host, $user, $password;

	$con = mysql_connect($host, $user, $password) or die('Could not connect: ' . mysql_error());

	mysql_select_db("s406393_Storefront", $con) or die("Unable to select database: " . mysql_error());

	return $con;
}

function createProductSearch($params, $orderby = "", $asc = "TRUE")
{
	$sql = "SELECT *, UNIX_TIMESTAMP(`ReleaseDate`) as `UTime` FROM `Product`";

	if (array_key_exists('ReleaseDate', $params))
	{
		$sql .=  " ORDER BY `ReleaseDate` DESC LIMIT 3";
	}
	elseif (array_key_exists('Favorites', $params) && getLoggedInCustomer())
	{
		$sql = "SELECT `Product`.*
					FROM `Product` LEFT JOIN `Favorite`
					ON `Product`.`Product_ID` = `Favorite`.`Product_ID`
					WHERE `Favorite`.`Customer_ID`='" . getLoggedInCustomer()->Customer_ID . "'";
	}
	elseif (array_key_exists('Offers', $params))
	{
		$sql = "SELECT
					DISTINCT `Product_has_Offer`.`Product_ID`, `Product`.*
				FROM
					`Product_has_Offer`,
					`Product`,
					`Offer`
				WHERE
					`Product_has_Offer`.`Product_ID` = `Product`.`Product_ID`	AND
					`Product_has_Offer`.`Offer_ID` = `Offer`.`Offer_ID`			AND
					`Offer`.`BeginDate` <= now()								AND
					`Offer`.`EndDate` >= now()
				";
	}
	else
	{
		$sql .= " WHERE `" . key($params) . "` LIKE '%" . current($params) . "%' ";

		while (next($params))
		{
			$sql .= "AND `" . key($params) . "` LIKE '%" . current($params) . "%' ";
		}

		if ($orderby != "")
		{
			$sql .= " ORDER BY " . $orderby . " " . ($asc == "TRUE" ? "ASC" : "DESC");
		}
	}

	return $sql;
}

function navigateTo($url)
{
?>
	<script type="text/javascript">
		window.location.href = <?php echo $url; ?>;
	</script>
<?php
}

function getPageURL()
{
	return $_SERVER["REQUEST_URI"];
}

function getAverageRating($Product_ID, $con)
{
	$reviews = mysql_query("SELECT * FROM `Review` WHERE `Product_ID`='" . $Product_ID . "'", $con);

	$total = 0;
	$count = 0;

	while($row = mysql_fetch_array($reviews))
	{
		$total += $row['Rating'];
		$count++;
	}

	$avg = 0;

	if ($count > 0)
	{
		$avg = ceil($total / $count);

		return "<div class='classification'><div class='cover'></div><div class='progress' style='width: " . ($avg * 20) . "%;'></div></div>";
	}
	else
		return "";
}

date_default_timezone_set("America/Chicago");

function getTime($format = "m/d/y", $time = null)
{
	$timezone = new DateTimeZone("America/Chicago");
	$date = new DateTime($time, $timezone);

	return $date->format($format);
}

/**
 * returns an output formatted phone number
 */
function format_phone($phone)
{
	$phone = preg_replace("/[^0-9]/", "", $phone);

	if(strlen($phone) == 7)
		return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
	elseif(strlen($phone) == 10)
		return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
	else
		return $phone;
}

//makes it easier adding new buttons
function getButton($buttonName,$altText,$altHeight = 26)
{
echo "<img id='$buttonName' height='".$altHeight."' alt='".$altText."' src='images/Buttons/".$buttonName."_P.png' onmousedown=\"this.src='images/Buttons/".$buttonName."_C.png'\" onmouseup=\"this.src='images/Buttons/".$buttonName."_P.png'\" onmouseout=\"this.src='images/Buttons/".$buttonName."_P.png'\" />";
}
?>
