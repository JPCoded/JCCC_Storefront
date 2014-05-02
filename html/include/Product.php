<?php
require_once 'utils.php';
require_once 'MySQLDB.php';
require_once 'Offer.php';
require_once 'Favorite.php';

class Product
{
	var $Product_ID;
	var $Model;
	var $Manufacturer;
	var $Description;
	var $OS;
	var $Retail;
	var $Quantity;
	var $ReleaseDate;

	var $row;

	private $offers_current = array();
	private $offers_all = array();

	function __construct($row)
	{
		$this->row = $row;

		$this->Product_ID = ($row["Product_ID"] == null ? "NULL" : $row["Product_ID"]);
		$this->Model = $row["Model"];
		$this->Manufacturer = $row["Manufacturer"];
		$this->Description = $row["Description"];
		$this->OS = $row["OS"];
		$this->Retail = $row["Retail"];
		$this->Quantity = $row["Quantity"];
		$this->ReleaseDate = $row["ReleaseDate"];

		$this->offers_current = $this->init_loadOffers(true);
		$this->offers_all = $this->init_loadOffers(false);
	}

	private function init_loadOffers($currentOnly)
	{
		$con1 = db_connection_init();

		//$db = new MySQLDB();

		$offers = array();

		$current = "";

		if ($currentOnly)
		{
			$current = "AND `BeginDate` <= now()
						AND `EndDate` >= now()";
		}

		$result = mysql_query("SELECT
									`Offer`.*,
									unix_timestamp(`Offer`.`BeginDate`) AS `U_BeginDate`,
									unix_timestamp(`Offer`.`EndDate`) AS `U_EndDate`
								FROM
									`Offer`, `Product_Has_Offer`
								WHERE
									`Offer`.`Offer_ID` = `Product_Has_Offer`.`Offer_ID` AND
									`Product_ID` = '$this->Product_ID'
									$current
								", $con1);

									if (!$result)
									{
										return array();
									}

									while ($a = mysql_fetch_array($result))
									{
										$offers[] = new Offer($a);
									}

									return $offers;
	}

	/**
	 * Loads the product from the database with the given product ID. If no product is found, it returns null.
	 *
	 * If no product ID is specified, it returns all products in an array.
	 */
	static function loadFromDB($PID = null)
	{
		$con1 = db_connection_init();

		if ($PID != null)
		{
			$result = mysql_query("SELECT * FROM  `Product` WHERE  `Product_ID` = '" . $PID . "'", $con1);

			if (!$result)
			{
				echo mysql_error($con1);
				return null;
			}

			$a = mysql_fetch_array($result);

			//mysql_close($con1);

			return new Product($a);
		}
		else
		{
			$result = mysql_query("SELECT * FROM  `Product`", $con1);

			if (!$result)
			echo mysql_error($con1);

			$arr = array();
			$r = null;

			while ($r = mysql_fetch_array($result))
			{
				$arr[] = new Product($r);
			}

			mysql_free_result($result);

			return $arr;
		}
	}

	/**
	 * Returns all the currently active offers for this product. If $currentOnly is set to false, it
	 * returns all offers for this product, whether they are expired, current, or pending.
	 */
	public function getOffers($currentOnly = true)
	{
		if ($currentOnly)
		return $this->offers_current;
		else
		return $this->offers_all;
	}

	/**
	 * Returns the current retail after all discounts - if any - are applied. This function should be used
	 * when showing the customer what they would currently pay, i.e. search, view, invoices, etc.
	 */
	public function getActiveRetail()
	{
		return number_format($this->Retail - $this->getCurrentDiscount(), 2);
	}

	/**
	 * Returns the savings on this product. This is retail * discount. So, if a $90.00 product is 20% off,
	 * it will return $18.00
	 */
	public function getCurrentDiscount()
	{
		if ($this->getCurrentDiscountPercent() == 0)
		return 0;

		return number_format( $this->Retail * $this->getCurrentDiscountPercent(), 2);
	}

	/**
	 * Returns the current discount percentage, i.e. 10% off as the decimal 0.10
	 */
	public function getCurrentDiscountPercent()
	{
		$discounts = array();

		foreach ($this->getOffers() as $o)
		{
			$discounts[] = $o->PercentOff;
		}

		$total_discount = 0;

		foreach ($discounts as $d)
		{
			$total_discount += $d;
		}

		return $total_discount;
	}

	public function isFavorite()
	{
		$c = getLoggedInCustomer();

		if ($c)
		{
			$favs = Favorite::loadFromDB($c->Customer_ID);

			foreach ($favs as $f)
			{
				if ($f->Product_ID == $this->Product_ID)
				{
					return true;
				}
			}
		}

		return false;
	}
}

?>
