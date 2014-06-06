
<?php
//SECTION 1
error_reporting(0);
session_start();
require "core.php";
//This script connects us to the database
require "storescripts/connect_to_mysql.php"; 

//This is the variable that we will echo out to show the items from our database 
$dynamicList="";
//Select all items from the database, in order of date added to database
$sql=mysql_query("SELECT * FROM products ORDER BY date_added DESC");
//Count the number of results from the above select query
$productCount=mysql_num_rows($sql);
//If there are items in the database...
if($productCount>0)
{
    //...pull out each row one by one
	while($row = mysql_fetch_array($sql))
    {
	    //product id from the database...
        $id = $row["id"];
		//product name...
		$product_name = $row["product_name"];
		//product price...
		$price = $row["price"];
		//date added to the database, formatted
		$date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
		//This takes the contents of each row and creates a table with them. It then gets the next row, makes a table, and adds 
		//that table to the previous table. So we have several tables, one after the other, in html
		$dynamicList .= '<table width="50%" border="0" cellspacing="0" cellpadding="6">
			<tr>
			    <td width="17%"><a href="product.php?id=' .  $id . '">
				<img style="border:#666 1px solid" src="inventory_images/' .  $id . '.jpg" alt="' . $product_name . '" width="150" height="200" border="1"/>
				</a></td>
				<td width="83%" valign="top">' . $product_name . '<br/>
				€ ' . $price . '<br/>
				<a href="product.php?id=' .  $id . '"color: #e4a40b>View Product Details</a></td>
			</tr>
		</table>';
    }	
} else
{
    //Otherwise, if database is empty, print this message
    $dynamicList="We have no products listed in our store yet.";
}
//Close connection to database
mysql_close();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>NeedleWorks Home Page</title>
		<link rel="stylesheet" href="style/style.css" type="text/css" media="screen"/>			
	<head>
	
	<body>
	    <!--Main div that encloses everything in the body-->
		<div align="center" id="mainWrapper">
		<!--Inserts html code that is saved in header php file-->
		<?php include_once("template_header.php");?>
		<!--Inner div-->
		<div id="pageContent">
		<!--Table that contains our dynamically created tables from the php above-->
		<!--<?php echo $current_file; ?>-->
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr align="left">
		<td>
		<br/><h2><?php echo $_SESSION['username']; ?></h2><br/>
		</td>
		</tr>
		<tr align="center">
			<td width="53%" valign="top">
			<p><h3>Newest Items Added to the Store</h3></p>
			<!--Dynamically inserts all products added to the database-->
			<p><?php echo $dynamicList; ?><br/></p>
		<p><br/></p>	
			</td>
			</tr>
			</table>
		</div>
		<!--Inserts html saved in footer file-->
		<?php include_once("template_footer.php");?>
		</div>
	</body>
</html>