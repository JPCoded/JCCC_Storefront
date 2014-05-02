<?php
	require_once '../include/utils.php';
	require_once '../include/Body.php';
	require_once 'admin_utils.php';

	$refresh = false;

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	//connect to database
	$con = mysql_connect($host, $user, $password);
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}

	//select database to use
	$con = db_connection_init();

	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES["phone_image"]["tmp_name"]))
	{
		if ($_FILES["phone_image"]["error"] > 0)
		{
		  	echo "Error: " . $_FILES["phone_image"]["error"] . "<br />";
		}

		if (is_uploaded_file($_FILES["phone_image"]["tmp_name"]))
		{
			if ($_FILES["phone_image"]["type"] != "image/png")
			{
				die("image must be in PNG format");
			}
			else
			{
				$releaseDate = "CURDATE()";

				if (isset($_POST["ReleaseDate"]) && $_POST["ReleaseDate"] != "")
				{
					$releaseDate = $_POST["ReleaseDate"];
				}

				$sql = "INSERT INTO `s406393_Storefront`.`Product` SET "
					. "`Model`='" . mysql_escape_string($_POST["Model"]) . "', "
					. "`Manufacturer`='" . mysql_escape_string($_POST["Manufacturer"]) . "', "
					. "`Description`='" . mysql_escape_string($_POST["Description"]) . "', "
					. "`OS`='" . mysql_escape_string($_POST["OS"]) . "', "
					. "`Retail`='" . mysql_escape_string($_POST["Retail"]) . "', "
					. "`Quantity`='" . mysql_escape_string($_POST["Quantity"]) . "', "
					. "`ReleaseDate`=$releaseDate";

				//echo $sql;

				$result = mysql_query($sql, $con);

				if (!$result)
				{
					die("<br />Error uploading to database: ".  mysql_error());
				}
				else
				{
					echo "<P>Phone Uploaded to Database Successfully!</p>";
				}

				$r = mysql_query("SELECT * FROM `s406393_Storefront`.`Product` WHERE `Product_ID` = "
									. "(SELECT MAX(`Product_ID`) FROM `s406393_Storefront`.`Product`)");

				$row = mysql_fetch_array($r);

				//echo "<br>" . $_FILES["phone_image"]["tmp_name"] . "<br/>";
				//echo getcwd() . "/phone_img/" . $row["Product_ID"] . ".png" . "<br/>";

				//$f = move_uploaded_file($filename, $destination)
				$f = move_uploaded_file($_FILES["phone_image"]["tmp_name"], "phone_img/" . $row["Product_ID"] . ".png");

				if ($f == 1)
				{
					echo "<P>Image uploaded successfully!</P>";

					$refresh = true;
				}
				else
				{
					echo "<P>Failed to upload image!</P>";

					mysql_query("DELETE FROM `s406393_Storefront`.`Product` WHERE `Product_ID` = '" . $row["Product_ID"] . "'");
				}
			}
		}
	}
	else
	{
	}

	mysql_close($con);

	doctype_def();
?>

<div align="center">
	<h2>Add A New Phone</h2>

	<form method="post" enctype="multipart/form-data" action="addPhone.php">

		<table style="border-width: 1; border-style: solid;">
			<tr>
				<td>
					Model:
				</td>
				<td>
					<input type="text" name="Model"/>
				</td>
			</tr>
			<tr>
				<td>
					Manufacturer:
				</td>
				<td>
					<input type="text" name="Manufacturer"/>
				</td>
			</tr>
			<tr>
				<td valign="top">
					Description:
				</td>
				<td>
					<textarea name="Description" cols="40" rows="8"></textarea>
				</td>
			</tr>
			<tr>
				<td>
					Operating System:
				</td>
				<td>
					<input type="text" name="OS"/>
				</td>
			</tr>
			<tr>
				<td>
					Retail:
				</td>
				<td>
					<input type="text" name="Retail"/>
				</td>
			</tr>
			<tr>
				<td>
					Quantity:
				</td>
				<td>
					<input type="text" name="Quantity"/>
				</td>
			</tr>
			<tr>
				<td>
					Image:
				</td>
				<td>
					<input type="file" name="phone_image" id="phone_image" />
				</td>
			</tr>
			<tr>
				<td>
					Release Date:
				</td>
				<td>
					<input type="text" id="ReleaseDate" name="ReleaseDate" />
					<a class="plain" href="#"
						onclick="cal.select(getElementById('ReleaseDate'),'anchor3','yyyy-MM-dd'); return false;"
						name="anchor3" id="anchor3">select
					</a>
				</td>
			</tr>

			<tfoot>
				<tr>
					<th colspan="2" align="right">
						<input type="reset" value="Reset"/>
						<input type="submit" value="Add"/>
					</th>
				</tr>
			</tfoot>
		</table>
	</form>

</div>

<div id="testdiv1" style="color: black; position:absolute; visibility:hidden; background-color:white; layer-background-color:white; z-index: 1000;"></div>