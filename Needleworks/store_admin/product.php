
<?php
//If the user clicked on the product on the admin index page, run the following script
if (isset($_GET['id']))
{
    //Connect to the database
    include "../storescripts/connect_to_mysql.php";
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
		    //Assign the record's attributes to local variables for using later on in the HTML
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
//If, somehow, the user gets to this page without clicking on a product...
} else 
{
    //...print the following message to screen
	echo "Data to render this page is missing.";
	exit();
}
//Close the database connection
mysql_close();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title><?php echo $product_name;?></title>
		<link rel="stylesheet" href="../style/style.css" type="text/css" media="screen"/>			
	<head>
	
	<body>
	    <div align="center" id="mainWrapper">
		<!--Insert the html for the header-->
		<?php include_once("template_header.php");?>
		<div id="pageContent">
		
		<div align="right" style="margin-right:32px"><a href="inventory_list.php#inventoryForm">+ Add New Inventory Item</a></div>
		<a href="products.php"><h2 align="right">Return to Products&nbsp;&nbsp;&nbsp;</h2></a>
		<!--This table dynamically presents the details for the relevant product, using the local variables that we defined above-->
		<table width="100%" border="0" cellspacing="0" cellpadding="15">
		<tr>
		    <td width="20%" valign="top"><a href="../inventory_images/<?php echo $id; ?>.jpg" target="_blank">
			<div class="morph pic">
			<img src="../inventory_images/<?php echo $id; ?>.jpg" width="300" height="300" alt="<?php echo $product_name; ?>"/></a></td><br/>
			</div>
			<!--<a href="../inventory_images/<?php echo $id; ?>.jpg">View Full Size Image</a></td>-->
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
			</td>
			</tr>
			</table>		
		</div>
		<!--Insert html for the footer-->
		<?php include_once("admin_footer.php");?>
		</div>
	</body>
</html>