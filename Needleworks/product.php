<?php
//This function avoid the appearance of unwanted notices
error_reporting(0);
//Begin session
session_start();
//Connect to the database
include "storescripts/connect_to_mysql.php";

//If the user clicked on the product on the index page, run the following script
if (isset($_GET['id']))
{
    $_SESSION['product_id'] = $_GET['id'];

	// Assign the product GET variable to a local variable
	$id= $_GET['id'];
	//Select all products from database that have the id of the product that was selected by user
	$sql=mysql_query("SELECT * FROM products WHERE id='$id' LIMIT 1");
	//Count the number of records returned
	$productCount=mysql_num_rows($sql);
	//If at least one record was returned...
    if($productCount>0)
	{
	    //...pull out each returned record
		 while($row = mysql_fetch_array($sql))
        {
		    //Assign the record's attributes to local variables for displaying in the html
		    $product_name = $row["product_name"];
		    $price = $row["price"];
			$details = $row["details"];
			$category = $row["category"];
			$stock = $row["stock"];
		    $date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
    }	
	//If no records were returned...
	} else
	{
	    //Print out this message
	    echo "That item does not exist.";
	    exit();
	}
//If, somehow, the user gets to this page without clicking on a product, but the session id is somehow set...
}  
if (!isset($_GET['id']) && isset($_SESSION['product_id']))
{
	// Assign the product id, accessed through the session variable to a local variable
	$id= $_SESSION['product_id'];
	//Select all products from database that have the id of the product that was selected by user
	$sql=mysql_query("SELECT * FROM products WHERE id='$id' LIMIT 1");
	//Count the number of records returned
	$productCount=mysql_num_rows($sql);
	//If at least one record was returned...
    if($productCount>0)
	{
	    //...pull out each returned record
		 while($row = mysql_fetch_array($sql))
        {
		    //Assign the record's attributes to local variables
		    $product_name = $row["product_name"];
		    $price = $row["price"];
			$details = $row["details"];
			$category = $row["category"];
			$stock = $row["stock"];
		    $date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
        }	
	//If no records were returned...
	} else
	{
	    //Print out this message
	    echo "That item does not exist.";
	    exit();
	}
//If, somehow, the user gets to this page without clicking on a product, and no session variable is set...
}   
if(!isset($_GET['id']) && !isset($_SESSION['product_id']))
{
    //...print the following message to screen
	echo "Data to render this page is missing.";
	exit();
}
if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id']))
{
    //This is the button that will allow the user to add an item to their shopping cart
	$cart_button = '<form id="form1" name="form1" method="post" action="cart.php">
			        <input type="hidden" name="pid" id="pid" value="<?php echo $id; ?>"/>
			        <input type="submit" name="button" id="button" value="Add to Shopping Cart"/>
			        </form>';

} else
{
    //However, if the user is not logged in (but has somehow reached this page), the button will not display
    $cart_button = '';
}
//Close the database connection
mysql_close();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title><?php echo $product_name;?></title>
		<link rel="stylesheet" href="style/style.css" type="text/css" media="screen"/>			
	<head>
	
	<body>
	    <div align="center" id="mainWrapper">
		<!--Insert the html for the header-->
		<?php include_once("template_header.php");?>
		
		<div id="pageContent">
		<a href="index.php"><h2 align="right">Return to Products&nbsp;&nbsp;&nbsp;</h2></a>
		<!--This table dynamically presents the details for the relevant product, using the local variables that we defined above-->
		<table width="100%" border="0" cellspacing="0" cellpadding="15">
		<tr>
		    <td width="20%" valign="top"><a href="inventory_images/<?php echo $id; ?>.jpg" target="_blank">
			<div class="morph pic">
			<img src="inventory_images/<?php echo $id; ?>.jpg" width="300" height="300" alt="<?php echo $product_name; ?>"/></a></td><br/>
			</div>
			<!--<a href="inventory_images/<?php echo $id; ?>.jpg">View Full Size Image</a></td>-->
			<td width="80%" valign="top"><h3><?php echo $product_name; ?></h3>
			<p><?php echo "$" . $price; ?><br />
			<br/>
			<?php echo $category; ?><br/>
			<br/>
			<?php echo $details;?><br/>
			<br/>
			<p>Items in stock: <?php echo $stock;?></p>
			<br/>
			</p>
            <!--This form send POST variables to cart.php, which we use to add product to the shopping cart-->
			<?php echo $cart_button; ?>
			</td>
			</tr>
			</table>		
		</div>
		<!--Insert html for the footer-->
		<?php include_once("template_footer.php");?>
		</div>
	</body>
</html>