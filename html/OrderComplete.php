<?php
require_once 'include/utils.php';
require_once 'include/MySQLDB.php';
require_once 'include/Cart.php';
require_once 'include/Order.php';
require_once 'include/Customer.php';
require_once 'include/Body.php';

$database = new MySQLDB();

$order = unserialize($_SESSION['order']);
$database->addStatement($order->createOrderInsert());


$count = countCart();
for($i=0;$i< $count;$i++)
{
	$cart=U_Cart($i);
	$di = "INSERT INTO `LineItem` SET `Product_ID` = '". $cart->getPID() . "', `Order_ID` = '" . $order->getOrderID() . "', `Quantity` = '" . $cart->getQuantity() . "', `ModRetail` = '" . $cart->getOfferPrice() . "'";
	$database->addStatement($cart->createSQLUpdateStatement(),$di);
}

doctype_def();
?>
<html>
	<head>
	<title>Check Out</title>
		<?php header_defs(); ?>
	</head>
	<body>
		<div id="wrapper">
			<div id="main">
		<?php
			menu_bar();
			?>
			<div id="PITA">
				<?php
			if($database->transaction())
				echo "<br/>We have recieved your order and your items will be shipped someday.<br/>";
			else
				echo mysql_error($database->getConn()) . "<br/>Error Processing Order. <br />";
		?>
		<a href="index.php">Return Home</a>
			<table width="1024">
				<tr style="width:inherit;height:100px">
					<td></td>
				</tr>
			</table>
			</div>
			</div>
		<?php
			footer_defs();
		?>
		</div>
	</body>
</html>
<?php
	//no longer need cart and order sessions so get rid of them
	unset($_SESSION['cart']);
	unset($_SESSION['order']);
?>
