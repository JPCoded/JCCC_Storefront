<?php
require_once '../include/utils.php';
require_once '../include/Body.php';
require_once '../include/Product.php';
require_once '../include/Product_Has_Offer.php';

?>

<script type="text/javascript">
	function showValue(newValue)
	{
		document.getElementById("range").innerHTML=newValue + "%";
	}
</script>

<div align="center">
	<h2>Add A New Special Offer</h2>

	<form id="offerForm" method="post" enctype="multipart/form-data">

		<table style="border-width: 1; border-style: solid;">
			<tr>
				<td valign="top">
					Description:
				</td>
				<td>
					<textarea rows="6" style="width: 200px;" name="Description"></textarea>
				</td>
			</tr>
			<tr>
				<td>
					Begin Date:
				</td>
				<td>
					<input type="text" id="BeginDate" name="BeginDate" />
					<a class="plain" href="#"
						onclick="cal.select(getElementById('BeginDate'),'anchor1','yyyy-MM-dd'); return false;"
						name="anchor1" id="anchor1">select
					</a>
				</td>
			</tr>
			<tr>
				<td>
					End Date:
				</td>
				<td>
					<input type="text" id="EndDate" name="EndDate" />
					<a class="plain" href="#"
						onclick="cal.select(getElementById('EndDate'),'anchor2','yyyy-MM-dd'); return false;"
						name="anchor2" id="anchor2">select
					</a>
				</td>
			</tr>
			<tr>
				<td>
					Percent Off:
				</td>
				<td>
					<input type="range" min="0" max="100" value="0" step="5" id="slider" name="PercentOff" onchange="showValue(this.value)" />
					<div id="range" style="min-width: 35px; display: inline-block;">0%</div>
				</td>
			</tr>
			<tr>
				<td>
					Attached Products:
				</td>
				<td>
					<select multiple="multiple" size="6" style="width: 200px;" name="ProductList[]">
						<?php
							$prods = Product::loadFromDB();

							foreach ($prods as $prod)
							{
								echo "<option value='$prod->Product_ID'>$prod->Model</option>\n";
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="right">
				</td>
			</tr>
		</table>
	</form>
	<button id="showbox">Add Special Offer</button>
</div>
<div id="testdiv1" style="color: black; position:absolute; visibility:hidden; background-color:white; layer-background-color:white;"></div>

<div id="submit_offer"></div>

<script type="text/javascript">
<!--
	var tID;

	function tickTimer(t)
	{
		if(t > 0)
		{
			$("#timer").html(t + " secs remain");
			t--;
			tID = setTimeout("tickTimer('" + t + "')", 1000);
		}
		else
		{
			killTimer(tID);
	    }
	}

	function killTimer(id)
	{
		clearTimeout(id);

		if ($("#submit_offer:contains('Offer Successfully Added!')").length)
			$("#offerForm").get(0).reset();

		$("#submit_offer").css({visibility: "hidden"});
	}

	$("#showbox").click(function()
	{
		$("#submit_offer").css({visibility: "visible"});

		$.post('admin/submitOffer.php', $("#offerForm").serialize(), function(data)
		{
			$("#submit_offer").html(data + "<span id='timer'></span>");
			tickTimer(5);
		});

		//$("#submit_offer").html("Here's a box!<br/>It disappears in 5 seconds.");

	});
//-->
</script>
