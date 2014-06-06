<?php
//SECTION 1
//Start session in order to use session variables
session_start();
//Connect to the database
include"../storescripts/connect_to_mysql.php";
//If somehow the user has reached this page without the manager session variable being set... 
if(!isset($_SESSION["manager"]))
{
    //...send them to the login page
	header("location: admin_login.php");
	exit();
}

//If the session variable is set, check that the user is actually in the database.
//Assign the session variables to local variables
$managerID= $_SESSION["id"];
$manager= $_SESSION["manager"];
$password= $_SESSION["password"];

//Select all records from the database that match the user details (returning max one result)
$sql=mysql_query("SELECT * FROM users WHERE id='$managerID' AND username='$manager' AND password='$password' AND admin='true' LIMIT 1");
//Count the number of returned results
$existCount=mysql_num_rows($sql);
//If there are no returned results...
if($existCount==0)
{
    //...give the user this message and don't run the rest of this script
    echo"Your login session data is not on record in the database.";
    exit();
}	
?>
<?php
//SECTION 2
//If user chooses to delete item from database in section 4...
if(isset($_GET['deleteid']))
{
    //...ask the user for confirmation of deletion
	echo 'Do you really want to delete product with ID of ' . $_GET['deleteid'] . '? <a href="inventory_list.php?yesdelete=' . $_GET['deleteid'].'">Yes</a>/
	<a href="inventory_list.php">No</a>';
	exit();
}
//If user confirms that they want to delete the item...
if (isset($_GET['yesdelete']))
{
    //...assign the get variable to a local variable
    $id_to_delete=$_GET['yesdelete'];
	//run a query to delete the product that has the same id as the id that is attached to the get variable. 
	$sql=mysql_query("DELETE FROM products WHERE id='$id_to_delete' LIMIT 1") or die (mysql_error);
	//Then send the user back to the inventory list
	header("location: inventory_list.php");
	exit();
}
?>
<?php
//SECTION 3
//If the user has submitted a product name to add to the database using the html form...
if (isset($_POST['product_name']))
{
    //...assign each of the submitted variables to a local variable
	//The 'mysql_real_escape_string' escapes special characters in the variable so that it can be used in a SQL statement 
    $product_name=mysql_real_escape_string($_POST['product_name']);
	$price=mysql_real_escape_string($_POST['price']);
	$category=mysql_real_escape_string($_POST['category']);
	$details=mysql_real_escape_string($_POST['details']);
	$stock = mysql_real_escape_string($_POST['stock']);
	//See if the product name is already in the system.
	$sql=mysql_query("SELECT id FROM products WHERE product_name='$product_name' LIMIT 1");
	$productMatch=mysql_num_rows($sql);
	if ($productMatch > 0)
	{
	    //If it is, give the user this message and give them the chance to make a new choice. Do not run the rest of this script.
		echo 'Sorry you tried to place a duplicate "Product Name" into the system, <a href="inventory_list.php">click here</a>';
		exit();
	}
	
	//if the product name is not in the system, add it to the database
	//Run an sql query to insert the product details into the database
	$sql=mysql_query("INSERT INTO products(product_name, price, details, category, stock, date_added)
	  VALUES('$product_name','$price', '$details', '$category', '$stock', now())") or die (mysql_error());
	//Assign the auto-incremented id of the new product in the database to a local variable
	header("location: inventory_list.php");
	exit();
}
?>
<?php
//SECTION 4
//Grabs the whole list for viewing.
//Create a local variable and assign it an empty string
$product_list="";
//Select all products from the database, ordering them by the date that they were added to the database
$sql=mysql_query("SELECT * FROM products ORDER BY date_added DESC");
//Count the number of records returned by the query
$productCount=mysql_num_rows($sql);
//If the number is greater than 0...
if($productCount>0)
{
    //...pull out each record one by one
    while($row = mysql_fetch_array($sql))
    {
	    //Assign that record's attributes to local variables
        $id = $row["id"];
		$product_name = $row["product_name"];
		//This formats the date
		$date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
		//Edit the $product_list variable that we will echo out later, that contains the details of every product, and the option to edit or delete them
		$product_list .= "$date_added - $id - <strong>$product_name</strong> &nbsp; &nbsp; &nbsp; <a href='inventory_edit.php?pid=$id'>edit</a> &bull; 
		<a href='inventory_list.php?deleteid=$id'>delete</a><br/>";
    }	
} else
{
    //Otherwise, if there are no products in the database, this message will be echoed out
    $product_list="You have no products listed in your store yet.";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Inventory List</title>
		<link rel="stylesheet" href="../style/style.css" type="text/css" media="screen"/>			
		<script type="text/javascript" language="javascript" src="../storescripts/storescripts.js"></script>
	<head>
	
	<body>
	    <div align="center" id="mainWrapper">
		<!--Include the html for the header-->
		<?php include_once("template_header.php");?>
		<div id="pageContent"><br/>
		<!--Clicking on this link sends the user directly to the Inventory Form below-->
		<div align="right" style="margin-right:32px"><a href="inventory_list.php#inventoryForm">+ Add New Inventory Item</a></div>
		<div align="left" style="margin-left:24px;">
		<!--This prints off the products that are already in the database by echoing the $product_list variable that we created in section 4-->
		<h2>Inventory List</h2>
		<?php echo $product_list;?>
		</div>
		<!--This line is how the link up above knows where on the page to send the user-->
		<a name="inventoryForm" id="inventoryForm"></a>
		<h3>
		 Add New Inventory Item Form 
		</h3>
		<!--Form for entering product details to be added to the database-->
		<form action="inventory_list.php" enctype="multipart/form_data" name="listForm" id="listForm" method="post">
		<table width="90%" border="0" cellspacing="0" cellpadding="6">
		<tr>
		<td width="20%">Product Name</td>
		<td width="80%"><label>
		<input name="product_name" type="text" id="product_name" size="64"/>
		</label></td>
		</tr>
		<tr>
		<td>Product Price &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  €</td>
		<td><label>
		<input name="price" type="text" id="price" size="12"/>
		</label></td>
		</tr>
		<tr>
		<td align="left">Category</td>
		<td><label>
		<select name="category" id="category">
		<option value=""></option>
		<option value="Metal">Metal</option>
		<option value="Wooden">Wooden</option>
		<option value="Plastic">Plastic</option>
		<option value="Bamboo">Bamboo</option>
		<option value="Various">Various</option>
		</select>
		</label></td>
		</tr>
		<tr>
		<td>Product Details</td>
		<td><label>
		<textarea name="details" id="details" cols="64" rows="5"></textarea>
		</label></td>
		</tr>
		<tr>
		<td width="20%">Items In Stock</td>
		<td width="80%"><label>
		<input name="stock" type="number" id="stock" min="1" max="100"/>
		</label></td>
		</tr>
		<tr>
		<td colspan="2"><strong>Don't forget to manually insert an image for this product to the inventory_images folder.</strong></td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		<td><label>
		<!--This line is for the form's submit button. This is where the javascript function comes into play-->
		<input type="submit" name="button" id="button" value="Add This Item Now" onclick="javascript:return validateListForm();"/>
		</label></td>
		</tr>
		</table>
		</form>
		<br/>
		<br/>
		<br/>
		</div>
		<!--Insert the html for the footer-->
		<?php include_once("admin_footer.php");?>
		</div>
	</body>
</html>