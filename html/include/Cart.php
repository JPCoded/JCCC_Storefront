<?php
require_once 'utils.php';
require_once 'MySQLDB.php';
require_once 'Product.php';

/* START CLASS */
class Cart
{
	private $PID;
	private $Quantity;
	private $Model;
	private $Manufacturer;
	private $Price;
	private $Retail;
	private $InStock;
	private $Offer;
	private $OfferPrice;

	private $item;

	function __construct($item)
	{
		$this->item = $item;
		$this->PID = $item['Product_ID'];
		$this->Quantity = 1;
		$this->Model = $item['Model'];
		$this->Manufacturer = $item['Manufacturer'];
		$this->Price = $item['Retail'];
		$this->Retail = $item['Retail'];
		$this->InStock = $item['Quantity'];
		$this->Offer = 0;
		$this->OfferPrice = 0.00;
	}
	
	/* **********************************
	 * Get Functions
	*************************************/
	function getPID()
	{ return $this->PID; }
	
	function getQuantity()
	{ return $this->Quantity; }
	
	function getModel()
	{ return $this->Model; }
	
	function getManufacturer()
	{ return $this->Manufacturer; }
	
	function getPrice()
	{ return $this->Price; }
	
	function getRetail()
	{ return $this->Retail; }
	
	function getInStock()
	{ return $this->InStock; }
	
	function getOfferPrice()
	{ return $this->OfferPrice; }
	
	//return offer as XX% Off
	function getOffer()
	{ return round(($this->Offer * 100),2).'% Off';	}
	
	//get Model and Manufacturer
	function getModMan()
	{ return $this->Model." by ".$this->Manufacturer; }
	
	/* **********************************
	 * Set Functions
	*************************************/
	//sets price with 2 leading decimal places
	function setPrice($newPrice = 0)
	{ $this->Price = sprintf("%01.2f",$newPrice); }
	
	//sets offer price with 2 leading decimal places
	function setOfferPrice($newOfferPrice = 0)
	{ $this->OfferPrice = sprintf("%01.2f",$newOfferPrice); }
		
	function setOffer($offer = 0)
	{ $this->Offer = $offer; }
	
	function setQuantity($qty=0) //set to 0 because if set to 1 it makes it so you can't actually set quantity to 1, instead would just increment by 1
	{
		 //if qty is more than or equal to InStock, then Quantity equals InStock
		if($qty >= $this->InStock)
		{
			$this->Quantity = $this->InStock;
		}
		elseif($qty == 0) //if qty equals 0, it means item already exists in cart so we add 1 to it
		{
			//if Quantity is less than instock, increment by 1 else just make quantity equal instock
			($this->Quantity < $this->InStock) ? ($this->Quantity += 1) : ($this->Quantity = $this->InStock);
		}
		else
		{
			$this->Quantity = $qty;
		}
		
		if($this->Offer == 0)
		{
			$this->setPrice(($this->Quantity * $this->Retail));
		}
		else
		{
			$this->setOfferPrice(round(($this->Retail - ($this->Retail * $this->Offer)),2));
			
			$this->setPrice(($this->Quantity * $this->OfferPrice));
		}
	}	
	
	/* **********************************
	 * Other Functions
	*************************************/
	
	function hasOffer()
	{ return ($this->Offer == 0) ? TRUE : FALSE; }
	
	/* **********************************
	 * SQL Functions
	*************************************/
	
	//update the quantity of the item in database
	function createSQLUpdateStatement()	
	{
		$qty = $this->InStock - $this->Quantity;
		return "UPDATE Product SET `Quantity`='$qty' WHERE `Product_ID`='$this->PID'";
	}
	
	//gets the percentoff from offer by joining off and Product_has_Offer
	function createSQLOfferStatement() 
	{
		return "SELECT Offer.PercentOff FROM Offer JOIN Product_has_Offer ON Product_has_Offer.Offer_ID = Offer.Offer_ID WHERE Product_ID = '$this->PID'";
	}	
}
/* END OF CLASS */

/***************************************************************************************************************
* Misc Functions *
***************************************************************************************************************/

//if shopping cart is set, return true otherwise return false
function cartIsSet()
{
	return (isset($_SESSION['cart']) ? TRUE : FALSE);
}

//return number of items in cart minus given number
function countCart($subtract = 0)
{
	return count($_SESSION['cart']) - $subtract;
}

//unserialze cart
function U_Cart($idx)
{
	return unserialize($_SESSION['cart'][$idx]);
}

function checkOffer($sql)
{
	$con = db_connection_init();
	$result = mysql_query($sql); 
	$numOffers = mysql_num_rows($result);	
	if($numOffers == 0)
	{
		return 0;
	}
	else
	{
		$row = mysql_fetch_array($result);				
		return $row['PercentOff'];
	}
}
/***************************************************************************************************************
* 
***************************************************************************************************************/
function addToCart($item)
{
	//if item avaliable
	if($item['Quantity'] != 0)
	{
		$cart = new Cart($item); //create new cart item
		$sql = $cart->createSQLOfferStatement();
		$offer = checkOffer($sql);
		$cart->setOffer($offer);
		if(cartIsSet())	//if the cart is already set
		{
			$check=FALSE;	//to check if item exsits
			$count = countCart();
			//loop through all items in cart
			for($i=0;$i<$count;$i++)
			{
				$ccart = U_Cart($i); //unserialize cart at index i so we can access it
				//if item in cart matches the product id of the item we are going to add
				if($ccart->getPID() == $item['Product_ID'])
				{
					$check=TRUE;	//item exists in cart
					$ccart->setQuantity(); //increments item qty by 1
					$_SESSION['cart'][$i] = serialize($ccart); //serialize the cart item and put it in session
				}
			}

			//if it is new item serialize and add to array
			if($check != TRUE)
			{
				$cart->setQuantity(1);
				array_push($_SESSION['cart'],serialize($cart));
			}
		}
		else
		{
			$cart->setQuantity(1);
			//item didn't exist in cart so adding it to the cart
			$_SESSION['cart'][0] = serialize($cart);
		}
	}
}

function Delete_Item($idx)
{
	//create temp array
	$arrTemp = array();
	$count = countCart(1);
	for($i=0;$i <= $count;$i++) //go through carts items
	{
		//check if current item is to be removed, if it's not the we put it into the temp array
		if(!in_array($i,$idx))
		{
			array_push($arrTemp,$_SESSION['cart'][$i]);
		}
	}
	$_SESSION['cart'] = $arrTemp; //the session now equals new array with selected items removed
}
?>
