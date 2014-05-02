<script type="text/javascript">

	function validateSignupForm() {
		// code to perform validation and display error messages goes here
		if (document.getElementsByName("User_ID").item(0).value == "" ||
		    document.getElementsByName("User_PWD").item(0).value == "" ||
		    document.getElementsByName("FirstName").item(0).value == "" ||
		    document.getElementsByName("LastName").item(0).value == "" ||
		    document.getElementsByName("ShippingAddress").item(0).value == "" ||
		    document.getElementsByName("ShippingCity").item(0).value == "" ||
		    document.getElementsByName("ShippingState").item(0).value == "" ||
		    document.getElementsByName("ShippingZip").item(0).value == "" ||
		    document.getElementsByName("BillingAddress").item(0).value == "" ||
		    document.getElementsByName("BillingCity").item(0).value == "" ||
		    document.getElementsByName("BillingState").item(0).value == "" ||
		    document.getElementsByName("BillingZip").item(0).value == "" ||
		    document.getElementsByName("Email").item(0).value == "" ||
		    document.getElementsByName("PhoneNumber").item(0).value == "") {

			// see if there is already a SignupErrorsTable showing (otherwise returns null)
			var signupErrorsTable = document.getElementsByName("SignupErrorsTable").item(0);

			if (signupErrorsTable) {  // if SignupErrorsTable is present, clear it for reuse
				while (signupErrorsTable.firstChild) {  // clear all rows in SignupErrorsTable
					signupErrorsTable.removeChild(signupErrorsTable.firstChild);
				}
			}
			else {  // otherwise create a new table, inside a new div

				// create a SignupErrorsTableDiv
				var signupErrorsTableDiv = document.createElement("div");
				signupErrorsTableDiv.setAttribute("align", "center");
				signupErrorsTableDiv.setAttribute("name", "SignupErrorsTableDiv");

				// create a SignupErrorsTable
				signupErrorsTable = document.createElement("table");
				signupErrorsTable.setAttribute("class", "signupErrors");
				signupErrorsTable.setAttribute("name", "SignupErrorsTable");

				// add the SignupErrorsTable to the SignupErrorsTableDiv
				signupErrorsTableDiv.appendChild(signupErrorsTable);

				// insert the SignupErrorsTableDiv into the page, before the signup form
				var signupFormDiv = document.getElementsByName("SignupFormDiv").item(0);
				signupFormDiv.parentNode.insertBefore(signupErrorsTableDiv, signupFormDiv);
			}


			// add a row with a "fields left blank" error message to SignupErrorsTable
			var fieldLeftBlankError = signupErrorsTable.insertRow(-1);
			fieldLeftBlankError.innerHTML = "<td colspan=\"2\" align=\"center\"><div class=\'errortext\'>One or more required fields left blank</div></td>";


			return false;
		}

		return true;  // stub
	}

	function resetSignupForm() {
		// see if there is already a SignupErrorsTableDiv showing (otherwise returns null)
		var signupErrorsTableDiv = document.getElementsByName("SignupErrorsTableDiv").item(0);

		if (signupErrorsTableDiv) {  // if SignupErrorsTableDiv is present, remove it
			signupErrorsTableDiv.parentNode.removeChild(signupErrorsTableDiv);
		}

		// clear all of the signup form fields
		document.getElementsByName("User_ID").item(0).removeAttribute("value");
		document.getElementsByName("User_PWD").item(0).removeAttribute("value");
		document.getElementsByName("FirstName").item(0).removeAttribute("value");
		document.getElementsByName("LastName").item(0).removeAttribute("value");
		document.getElementsByName("ShippingAddress").item(0).removeAttribute("value");
		document.getElementsByName("ShippingCity").item(0).removeAttribute("value");
		document.getElementsByName("ShippingState").item(0).removeAttribute("value");
		document.getElementsByName("ShippingZip").item(0).removeAttribute("value");
		document.getElementsByName("BillingAddress").item(0).removeAttribute("value");
		document.getElementsByName("BillingCity").item(0).removeAttribute("value");
		document.getElementsByName("BillingState").item(0).removeAttribute("value");
		document.getElementsByName("BillingZip").item(0).removeAttribute("value");
		document.getElementsByName("Email").item(0).removeAttribute("value");
		document.getElementsByName("PhoneNumber").item(0).removeAttribute("value");
	}

</script>

<div align="center" name="SignupFormDiv">
	<form name="SignupForm" method="post" action="myAccount.php" onsubmit="return validateSignupForm();">
		<input type="hidden" name="ref" value="<?php echo $_POST["ref"]; ?>">

		<table class='signup' name="SignupTable">
			<tr>
				<th colspan="2">
					<div align="center">
						Customer Signup
					</div>
				</th>
			</tr>
			<tr>
				<td>
					<span title="This will be your user login.">User Name:</span>
				</td>
				<td>
					<input type="text" name="User_ID"<?php if (isset($_POST['User_ID'])) echo (" value=\"" . $_POST['User_ID'] . "\""); ?>/>
				</td>
				<!--<td>
					<input type="button" value="Check Availability" onclick="do something">
				</td>-->
			</tr>
			<tr>
				<td>
					Password:
				</td>
				<td>
					<input type="password" name="User_PWD"<?php if (isset($_POST['User_PWD'])) echo (" value=\"" . $_POST['User_PWD'] . "\""); ?>/>
				</td>
			</tr>
			<tr>
				<td>
					First Name:
				</td>
				<td>
					<input type="text" name="FirstName"<?php if (isset($_POST['FirstName'])) echo (" value=\"" . $_POST['FirstName'] . "\""); ?>/>
				</td>
			</tr>
			<tr>
				<td>
					Last Name:
				<td>
					<input type="text" name="LastName"<?php if (isset($_POST['LastName'])) echo (" value=\"" . $_POST['LastName'] . "\""); ?>/>
				</td>
			</tr>
			<tr>
				<td>
					Shipping Address:
				</td>
				<td>
					<input type="text" name="ShippingAddress"<?php if (isset($_POST['ShippingAddress'])) echo (" value=\"" . $_POST['ShippingAddress'] . "\""); ?>/>
				</td>
			</tr>
			<tr>
				<td align="right">
					City:
				</td>
				<td>
					<input type="text" name="ShippingCity"<?php if (isset($_POST['ShippingCity'])) echo (" value=\"" . $_POST['ShippingCity'] . "\""); ?>/>
				</td>
			</tr>
			<tr>
				<td align="right">
					State:
				</td>
				<td>
					<input type="text" name="ShippingState"<?php if (isset($_POST['ShippingState'])) echo (" value=\"" . $_POST['ShippingState'] . "\""); ?>/>
				</td>
			</tr>
			<tr>
				<td align="right">
					Zip:
				</td>
				<td>
					<input type="text" name="ShippingZip"<?php if (isset($_POST['ShippingZip'])) echo (" value=\"" . $_POST['ShippingZip'] . "\""); ?>/>
				</td>
			</tr>

			<tr>
				<td>
					Billing Address:
				</td>
				<td>
					<input type="text" name="BillingAddress"<?php if (isset($_POST['BillingAddress'])) echo (" value=\"" . $_POST['BillingAddress'] . "\""); ?>/>
				</td>
			</tr>
			<tr>
				<td align="right">
					City:
				</td>
				<td>
					<input type="text" name="BillingCity"<?php if (isset($_POST['BillingCity'])) echo (" value=\"" . $_POST['BillingCity'] . "\""); ?>/>
				</td>
			</tr>
			<tr>
				<td align="right">
					State:
				</td>
				<td>
					<input type="text" name="BillingState"<?php if (isset($_POST['BillingState'])) echo (" value=\"" . $_POST['BillingState'] . "\""); ?>/>
				</td>
			</tr>
			<tr>
				<td align="right">
					Zip:
				</td>
				<td>
					<input type="text" name="BillingZip"<?php if (isset($_POST['BillingZip'])) echo (" value=\"" . $_POST['BillingZip'] . "\""); ?>/>
				</td>
			</tr>

			<tr>
				<td>
					Email Address:
				</td>
				<td>
					<input type="text" name="Email"<?php if (isset($_POST['Email'])) echo (" value=\"" . $_POST['Email'] . "\""); ?>/>
				</td>
			</tr>
			<tr>
				<td>
					Phone Number:
				</td>
				<td>
					<input type="text" name="PhoneNumber"<?php if (isset($_POST['PhoneNumber'])) echo (" value=\"" . $_POST['PhoneNumber'] . "\""); ?>/>
				</td>
			</tr>



				<tr>
					<th colspan="2" align="center">
						<input type="reset" value="Clear" onclick="resetSignupForm();"/>
						<?php echo spacer(10); ?>
						<input type="submit" value="Signup Now"/>
					</th>
				</tr>


		</table>

	</form>
</div>
