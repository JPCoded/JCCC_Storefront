<table width='1024' border=0>
	<tr style='width:inherit;'>
		<td width='254' rowspan="3">
			<a href='index.php'><img src='images/logo.jpg' width='255' height='66' /></a>
		</td>
		<td style='width: 168px' rowspan="3"></td>
		<td style='width: 208px' rowspan="3" valign="bottom">
			<a class='plain' href='http://www.youtube.com'><img src='images/youtube.png' width='25' height='25' alt='YouTube' /></a>
			<a class='plain' href='http://www.twitter.com'><img src='images/twitter.png' width='25' height='25' alt='Twitter' /></a>
			<a class='plain' href='http://www.facebook.com'><img src='images/facebook.png' width='25' height='25' alt='Facebook' /></a>
		</td>
		<td width='163' align='center' style='color: #4E358C; width: 150px; padding-top:20px;' rowspan="3">
			<form name="shopcart" action="shopping_cart.php" method="post">
				<?php if (strpos(getPageURL(), "shopping_cart.php") === false)  // if shopping_cart.php is not in the current page's URL
					{	?><input type="hidden" name="ref" value="<?php echo getPageURL(); ?>" /><?php	}  // post the current page's URL as ref
				?>
				<a class='plain' href='#' onclick='document.shopcart.submit()' target='_self'>
					<?php getButton("ShoppingCart","Shopping Cart"); ?>
				</a>
			</form>
		</td>
		<td class="login_text">
			<form id="login_form" name="myacct" action="myAccount.php" method="post">
				<input type="hidden" name="ref" value="<?php echo getPageURL(); ?>" />
				<?php
					if (customerIsLoggedIn())
					{
						$c = loadCustomerFromDB($_SESSION["myusername"]);

						echo "Welcome " . $c->User_ID . ". ";
						//echo "<input type='hidden' name='logout' />";
						//echo "<a href='#' onclick='document.myacct.submit()'>Logout</a>";
					?>
						<input type='hidden' name='logout' />
						<a href="#" id="logout_show">Logout</a>
					<?php
					}
					else
					{
						echo "Not logged in. ";
						//echo "";
						//echo "<a href='#' onclick='document.myacct.submit()'>Login</a>";
					?>
						<input type='hidden' name='login' />
						<a href="#" id="login_show">Login</a>
					<?php
					}
				?>
			</form>
		</td>
	</tr>
	<tr>
		<td width='173'>
			<!-- SEARCH BAR CODE -->
			<form style='background-color: white' method='get' action='gridsearch.php' enctype='text/plain' name='Search' style='border: thin solid #808080; margin: 7px auto auto auto; background-color: #E8E8E8; width: 153px;'>
				<input type='text' style='width: 120px; color: grey;' value='Search' name='Model' onfocus="clearText(event, 'Search'); setTextBlack(event);" onblur="restoreText(event, 'Search'); setTextGreyIf(event, 'Search');"/>
				<span class='button' onClick='validateSearch()'><img style='width: 16px; height: 16px' src='images/search.png' /></span>
			</form>
		</td>
	</tr>
</table>

<div class="menu">
	<ul>
		<li>
			<span class="menu_r">
				<a href="index.php" target="_self"><span class="menu_ar">Home</span></a>
			</span>
		</li>
		<li>
			<span class="menu_r">
				<a href="gridsearch.php?ReleaseDate" target="_self"><span class="menu_ar">Whats New</span></a>
			</span>
		</li>
		<li>
			<span class="menu_r">
				<a href="gridsearch.php" target="_self"><span class="menu_ar">Phones</span></a>
			</span>
		</li>
		<li>
			<span class="menu_r">
				<a href="gridsearch.php?Offers" target="_self"><span class="menu_ar">Special Offers</span></a>
			</span>
		</li>
		<li>
			<span class="menu_r">
				<?php
				if (getLoggedInCustomer())
				{
				?>
					<a href='gridsearch.php?Favorites' target='_self'><span class='menu_ar'>Favorites</span></a>
				<?php
				}
				else
				{
				?>
					<form name="myacct3" action="myAccount.php" method="post">
						<input type="hidden" name="ref" value="<?php echo substr(getPageURL(), 0, strrpos(getPageURL(), '/') + 1) . "gridsearch.php?Favorites"; ?>" />

						<a href='#' onclick='document.myacct3.submit()' target='_self'><span class='menu_ar'>Favorites</span></a>
					</form>
				<?php
				}
				?>
			</span>
		</li>
		<li>
			<span class="menu_r">
				<a href="Reviews.php" target="_self"><span class="menu_ar">Reviews</span></a>
			</span>
		</li>
		<li>
			<span class="menu_r">
			<form name="myacct2" action="myAccount.php" method="post">
				<input type="hidden" name="ref" value="<?php echo substr(getPageURL(), 0, strrpos(getPageURL(), '/') + 1) . "myAccount.php"; ?>" />

				<a href='#' onclick='document.myacct2.submit()' target='_self'><span class='menu_ar'>My Account</span></a>
			</form>
			</span>
		</li>
	</ul>
	<br class="clearit" />
</div>

<div id="login_box">
</div>

<script type="text/javascript">
<!--

	// this has the effect of monitoring the state of #login_box's visibility. This eliminates unnecessary
	// ajax calls and also allows for finer control of behaviors.
	var is_shown = false;

	$("#logout_show").click(function()
	{
		if (!is_shown)
		{
			var pos = $("#logout_show").offset();
			var width = $("#logout_show").width();

			$("#login_box").css(
			{
				left: (pos.left + width - 240) + "px",
				top: (pos.top + 20) + "px",
				width: "240px",
				background: "#BDEDFF"
			});

			//$("#login_box").load('parts/logout_confirm.php');

			$.post('parts/logout_confirm.php', $("#login_form").serialize(), function(data)
			{
				$("#login_box").html(data);
			});

			$("#login_box").slideDown("fast", function()
			{
				is_shown = true;
			});
		}
		else
		{
			$("#login_box").slideUp("fast");
			is_shown = false;
		}
	});

	$("#login_show").click(function()
	{
		if (!is_shown)
		{
			var pos = $("#login_show").offset();
			var width = $("#login_show").width();

			$("#login_box").css(
			{
				left: (pos.left + width - 200) + "px",
				top: (pos.top + 20) + "px",
				width: "240px",

				background: "#BDEDFF"
			});

			$("#login_box").load('parts/login_form.php');

			$("#login_box").slideDown("fast", function()
			{
				is_shown = true;
			});
		}
		else
		{
			$("#login_box").slideUp("fast");
			is_shown = false;
		}
	});


	//checks if mouse clicked inside login box, if true set mouse_is_inside to true, if mouse clicked anywhere else false
	var mouse_is_inside = false;

    $('#login_box').hover(function(){
        mouse_is_inside=true;
    }, function(){
        mouse_is_inside=false;
    });
	//if anywhere on webpage is clicked and the mouse isn't inside the login box, slide the box up.
    $("html").click(function(){
        if(! mouse_is_inside && is_shown)
        {
          	$('#login_box').slideUp("fast", function()
            {
                // this fixes the bug where clicking on the login link after #login_box is visible would
                // make the box slide up and then right back down.
              	is_shown = false;
          	});

        }
    });

//-->
</script>
