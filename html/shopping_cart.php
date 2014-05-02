<?php
require_once 'include/utils.php';
require_once 'include/Cart.php';
require_once 'include/Body.php';
require_once 'include/MySQLDB.php';
require_once 'include/Product.php';

//check if get is set and not equal, then $action = get otherwise $action = 'view'
$action = isset($_POST['action']) ? $_POST['action'] : 'view';

//stops shopping_cart.php from being the ref value I think. don't remember if it was needed still or not...
if(isset($_POST['ref']))
{
	$_SESSION['ref'] = $_POST['ref'];
}

switch($action)
{
	case 'add':
		$DB = new MySQLDB();
		$Product_ID = $_POST['Product_ID'];		
		$DB->ssResults("SELECT * FROM `Product` WHERE `Product_ID`='$Product_ID' LIMIT 1");
		addToCart($DB->fetchArray());
		//$DB->close();
		header("Location:shopping_cart.php"); //important, prevents the shopping cart from continuously adding the item when/if user click refresh button
		break;
	case 'Update':
		$qty = $_POST['quantity'];
		$n = count($qty);
		//go through cart
		for($i = 0; $i < $n; $i++)
		{
			$cart = U_Cart($i); //unserialize
			if($cart->getQuantity() != $qty[$i]) //if quantity in the saved shopping cart doesn't equal the new quantity
			{
				$cart->setQuantity($qty[$i]); //update the quantity
				$_SESSION['cart'][$i] = serialize($cart); //save to cart
			}
		}
			header("location:shopping_cart.php");
		break;
	case 'Remove':
		if(isset($_POST['rm']))
		{
			$rm = $_POST['rm'];
			Delete_Item($rm);
		}
		header("location:shopping_cart.php");
		break;
	case 'view' :
}

doctype_def();
?>

<html>
	<head>
		<title>Shopping Cart</title>
			<?php header_defs("cart"); ?>
	</head>
	<body>
		<div id="wrapper">
			<div id="main">
				<?php
					menu_bar();
				?>
					<div id="PITA">
				<?php
					if(cartIsSet() && countCart() > 0)
					{
						$subTotal=0;
				?>

				<h2>Shopping Cart</h2>
					<br />
					<script type="text/javascript" language="javascript">
						function submitCart(getsome)
						{
							document.shopping_cart.action.value = getsome;
							document.shopping_cart.submit();
						}
					</script>

						<table id="cart">
						<form action="shopping_cart.php" method="POST" name="shopping_cart">
						<input type="hidden" name="action" id="action" value="" />
						<input type="hidden" name="ref" value="<?php echo $_SESSION['ref']; ?>" />
						<tr>
						<td colspan="5"><a href="javascript:void(1);" onclick="submitCart('Update');"><?php getButton("Update","Update",20); ?></a><a href="javascript:void(1);" onclick="submitCart('Remove');"><?php echo spacer(5); getButton("Remove","Remove",20); ?></a></td>
						</tr>
							<tr>
								<th><input type="checkbox" name="select-all" id="select-all" /></th>
								<th>Product(s)</th>
								<th>Qty.</th>
								<th>Offers</th>
								<th>Total</th>
							</tr>

							<?php
								$count = countCart();
								for($i=0;$i<$count;$i++)
								{
									$cart = U_Cart($i);
							?>
									<tr>
										<!-- Checkboxes -->
										<td>
											<input type='checkbox' name='rm[]' id='rm' value='<?php echo $i; ?>'/>
										</td>
										<!-- Image, Model and Manu -->
										<td>
											<img height=50 width=50 align='middle' src='phone_img/<?php echo $cart->getPID(); ?>.png' /> <?php echo spacer(4); echo $cart->getModMan(); ?>
										</td>
										<!-- Quantity -->
										<td>
											<input type='text' name='quantity[]' id='quantity' size='2' value='<?php echo $cart->getQuantity(); ?>' />
										</td>
										<!-- Offers -->
										<td>
										<?php echo ($cart->hasOffer() ? "--" : $cart->getOffer()); ?>
										</td>
										<!-- Price -->
										<td>
											$<?php echo $cart->getPrice(); ?>
										</td>
									</tr>
							<?php
									$subTotal +=  $cart->getPrice();
								}
							 ?>
							<tr>
								<td	align="right" colspan="4">
									<b>Subtotal:</b>
								</td>
								<td>$<?php echo sprintf("%01.2f",$subTotal); ?></td>
							</tr>
						</table>
						<br />

						<a href="<?php echo $_SESSION['ref'];?>"><?php getButton("ContShopping","Continue Shopping"); ?></a>
						<?php echo spacer(5); ?>
						<a href="payment.php"><?php getButton("Checkout","Checkout"); ?></a>
						<?php
							$_SESSION['subTotal']=$subTotal; //used in check_out
						} //check to see if the shopping cart is set but has no items. such as user deleting all items
						else
						{
							if (cartIsSet() && countCart() <=0)
								{unset($_SESSION['cart']);}
						?>
						<br />
						Your Shopping Cart is currently empty. <br/><br/>
						Please click on button below or the back button on your browser to continue shopping.
						<br />
						<br />
						<a href="<?php echo $_SESSION['ref']; ?>"><?php getButton("ContShopping","Continue Shopping"); ?></a>
					<?php
					}
					?>
					<table width="1024">
						<tr style="width:inherit;height:100px">
							<td></td>
						</tr>
					</table>
				</form>
			</div>
				<?php footer_defs(); ?>
			</div>
		</div>
	</body>

		<script type="text/javascript" language="javascript">
			// Listen for click on toggle checkbox
			$('#select-all').click(function(event) {
			    if(this.checked) {
			        // Iterate each checkbox
			        $(':checkbox').each(function() {
			            this.checked = true;
			        });
			    }
			});
		</script>
</html>
