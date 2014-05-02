<div align="center">
	<form id="do_logout" action="" name="do_logout">
		Are you sure you want to logout? <br/>
		This will clear your shopping cart.
	</form>
	<br/>
	<button id="logout_btn">Logout</button>
	<button id="cancel_btn">Cancel</button>
	
</div>
<script type="text/javascript">
	$("#logout_btn").click(function()
	{
		$.post('parts/logout_popup.php', function()
		{
			window.location.reload(true);
		});
	});

	$("#cancel_btn").click(function()
	{
		$("#login_box").slideToggle("fast");
	});
</script>
