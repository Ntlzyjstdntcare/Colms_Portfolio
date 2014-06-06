<?php 
//SECTION 1
error_reporting(0);
//Start a session in order to use session variables
session_start();
//Connect to the database
include "storescripts/connect_to_mysql.php";
//Create a sessionID variable for later use.
$sessionID = session_id();

//Loop through the array of product ids that we set up on the cart page.
foreach($_SESSION["id_array"]as $each_item)
{
	//Select all attributes for each product
	$sql = mysql_query("SELECT * FROM products WHERE id= '".mysql_real_escape_string($each_item)."' LIMIT 1");
	
	while($row = mysql_fetch_array($sql))
	{ 
        //If we have zero stock available of a particular product, ask the user to remove that item from their cart.
		if ($row["stock"] == 0)
        {
            $product_name = $row["product_name"];
			$_SESSION["product_name"] = $row["product_name"];
			echo'You have attempted to order an item (' . $product_name . ') that is out of stock.  Please click <a href="cart.php">here</a> to 
			return to cart, and remove item from cart before progressing.';
		    exit();
		}	
	}		                				
}		
?>

<?php
//SECTION 2
//We assign the cart total to a local variable for use later
if(isset($_POST['cartTotal']))
{
	$cartTotal = $_POST['cartTotal'];	
}
?>


<?php
//SECTION 3
//If the user has submitted the form and indicated that their delivery address is different to their card address...
if (isset($_POST['first_name']) && isset($_POST['different_address']))
{
    //...assign each of the submitted variables to a local variable (we are not saving the user's card details)
	//The 'mysql_real_escape_string' escapes special characters in the variable so that it can be used in a SQL statement 
    $first_name=mysql_real_escape_string($_POST['first_name']);
	$surname=mysql_real_escape_string($_POST['surname']);
	$card_address=mysql_real_escape_string($_POST['card_address']);
	$card_address2=mysql_real_escape_string($_POST['card_address2']);
	$card_city=mysql_real_escape_string($_POST['card_city']);
	$card_county=mysql_real_escape_string($_POST['card_county']);
	$card_postalcode=mysql_real_escape_string($_POST['card_postalcode']);
	$card_country=mysql_real_escape_string($_POST['card_country']);
	$card_phone=mysql_real_escape_string($_POST['card_phone']);
	$card_email=mysql_real_escape_string($_POST['card_email']);
	
	//See if the customer is already in the system.
	$sql=mysql_query("SELECT id FROM users WHERE address='$card_address' AND first_name = '$first_name' LIMIT 1");
	$productMatch=mysql_num_rows($sql);
	if ($productMatch > 0)
	{
	    //If they are, give them this message and give them the chance to make a new choice. Do not run the rest of this script.
		echo 'You are already in our system. Please <a href="confirmation.php">click here</a> to submit your order.';
		exit();
	}
	
	//if the customer is not in the system, add it to the database
	//Run an sql query to insert the customer details into the database
	$id = $_SESSION['user_id'];
	$sql=mysql_query("UPDATE users SET first_name='$first_name', surname='$surname', address='$card_address',
	address2='$card_address2', city_town='$card_city', county_state='$card_county', postal_code='$card_postalcode', country='$card_country', 
	telephone='$card_phone', email='$card_email', customer_session='$sessionID' WHERE id=$id");
	
	//Finally direct customer to form for entering delivery address
	header("location: shipping_info.php ");
	exit();
}
//If the user has submitted the form and not indicated that their delivery address is different to their card address...
if (isset($_POST['card_number']) && !isset($_POST['different_address']))
{
    //...assign each of the submitted variables to a local variable
    $first_name=mysql_real_escape_string($_POST['first_name']);
	$surname=mysql_real_escape_string($_POST['surname']);
	$card_address=mysql_real_escape_string($_POST['card_address']);
	$card_address2=mysql_real_escape_string($_POST['card_address2']);
	$card_city=mysql_real_escape_string($_POST['card_city']);
	$card_county=mysql_real_escape_string($_POST['card_county']);
	$card_postalcode=mysql_real_escape_string($_POST['card_postalcode']);
	$card_country=mysql_real_escape_string($_POST['card_country']);
	$card_phone=mysql_real_escape_string($_POST['card_phone']);
	$card_email=mysql_real_escape_string($_POST['card_email']);
	
	//See if the customer is already in the system.
	$sql=mysql_query("SELECT id FROM users WHERE address='$card_address' AND first_name = '$first_name' LIMIT 1");
	$productMatch=mysql_num_rows($sql);
	if ($productMatch > 0)
	{
	    //If they are, give them this message and give them the chance to make a new choice. Do not run the rest of this script.
		echo 'You are already in our system. Please <a href="confirmation.php">click here</a> to submit your order.';
		exit();
	}
	//if the customer is not in the system, add them to the database
	//Run an sql query to insert the customer details into the database
	$sql=mysql_query("UPDATE users SET first_name='$first_name', surname='$surname', address='$card_address',
	address2='$card_address2', city_town='$card_city', county_state='$card_county', postal_code='$card_postalcode', country='$card_country', 
	telephone='$card_phone', email='$card_email', date_added=now(), customer_session='$sessionID' WHERE id=$id");;	  
	
	//Send the user to the confirmation page.
	header("location: confirmation.php");
	exit();
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Checkout Page</title>
		<link rel="stylesheet" href="style/style.css" type="text/css" media="screen"/>			
	    <!--This javascript function will not allow the user to submit the below form unless all the fields are filled in. It must return true
		or the user will be given one of the listed prompts.-->
		<script type="text/javascript" language="javascript" src="storescripts/storescripts.js">
		
	</script>
	</head>
	
	<body>
	    <div align="center" id="mainWrapper">
		<!--Include the html for the header-->
		<?php include_once("template_header.php");?>
		<div id="pageContent"><br/>
		<div align='left' style="margin-left:24px;">
		<h1><strong>Cart Total: €<?php echo $cartTotal; ?></strong></h1>
		</div>
		<div align="left" style="margin-left:24px;">
		<h2>Please Enter Your Payment Details Below</h2>
		</div>
		<div align="left" style="margin-left:24px;">
		<p>Required information *</p>
		</div>
		<!--Form for entering customer payment details to be added to the database-->
		<form action="checkout.php" enctype="multipart/form_data" name="checkoutForm" id="checkoutForm" method="post">
		<table width="90%" border="0" cellspacing="0" cellpadding="6">
		<tr>
		<td width="20%"><strong>First Name *</strong></td>
		<td width="80%"><label>
		<input name="first_name" type="text" id="first_name" size="64"/>
		</label></td>
		</tr>
		<tr>
		<td><strong>Surname *</strong></td>
		<td><label>
		<input name="surname" type="text" id="surname" size="64"/>
		</label></td>
		</tr>
		<tr>
		<td><strong>Card Type *</strong></td>
		<td><label>
		<select name="card_type" id="card_type">
		<option value=""></option>
		<option value="Mastercard">Mastercard</option>
		<option value="Visa">Visa</option>
		<option value="Laser">Laser</option>
		<option value="Maestro">Maestro</option>
		</select>
		</label></td>
		</tr>
		<tr>
		<td><strong>Card Number *</strong></td>
		<td><label>
		<input name="card_number" type="text" id="card_number" size="19">
		</label></td>
		</tr>
  <tr> 
    <td height="22"  valign="middle"><strong>Valid To: *</strong></td>
    <td>
      <SELECT NAME="expires_month" >
        <OPTION VALUE="" SELECTED>--Month--</option>
        <OPTION VALUE="01">January (01)</option>
        <OPTION VALUE="02">February (02)</option>
        <OPTION VALUE="03">March (03)</option>
        <OPTION VALUE="04">April (04)</option>
        <OPTION VALUE="05">May (05)</option>
        <OPTION VALUE="06">June (06)</option>
        <OPTION VALUE="07">July (07)</option>
        <OPTION VALUE="08">August (08)</option>
        <OPTION VALUE="09">September (09)</option>
        <OPTION VALUE="10">October (10)</option>
        <OPTION VALUE="11">November (11)</option>
        <OPTION VALUE="12">December (12)</option>
      </SELECT> /
      <SELECT NAME="expires_year">
        <OPTION VALUE="" SELECTED>--Year--</option>
        
        <OPTION VALUE="14">2014</option>
        <OPTION VALUE="15">2015</option>
		<OPTION VALUE="04">2016</option>
        <OPTION VALUE="05">2017</option>
        <OPTION VALUE="06">2018</option>
      </SELECT>
    </td>
  </tr>
		<tr>
		<td><strong>CVV (if present)</strong></td>
		<td><label>
		<input name="cvv" type="text" size="19">
		</label></td>
		</tr>
		<tr>
		<td align="right">
		<img src="style/CVV.jpg" alt="CVV">
		</td>
		</tr>
		<tr>
		<h2>Card Address</h2>
		</tr>
		<tr>
		<td><strong>Address *</strong></td>
		<td><label>
		<input name="card_address" type="text" size="64">
		</label></td>
		</tr>
		<tr>
		<td></td>
		<td><label>
		<input name="card_address2" type="text" size="64">
		</label></td>
		</tr>
		<tr>
		<td><strong>City/Town *</strong></td>
		<td><label>
		<input name="card_city" type="text" size="64">
		</label></td>
		</tr>
		<tr>
		<td><strong>County/State</strong></td>
		<td><label>
		<input name="card_county" type="text" size="64">
		</label></td>
		</tr>
		<tr>
		<td><strong>Postal/Zip Code</strong> <br/>(if you have one)</td>
		<td><label>
		<input name="card_postalcode" type="text" size="64">
		</label></td>
		</tr>
		<tr>
		<td><strong>Country *</strong></td>
		<td><label>
		<select name="card_country" >
        <option value="AF" >AFGHANISTAN</option>
		<option value="AS" >AFRICAN SAMOA</option>
		<option value="AL" >ALBANIA</option>
		<option value="DZ" >ALGERIA</option>
		<option value="AD" >ANDORRA</option>
		<option value="AO" >ANGOLA</option>
		<option value="AI" >ANGUILLA</option>
		<option value="AQ" >ANTARCTICA</option>
		<option value="AG" >ANTIGUA AND BARBUDA</option>
		<option value="AR" >ARGENTINA</option>
		<option value="AM" >ARMENIA</option>
		<option value="AW" >ARUBA</option>
		<option value="AU" >AUSTRALIA</option>
		<option value="AT" >AUSTRIA</option>
		<option value="AZ" >AZERBAIJAN</option>
		<option value="BS" >BAHAMAS</option>
		<option value="BH" >BAHRAIN</option>
		<option value="BD" >BANGLADESH</option>
		<option value="BB" >BARBADOS</option>
		<option value="BY" >BELARUS</option>
		<option value="BE" >BELGIUM</option>
		<option value="BZ" >BELIZE</option>
		<option value="BJ" >BENIN</option>
		<option value="BM" >BERMUDA</option>
		<option value="BT" >BHUTAN</option>
		<option value="BO" >BOLIVIA</option>
		<option value="BA" >BOSNIA AND HERZEGOWIA</option>
		<option value="BW" >BOTSWANA</option>
		<option value="BV" >BOUVET ISLAND</option>
		<option value="BR" >BRAZIL</option>
		<option value="IO" >BRITISH INDIAN OCEAN TERRITORY</option>
		<option value="BN" >BRUNEI DARUSSALAM</option>
		<option value="BG" >BULGARIA</option>
		<option value="BF" >BURKI6.0 FASO</option>
		<option value="BI" >BURUNDI</option>
		<option value="CM" >CAMAROON</option>
		<option value="KH" >CAMBODIA</option>
		<option value="CA" >CANADA</option>
		<option value="CV" >CAPE VERDE</option>
		<option value="KY" >CAYMAN ISLANDS</option>
		<option value="CF" >CENTRAL AFRICAN REPUBLIC</option>
		<option value="TD" >CHAD</option>
		<option value="CL" >CHILE</option>
		<option value="CN" >CHINA</option>
		<option value="CX" >CHRISTMAS ISLAND</option>
		<option value="CC" >COCOS (KEELING) ISLANDS</option>
		<option value="CO" >COLOMBIA</option>
		<option value="KM" >COMOROS</option>
		<option value="CG" >CONGO</option>
		<option value="CK" >COOK ISLANDS</option>
		<option value="CR" >COSTA RICA</option>
		<option value="CI" >COTE D'IVOIRE</option>
		<option value="HR" >CROATIA</option>
		<option value="CU" >CUBA</option>
		<option value="CY" >CYPRUS</option>
		<option value="CZ" >CZECH REPUBLIC</option>
		<option value="DK" >DENMARK</option>
		<option value="DJ" >DJIBOUTI</option>
		<option value="DM" >DOMINICA</option>
		<option value="DO" >DOMINICAN REPUBLIC</option>
		<option value="TP" >EAST TIMOR</option>
		<option value="EC" >ECUADOR</option>
		<option value="EG" >EGYPT</option>
		<option value="SV" >EL SALVADOR</option>
		<option value="GQ" >EQUATORIAL GUINEA</option>
		<option value="ER" >ERITREA</option>
		<option value="EE" >ESTONIA</option>
		<option value="ET" >ETHIOPIA</option>
		<option value="FK" >FALKLAND ISLANDS</option>
		<option value="FO" >FAROE ISLANDS</option>
		<option value="FJ" >FIJI</option>
		<option value="FI" >FINLAND</option>
		<option value="FR" >FRANCE</option>
		<option value="FX" >FRANCE, METROPOLITAN</option>
		<option value="GF" >FRENCH GUIANA</option>
		<option value="PF" >FRENCH POLYNESIA</option>
		<option value="TF" >FRENCH SOUTHERN TERRITORIES</option>
		<option value="GA" >GABON</option>
		<option value="GM" >GAMBIA</option>
		<option value="GE" >GEORGIA</option>
		<option value="DE" >GERMANY</option>
		<option value="GI" >GIBRALTAR</option>
		<option value="GR" >GREECE</option>
		<option value="GL" >GREENLAND</option>
		<option value="GD" >GRENADA</option>
		<option value="GP" >GUADELOUPE</option>
		<option value="GU" >GUAM</option>
		<option value="GT" >GUATEMALA</option>
		<option value="GN" >GUINEA</option>
		<option value="GW" >GUINEA-BISSAU</option>
		<option value="GY" >GUYANA</option>
		<option value="HT" >HAITI</option>
		<option value="HM" >HEARD AND MC DONALD ISLANDS</option>
		<option value="HN" >HONDURAS</option>
		<option value="HK" >HONG KONG</option>
		<option value="HU" >HUNGARY</option>
		<option value="IS" >ICELAND</option>
		<option value="IN" >INDIA</option>
		<option value="IR" >IRAN</option>
		<option value="IQ" >IRAQ</option>
		<option value="IE" selected="true" >IRELAND</option>
		<option value="IL" >ISRAEL</option>
		<option value="IT" >ITALY</option>
		<option value="JM" >JAMAICA</option>
		<option value="JP" >JAPAN</option>
		<option value="JO" >JORDAN</option>
		<option value="KZ" >KAZAKHSTAN</option>
		<option value="KE" >KENYA</option>
		<option value="KI" >KIRIBATI</option>
		<option value="KP" >KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF</option>
		<option value="KR" >KOREA, REPUBLIC OF</option>
		<option value="KW" >KUWAIT</option>
		<option value="KG" >KYRGYZSTAN</option>
		<option value="LA" >LAO PEOPLE'S DEMOCRATIC REPUBLIC</option>
		<option value="LV" >LATVIA</option>
		<option value="LB" >LEBANON</option>
		<option value="LS" >LESOTHO</option>
		<option value="LR" >LIBERIA</option>
		<option value="LY" >LIBYAN ARAB JAMAHIRIYA</option>
		<option value="LI" >LIECHTENSTEIN</option>
		<option value="LT" >LITHUANIA</option>
		<option value="LU" >LUXEMBOURG</option>
		<option value="MO" >MACAU</option>
		<option value="MK" >MACEDONIA, FORMER YUGOSLAV REPUBLIC OF</option>
		<option value="MG" >MADAGASCAR</option>
		<option value="MW" >MALAWI</option>
		<option value="MV" >MALDIVES</option>
		<option value="ML" >MALI</option>
		<option value="MT" >MALTA</option>
		<option value="MH" >MARSHALL ISLANDS</option>
		<option value="MQ" >MARTINIQUE</option>
		<option value="MR" >MAURITANIA</option>
		<option value="MU" >MAURITIUS</option>
		<option value="YT" >MAYOTTE</option>
		<option value="MX" >MEXICO</option>
		<option value="FM" >MICRONESIA, FEDERATED STATES OF</option>
		<option value="MD" >MOLDOVA, REPUBLIC OF</option>
		<option value="MC" >MONACO</option>
		<option value="MN" >MONGOLIA</option>
		<option value="MS" >MONTSERRAT</option>
		<option value="MA" >MOROCCO</option>
		<option value="MZ" >MOZAMBIQUE</option>
		<option value="MM" >MYANMAR</option>
		<option value="NA" >NAMIBIA</option>
		<option value="NR" >NAURU</option>
		<option value="NP" >NEPAL</option>
		<option value="NL" >NETHERLANDS</option>
		<option value="AN" >NETHERLANDS ANTILLES</option>
		<option value="NC" >NEW CALEDONIA</option>
		<option value="NZ" >NEW ZEALAND</option>
		<option value="NI" >NICARAGUA</option>
		<option value="NE" >NIGER</option>
		<option value="NU" >NIUE</option>
		<option value="NF" >NORFOLK ISLAND</option>
		<option value="MP" >NORTHERN MARIA6.0 ISLANDS</option>
		<option value="NO" >NORWAY</option>
		<option value="OM" >OMAN</option>
		<option value="PW" >PALAU</option>
		<option value="PA" >PANAMA</option>
		<option value="PG" >PAPUA NEW GUINEA</option>
		<option value="PY" >PARAGUAY</option>
		<option value="PE" >PERU</option>
		<option value="PH" >PHILIPPINES</option>
		<option value="PN" >PITCAIRN</option>
		<option value="PL" >POLAND</option>
		<option value="PT" >PORTUGAL</option>
		<option value="PR" >PUERTO RICO</option>
		<option value="QA" >QATAR</option>
		<option value="RE" >REUNION</option>
		<option value="RO" >ROMANIA</option>
		<option value="RU" >RUSSIAN FEDERATION</option>
		<option value="RW" >RWANDA</option>
		<option value="KN" >SAINT KITTS AND NEVIS</option>
		<option value="LC" >SAINT LUCIA</option>
		<option value="VC" >SAINT VINCENT AND THE GRENADINES</option>
		<option value="WS" >SAMOA</option>
		<option value="SM" >SAN MARINO</option>
		<option value="ST" >SAO TOME AND PRINCIPE</option>
		<option value="SA" >SAUDI ARABIA</option>
		<option value="SN" >SENEGAL</option>
		<option value="SC" >SEYCHELLES</option>
		<option value="SL" >SIERRA LEONE</option>
		<option value="SG" >SINGAPORE</option>
		<option value="SK" >SLOVAKIA (Slovak Republic)</option>
		<option value="SI" >SLOVENIA</option>
		<option value="SB" >SOLOMON ISLANDS</option>
		<option value="SO" >SOMALIA</option>
		<option value="ZA" >SOUTH AFRICA</option>
		<option value="ES" >SPAIN</option>
		<option value="LK" >SRI LANKA</option>
		<option value="SH" >ST. HELENA</option>
		<option value="PM" >ST. PIERRE AND MIQUELON</option>
		<option value="SD" >SUDAN</option>
		<option value="SR" >SURINAM</option>
		<option value="SJ" >SVALBARD AND JAN MAYEN ISLANDS</option>
		<option value="SZ" >SWAZILAND</option>
		<option value="SE" >SWEDEN</option>
		<option value="CH" >SWITZERLAND</option>
		<option value="SY" >SYRIAN ARAB REPUBLIC</option>
		<option value="TW" >TAIWAN</option>
		<option value="TJ" >TAJIKISTAN</option>
		<option value="TH" >THAILAND</option>
		<option value="TG" >TOGO</option>
		<option value="TK" >TOKELAU</option>
		<option value="TO" >TONGA</option>
		<option value="TT" >TRINIDAD AND TOBAGO</option>
		<option value="TN" >TUNISIA</option>
		<option value="TR" >TURKEY</option>
		<option value="TM" >TURKMENISTAN</option>
		<option value="TC" >TURKS AND CAICOS ISLANDS</option>
		<option value="TV" >TUVALU</option>
		<option value="UG" >UGANDA</option>
		<option value="UA" >UKRAINE</option>
		<option value="AE" >UNITED ARAB EMIRATES</option>
		<option value="GB" >UNITED KINGDOM</option>
		<option value="US" >UNITED STATES</option>
		<option value="UY" >URUGUAY</option>
		<option value="UZ" >UZBEKISTAN</option>
		<option value="VU" >VANUATU</option>
		<option value="VA" >VATICAN CITY STATE (HOLY SEE)</option>
		<option value="VE" >VENEZUELA</option>
		<option value="VG" >VIRGIN ISLANDS (BRITISH)</option>
		<option value="VI" >VIRGIN ISLANDS (U.S.)</option>
		<option value="WF" >WALLIS AND FUTUNA ISLANDS</option>
		<option value="EH" >WESTERN SAHARA</option>
		<option value="YE" >YEMEN</option>
		<option value="YU" >YUGOSLAVIA</option>
		<option value="ZR" >ZAIRE</option>
		<option value="ZM" >ZAMBIA</option>
		<option value="ZW" >ZIMBABWE</option>
		<option value="RS" >SERBIA</option>
		<option value="MY" >MALAYSIA</option>
		</select>
		</label></td>
		</tr>
		<tr>
		<td><strong>Telephone</strong></td>
		<td><label>
		<input name="card_phone" type="text" size="64">
		</label></td>
		</tr>
		<tr>
		<td><strong>Email Address *</strong></td>
		<td><label>
		<input name="card_email" type="text" size="64">
		</label></td>
		</tr>
		<tr>
		<td>Delivery address is different from card address</td>
		<td><label>
		<input type="checkbox" name="different_address" id="different_address" value=""/>
		</label></td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		<td><label>
		<!--This line is for the form's submit button. This is where the javascript function comes into play-->
		<input type="submit" name="checkout_button" id="checkout_button" value="Proceed With Purchase" onclick="javascript:return validateCheckoutForm();"/>
		</label></td>
		</tr>
		</table>
		</form>
		<br/>
		<br/>
		<br/>
		</div>
		<!--Insert the html for the footer-->
		<?php include_once("template_footer.php");?>
		</div>
	</body>
</html>