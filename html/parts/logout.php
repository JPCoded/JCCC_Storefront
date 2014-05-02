<?php
$ref = (isset($_POST["ref"]) ? $_POST["ref"] : "index.php");

if (isset($_POST["yes"]))
{
	session_start();

	session_destroy();

	unset($_POST["logout"]);

	header("location:$ref");
}
elseif (isset($_POST["no"]))
{
	header("location:$ref");
}
else
{
?>

	<div align="center">
		<form action="parts/logout.php" method="POST">
			<input type="hidden" name="logout" />
			<input type="hidden" name="ref" value="<?php echo $ref; ?>" />
			<h3>Are you sure you want to logout?</h3>

			<?php
				if (cartIsSet() && countCart() > 0)
				{
					echo "Warning! This will clear your shopping cart.<br />";
				}
			?>

			<input type="submit" name="yes" value="Yes" />
			<?php echo spacer(10); ?>
			<input type="submit" name="no" value="No" />
		</form>
	</div>

<?php
}
?>