<?php
//This function stops automatic notices (not errors) from appearing on this page
error_reporting(0);
//Starts session
session_start();
//If the user is logged in...
if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id']))
{
    //...display a link to their cart
	$cart = '<td width="68%" align="right"><a href="http://localhost/E-Commerce/cart.php">Your Cart</a>';
//Otherwise...
} else
{
    //...display links to the admin section and to the registration page
	$cart = '';
	$register = '<tr>
		<td colspan="2" align="right">
		<a href="http://localhost/E-Commerce/register.php"><strong>Register</strong></a>
		</td>
		</tr>';
}
?>

<div id="pageHeader">
    <table width="100%" border="0" cellspacing="0" cellpadding="12">
	    <tr>
		<td colspan="2" align="right">
		<?php include "header_login.php"; ?>
		</td align="right">
		</tr>
		<?php echo $register; ?>
		<tr>
			<!--This table cell contains the logo that will display at the top of all our pages-->
			<td width="32%"><a href="http://localhost/E-Commerce/index.php">
			<img src="http://localhost/E-Commerce/style/logo.jpg" alt="Logo" width="252 height="36" border="0"/></a></td>
			<!--This cell contains a link to cart.php-->
			<?php echo $cart; ?>
		</tr>
		<!--This row contains links to the home page, the products page, and the contacts page-->
		<tr >
		    <td colspan="2" ><a href="http://localhost/E-Commerce/index.php" style="font-size:20px"> &nbsp; &nbsp; <strong>Home</strong></a> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
			<a href="http://localhost/E-Commerce/help.php" style="font-size:20px"><strong>Help</strong></a> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
			<a href="http://localhost/E-Commerce/contact.php" style="font-size:20px"><strong>Contact</strong></a></td>
		</tr>	
	</table>
</div>