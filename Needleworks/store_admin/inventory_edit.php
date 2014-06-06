<?php
//SECTION 1
//Start a session in order to use session variables
session_start();
//Connect to the database
include"../storescripts/connect_to_mysql.php";
//If the manager session variable is not set...
if(!isset($_SESSION["manager"]))
{
    //..direct the user to the login page
    header("location: admin_login.php");
	exit();
}

//If the manager session variable is set, check that the user is in the database.
//Assign the session variables to local variables
$managerID= $_SESSION["id"];
$manager= $_SESSION["manager"];
$password= $_SESSION["password"];

//Select all admin from the database that have attributes that match the session variables (which were entered by the user on login)
$sql=mysql_query("SELECT * FROM users WHERE id='$managerID' AND username='$manager' AND password='$password' AND admin='true' LIMIT 1");
//Count the number of records returned
$existCount=mysql_num_rows($sql);
//If count is 0...
if($existCount==0)
{
    //...return this message to user and exit script
	echo"Your login session data is not on record in the database.";
    exit();
}	
?>


<?php
//SECTION 2
//If user submitted form details in the inventory edit form...
if (isset($_POST['product_name']))
{
    //...assign each posted variable to a local variable, again using 'mysql_real_escape_string' to escape special characters in the variables
	//so that they can be used in sql queries
    $pid=mysql_real_escape_string($_POST['thisID']);
	$product_name=mysql_real_escape_string($_POST['product_name']);
	$price=mysql_real_escape_string($_POST['price']);
	$category=mysql_real_escape_string($_POST['category']);
	$details=mysql_real_escape_string($_POST['details']);
	$stock=mysql_real_escape_string($_POST['stock']);
	//Update the product details with the newly entered details
	$sql=mysql_query("UPDATE products SET product_name='$product_name', price='$price', category='$category', 
	details='$details', stock='$stock' WHERE id='$pid'");

	//Send the user back to the inventory management page
	header("location: inventory_list.php");
	exit();
}
?>


<?php
//SECTION 3
//Initialise this variable for display later on
$product_list = "";
//Select all products in the database;
$sql = mysql_query("SELECT * FROM products");
//Count the number of records returned
$productCount=mysql_num_rows($sql);
//If there are at least one returned results...
if($productCount>0)
{
    //...pull out each row one by one
    while($row = mysql_fetch_array($sql))
    {
        //Assign the attributes of each row to a variable
        $id = $row["id"];
	    $product_name = $row["product_name"];
		$price=$row["price"];
		$category=$row["category"];
		$details=$row["details"];
	    $date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
        //Create a table for each product using the above variables    
		$product_list .= '<table width="100%" border="0" cellspacing="0" cellpadding="6">
		<tr>
		    <td width="17%"><a href="product.php?id=' .  $id . '">
			<img style="border:#666 1px solid" src="../inventory_images/' .  $id . '.jpg" alt="' . $product_name . '" width="150" height="200" border="1"/>
			</a></td>
			<td width="83%" valign="top">' . $product_name . '<br/>
			$ ' . $price . '<br/>
			<a href="product.php?id=' .  $id . '">View Product Details</a></td>
		</tr>
	</table>';
	}
} else 
{
    echo "Sorry that product doesn't exist.";
	exit();
}

?>
<?php
//SECTION 4
//Gather this product's full information for inserting automatically into the edit form below on page
//This means that the existing product details will be presented to the user for editing
//if the user has clicked the 'edit' link on the inventory_list page...
if (isset($_GET['pid']))
{
    //...assign the GET variable to a local variable (the GET variable is the id of the product to be edited)
    $targetID=$_GET['pid'];
	//Select all products that have that id
	$sql=mysql_query("SELECT * FROM products WHERE id = '$targetID' LIMIT 1");
	//Count the number of returned results
    $productCount=mysql_num_rows($sql);
	//If there are at least one returned results...
    if($productCount>0)
    {
	    //...pull out each row one by one
        while($row = mysql_fetch_array($sql))
        {
		    //Assign the attributes of each row to a variable. These variables will be used in the HTML form below
            $id = $row["id"];
		    $product_name = $row["product_name"];
			$price=$row["price"];
			$category=$row["category"];
			$details=$row["details"];
		    $date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
        }	
    //If there are no returned results...
	} else
    {
	    //...echo this message to the user
        echo "Sorry, that product does not exist.";
		exit();
    }  
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
		Edit Inventory Item Form
		</h3>
		<!--Form for entering product details to be added to the database-->
		<form action="inventory_edit.php" enctype="multipart/form_data" name="myForm" id="myForm" method="post">
		<table width="90%" border="0" cellspacing="0" cellpadding="6">
		<tr>
		<td width="20%">Product Name</td>
		<td width="80%"><label>
		<input name="product_name" type="text" id="product_name" size="64" value="<?php echo $product_name; ?>"/>
		</label></td>
		</tr>
		<tr>
		<td>Product Price</td>
		<td><label>
		€
		<input name="price" type="text" id="price" size="12"value="<?php echo $price; ?>"/>
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
		</select>
		</label></td>
		</tr>
		<tr>
		<td>Product Details</td>
		<td><label>
		<textarea name="details" id="details" cols="64" rows="5"><?php echo $details; ?></textarea>
		</label></td>
		</tr>
		<tr>
		<td width="20%">Items In Stock</td>
		<td width="80%"><label>
		<input name="stock" type="number" id="stock" min="1" max="100"/>
		</label></td>
		</tr>
		<tr>
		<td colspan="2"><strong>If required, don't forget to manually edit the image for this product via the inventory_images folder.</strong></td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		<td><label>
		<input name="thisID" type="hidden" value="<?php echo $targetID; ?>"/>
		<!--This line is for the form's submit button. This is where the javascript function comes into play-->
		<input type="submit" name="button" id="button" value="Make Changes" onclick="javascript:return validateListForm();"/>
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