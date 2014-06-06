<?php
error_reporting(0);
//Begin session
session_start();	
//Connect to database
include "storescripts/connect_to_mysql.php";
//Create sessionID variable for later use.
$sessionID = session_id();
//Create local variable for later use
$id = $_SESSION['user_id'];
//If the cart array exists...
if(isset($_SESSION['cart_array']))
{
	//...loop through the array
	foreach($_SESSION['cart_array'] as $each_item)
	{
		//Assign the product id, name and quantity to local variables
		$product_id=$each_item['item_id'];
		$quantity = $each_item['quantity'];
				
		//Insert order details into databse
		$sql = mysql_query("INSERT INTO orders (quantity, custID, productID, date_added, orders_session)
		VALUES ('$quantity', '$id', '$product_id', now(), '$sessionID')") or die (mysql_error());
		//Get stock of product
		$sql=mysql_result(mysql_query("SELECT stock FROM products WHERE id='$product_id' LIMIT 1"), 0);
		
		
		//Set it's new stock to old stock minus amount of order
		$new_stock = $sql - $quantity;
		$sql = mysql_query("UPDATE products SET stock='$new_stock' WHERE id='$product_id'") or die (mysql_error());
	}	
}
?>

<?php


//Destroy the session

session_regenerate_id();

session_destroy();
session_unset();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Thank You!</title>
		<link rel="stylesheet" href="style/style.css" type="text/css" media="screen"/>			
	<head>
	
	<body>
	    <div align="center" id="mainWrapper">
		<!--Include the html for the header-->
		<?php include_once("confirmation_template_header.php");?>
		<div id="pageContent"><br/>
		<h2><br/><br/><br/><br/>Your order has been submitted! Thank you for shopping with NeedleWorks.<br/><br/><br/><br/><br/><br/></h2>
		</div>
		<!--Insert the html for the footer-->
		<?php include_once("template_footer.php");?>
		</div>
	</body>
</html>