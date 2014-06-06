<?php
error_reporting(0);
//Start the session
session_start();
//Connect to the databse
include"storescripts/connect_to_mysql.php";

//If the user has submitted a shipping_address to add to the database using the html form...
if (isset($_POST['shipping_address']))
{
    //...assign each of the submitted variables to a local variable
	//The 'mysql_real_escape_string' escapes special characters in the variable so that it can be used in a SQL statement 
    $shipping_address=mysql_real_escape_string($_POST['shipping_address']);
	$shipping_address2=mysql_real_escape_string($_POST['shipping_address2']);
	$shipping_city=mysql_real_escape_string($_POST['shipping_city']);
	$shipping_county=mysql_real_escape_string($_POST['shipping_county']);
	$shipping_postalcode=mysql_real_escape_string($_POST['shipping_postalcode']);
	$shipping_country=mysql_real_escape_string($_POST['shipping_country']);
	
	
	
	//Add the customer to the database
    $customer_id = $_SESSION['user_id'];
	$sql=mysql_query("Select * FROM shipping_address WHERE customerID='$customer_id' LIMIT 1");
	$customerMatch=mysql_num_rows($sql);
	if ($customerMatch > 0)
	{
	    $sql=mysql_query("UPDATE shipping_address SET shipping_address='$shipping_address', shipping_address2='$shipping_address2', city='$shipping_city',
	                      county='$shipping_county', zip_code='$shipping_postalcode', country='$shipping_country', date_added=now() 
						  WHERE customerID='$customer_id'") or die (mysql_error());
	} else
	{
	    $sql=mysql_query("INSERT INTO shipping_address(shipping_address, shipping_address2, city, county, zip_code, country, date_added, customerID)
	                      VALUES('$shipping_address','$shipping_address2', '$shipping_city', '$shipping_county', '$shipping_postalcode', '$shipping_country',
	                      now(), '$customer_id')") or die (mysql_error());
	}
	
	header("location: confirmation.php ");
	exit();
}
//Close connection to database
mysql_close();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Inventory List</title>
		<link rel="stylesheet" href="style/style.css" type="text/css" media="screen"/>	
        <script type="text/javascript" language="javascript" src="storescripts/storescripts.js"></script>		
	</head>
	
	<body>
	    <div align="center" id="mainWrapper">
		<!--Include the html for the header-->
		<?php include_once("template_header.php");?>
		<div id="pageContent"><br/>
		<div align="left" style="margin-left:24px;">
		<h2>Please Enter Your Shipping Address Below</h2>
		</div>
		<div align="left" style="margin-left:24px;">
		<p>Required information *</p>
		</div>
		<div>
		<br/>
		<br/>
        </div>
		<!--Form for entering customer payment details to be added to the database-->
		<form action="shipping_info.php" enctype="multipart/form_data" name="shippingForm" id="shippingForm" method="post">
		<table width="90%" border="0" cellspacing="0" cellpadding="6">
		<tr>
		<td><strong>Address *</strong></td>
		<td><label>
		<input name="shipping_address" type="text" size="64">
		</label></td>
		</tr>
		<tr>
		<td></td>
		<td><label>
		<input name="shipping_address2" type="text" size="64">
		</label></td>
		</tr>
		<tr>
		<td><strong>City/Town *</strong></td>
		<td><label>
		<input name="shipping_city" type="text" size="64">
		</label></td>
		</tr>
		<tr>
		<td><strong>County/State</strong></td>
		<td><label>
		<input name="shipping_county" type="text" size="64">
		</label></td>
		</tr>
		<tr>
		<td><strong>Postal/Zip Code</strong> <br/>(if you have one)</td>
		<td><label>
		<input name="shipping_postalcode" type="text" size="64">
		</label></td>
		</tr>
		<tr>
		<td><strong>Country *</strong></td>
		<td><label>
		<select name="shipping_country" >
        <option value="AF" ></option>
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
		<option value="BF" >BURKINA FASO</option>
		<option value="BI" >BURUNDI</option>
		<option value="CM" >CAMA0ROON</option>
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
		<option value="MY" >MALAYSIA</option>
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
		<option value="RS" >SERBIA</option>
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
		</select>
		</label></td>
		</tr>
		<tr>
		<td>
		<br/>
		<br/>
		</td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		<td><label>
		<!--This line is for the form's submit button. This is where the javascript function comes into play-->
		<input type="submit" name="shipping_button" id="shipping_button" value="Finalise Purchase" onclick="javascript:return validateMyShipping();"/>
		</label>
		</td>	
		</tr>
		</table>
		</form>
		<br/>
		<br/>
		<br/>
		<br/>
		</div>
		<!--Insert the html for the footer-->
		<?php include_once("template_footer.php");?>
		</div>
	</body>
</html>