<?php
require_once '../include/Review.php';
require_once '../include/utils.php';

if (isset($_POST["Rating"]) && $_POST["Rating"] != "0")
{
	echo $_POST["Subject"] . "<br />"
		. $_POST["Rating"] . "<br />"
		. $_POST["Body"] . "<br />";

	$r = new Review($_POST);

	$con = db_connection_init();

	$result = mysql_query($r->createSQLInsertStatement(), $con);

	if (!$result)
	{
		echo mysql_error($con);
		echo "<br />";
		echo $r->createSQLInsertStatement();
		exit;
	}

	echo "location:../viewPhone.php?Product_ID=" . $_POST["Product_ID"] . "<br />";

	header("location:../viewPhone.php?Product_ID=" . $_POST["Product_ID"]);
}
else
{
?>
<div class='add_review_box'>
	<div style="width:100%; text-align: center;">Add A New Review</div>
	<form method="post" action="<?php echo getPageURL(); ?>">
		<input type="hidden" name="Product_ID" value="<?php echo $_GET["Product_ID"]; ?>" />
		<input type="hidden" name="Customer_ID" value="<?php echo getLoggedInCustomer()->Customer_ID; ?>"/>
		<table>
			<tr>
				<td>
					Subject: <input type="text" name="Subject" />
				</td>
				<td>
					Rating:
					<select name="Rating">
						<option value="0" selected="selected" disabled="disabled">
						<option value="5">5/5 - Love It!</option>
						<option value="4">4/5 - Really Like It</option>
						<option value="3">3/5 - Like It</option>
						<option value="2">2/5 - Don't Like It</option>
						<option value="1">1/5 - Hate It</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<textarea name="Body" rows="6" style='width: 100%;'></textarea>
				</td>
			</tr>
			<tr>
				<td align="left">
					<input id="cancel_add_review" name="submit" type="button" value="Cancel" />
				</td>
				<td align="right">
					<!-- It's okay to have these both named "submit" because it's not possible to send both -->
					<input name="submit" type="submit" value="Add Review" />
				</td>
			</tr>
		</table>
	</form>


	<script type="text/javascript">

		$("#cancel_add_review").click(function()
		{
			$("#review_area").fadeOut(function()
			{
				$("#addReview").fadeIn();
			});
		});
	</script>
</div>
<?php
}
?>
