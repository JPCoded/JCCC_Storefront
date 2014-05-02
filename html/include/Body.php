<?php
require_once 'Cart.php';
/*
 * This page holds the functions for header, footer and menubar.
 * This keeps them seperate from utils and makes things more organized in some ways
*/
// ensures all pages default to xhtml 1.0 transitional.
function doctype_def()
{
	echo "<!DOCTYPE html>";
}

function header_defs()
{
?>
	<meta content='en-us' http-equiv='Content-Language' />
	<meta content='text/html; charset=utf-8' http-equiv='Content-Type' />

	<script type="text/javascript" src="include/jquery.js"></script>
	<script type="text/javascript" src="include/ajax.js"></script>
	<script type="text/javascript" src="include/utils.js"></script>
	<script type="text/javascript" src="include/modernizr-1.7.js"></script>

	<script type="text/javascript" src="include/CalendarPopup.js"></script>

	<script type="text/javascript">
		var cal = new CalendarPopup("testdiv1");
		cal.showNavigationDropdowns();
		cal.setCssPrefix("calendar ");
	</script>

	<link rel='stylesheet' type='text/css' href='css/menu.css' />
	<link rel='stylesheet' type='text/css' href='css/all_pages.css' />
	<link rel='shortcut icon' type='image/x-icon' href='images/mobile_phone.png'>
<?php
//changed code some so that you can load multiple css with header_defs by just using header_defs("css1","css2","css3",...)
	$num_args = func_num_args();
	if($num_args > 0)
	{
		$css = func_get_args();
		$count = count($css);
		for($i=0; $i < $count;$i++)
			echo "<link rel='stylesheet' type='text/css' href='css/".$css[$i].".css'/>";
	}
}

/**
 * footer_defs holds the footer bar code, as well as the event-handling javascript, as that code
 * needs to be "after" the code where the event happens.
 */
function footer_defs()
{
?>
	<script type="text/javascript" language="javascript">
		// fixes that troublesome background in links.
		$('a').not("[class]").has('img').each(function()
		{
			$(this).css("padding", "0");
			$(this).css("background-image", "none");
		});

		$('a').not("[class]").hover(function()
		{
			$(this).css("background-size", "15px 100%, 15px 100%, " + ($(this).width() - 15) + "px 100%");
			$(this).css("-moz-background-size", "15px 100%, 15px 100%, " + ($(this).width() - 15) + "px 100%");
		});

	</script>

	<br />
	<div id="footer_bar">
		<a class="plain" href='admin.php'>Administrator Login</a>

		<div style="float: right; height: 16px; text-align: right;">
			© Copyrights 2011
		</div>
	</div>
<?php
}

/**
 * Outputs the menu bar, so it's identical for all pages.
 */
function menu_bar()
{
	include "parts/menubar.php";
}
?>
