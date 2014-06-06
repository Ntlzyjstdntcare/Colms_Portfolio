<?php
//SECTION 1
error_reporting(0);
//Start a session in order to use session variables
session_start();
//Connect to the database
include "storescripts/connect_to_mysql.php";
//Create sessionID variable for later use
$sessionID = session_id();
?>
<?php
//SECTION 2
//If user attempts to add something to the cart from the product page...
if(isset($_POST['pid']))
{
    //...put the POST variable in a local variable
	$pid= $_SESSION['product_id'];
	
	//This variable will be used later. We initialise it to false
	$wasFound = false;
	//As above, but we initialise it to 0
	$index = 0;
	//If the cart session variable is not set, or cart array is empty. This code will run the first time we add something to the cart
	//and when we add something to a cart which we had previously emptied
	if(!isset($_SESSION["cart_array"]) || (count($_SESSION["cart_array"]) < 1))
	{
	    //Assign a multidimensional array to session variable. Variable may already exist if cart had previously been populated and then emptied.
		//The multidimensional array contains one array which is of index 0 in the multidimensional array. That array contains two key/value pairs.
        $_SESSION["cart_array"] = array(0 => array("item_id" => $pid, "quantity" => 1));		
	//If the session exists and has at least one item in it already...
	} else
	{
	    //loop through the multidimensional array, assigning each subarray to the $each_item variable
		foreach($_SESSION["cart_array"]as $each_item)
		{
		    //Increment the index, which will be the new subarray's index in the multidimensional array
		    $index++;
			//Gives us access to each key/value pair in the array that we are currently accessing
			while(list($key, $value) = each($each_item))
			{
			    //If the key is equal to 'item_id' and the value is equal to the POST variable that was sent when the user tried to add an item to the cart...
				if($key == "item_id" && $value == $pid)
				{
				    //...then that item is in the cart already. We then increment its quantity using array_splice()
					//array_splice() removes a portion of an array and replaces it with something else. Here we are removing the element in
					//question and replacing it with the same info, except that the quantity is incremented by one
					array_splice($_SESSION["cart_array"], $index - 1, 1, array(array("item_id" => $pid, "quantity" => $each_item['quantity'] + 1)));
					//We set this variable to true, for use below
					$wasFound = true;
				}
			}
		}
		//If the product is not already in the array...
		if ($wasFound == false)
		{
		    //...add it to the multidimensional array as a new subarray
		    array_push($_SESSION["cart_array"], array("item_id" => $pid, "quantity" => 1));
		}
	}
	//for the case of the user refreshing the page, so that
	//an item isn't added twice.
	header("location: cart.php");
	exit();
}

?>
<?php
//SECTION 3
//If the user chooses to empty their shopping cart by clicking on the link in the html below...
if(isset($_GET['cmd']) && $_GET['cmd'] == "emptycart")
{
    //...unset the session variable to empty the cart
	unset($_SESSION["cart_array"]);
}
?>

<?php
//SECTION 4
//if user wants to remove an item from cart, having clicked the appropriate button in the html...
if (isset($_POST['index_to_remove']) && $_POST['index_to_remove'] != "") 
{
    // Access the array and run code to remove that array index
 	$key_to_remove = $_POST['index_to_remove'];
	if (count($_SESSION["cart_array"]) <= 1) 
	{
		unset($_SESSION["cart_array"]);
	} else 
	{
		unset($_SESSION["cart_array"]["$key_to_remove"]);
		sort($_SESSION["cart_array"]);
	}
}
?>

<?php
//SECTION 5
//Render the cart for the user to view
//Initialise these variables for later use
$cartOutput = "";
$cartTotal = "";

//If the shopping cart session variable has not been set or the cart is empty...
if(!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1)
{
    //...create this message for later output
    $cartOutput = "<h2 align='center'>Shopping Cart Empty</h2>";
	$checkoutButton = " ";
} else
{
	//Initialise this empty array which we will add each item id to. In checkout.php we will check
	//the stock of all products with these id. If any are zero, we will not call checkout.php to run.
	$_SESSION["id_array"] = array();	
	//Initialise this variable and set to zero for later use
    $index = 0;
	// //Loop through the multidimensional array
	foreach($_SESSION["cart_array"] as $each_item)
	{
	    // //For each subarray(product), assign its ID to a local variable
		 $item_id = $each_item["item_id"];
		// //Add the item id to the array of ids
		 array_push($_SESSION["id_array"], "$item_id");
		// //Extract all product details from the database for the product with that ID
		 $sql = mysql_query("SELECT * FROM products WHERE id = '$item_id' LIMIT 1");
		// //Pull out the row that contains the details
	    while ($row = mysql_fetch_array($sql))
		{
		    // //Put the product details into local variables
		    $product_name = $row["product_name"];
		    $price = $row["price"];
		    $details = $row["details"];
			$stock = $row["stock"];
		}
		//This variable is the total cost of each product (unit cost * number of items in cart)
		$priceTotal = $price * $each_item['quantity'];
		
		//This variable is the total cost of all items in the cart. As we loop through the multidimensional array the total($priceTotal)
		//for each item is added to this variable
		$cartTotal = $cartTotal + $priceTotal;
		//get the current stock for sending with the form below
		$sql=mysql_result(mysql_query("SELECT stock FROM products WHERE product_name='$product_name' LIMIT 1"), 0);
		
		//This builds the table of products in the cart that will be output to the screen. As it loops through the multidimensional
		//array it adds a new row to the table each time.
		$cartOutput .= "<tr>";
		$cartOutput .= '<td><a href="product.php?id=' . $item_id . '">' . $product_name . '</a>
		<br/><img src="inventory_images/' . $item_id . '.jpg" alt="' . $product_name . '" width="100" height="130" border="1"/></td>';
		$cartOutput .= '<td>' . $details . '.&nbsp;<strong>' . $stock . ' item(s) in stock.</strong> </td>';
		$cartOutput .= '<td>€' . $price . '</td>';
		$cartOutput .= '<td><form action="cart.php" method="post" name="myCart" id="myCart" enctype="multipart/form_data" >
		<input name="quantity" type="text" value="' . $each_item['quantity'] . '" size="1" maxlength="3"/>
		<input name="adjustButton' . $item_id . '" type="submit" value="change" onclick="javascript:return validateMyCart();"/>
		<input name="item_to_adjust" type="hidden" value="' . $item_id . '" />
		<input name="item_to_adjust_name" type="hidden" value = "' . $product_name . '" />
		<input name="amount_in_stock" type="hidden" value = "' . $sql . '" />
		</form></td>';
		$cartOutput .= '<td>€' . $priceTotal . '</td>';
		$cartOutput .= '<td><form action="cart.php" method="post" ><input name="deleteButton' . $item_id . '" type="submit" value="X"/>
		<input name="index_to_remove" type="hidden" value="' . $index . '" /></form></td>';
		$cartOutput .= '</tr>';
		$index++;
	}
	    //This code will generate a checkout button for the cart, which when clicked will submit the value of cart total to the checkout page
	    $checkoutButton = "<form id='checkoutButton' name='checkoutButton' method='post' action='checkout.php'>
                           <input type='hidden' name='cartTotal' id='cartTotal' value='" . $cartTotal . "'/>
		                   <input type='submit' name='button' id='button' value='Checkout' style='height:50px; width:110px;'/>
			               </form>";
	    //Here we insert the monetary price into a html div, to be output later
	    $cartTotal ="<div style='font-size:18px; margin-top:12px;' align='right'>Cart Total: €" . $cartTotal . " EUR</div>";
	
}
?>

<?php
//SECTION 6
//If the user chooses to adjust item quantity by clicking the relevant button, and that item has an item ID attached to it...
if (isset($_POST['item_to_adjust']) && $_POST['item_to_adjust'] != "")

{
    //...put the POST variables into local variables
    $item_to_adjust=$_POST['item_to_adjust'];
	$quantity_to_adjust=$_POST['quantity'];
	$product_name = $_POST['item_to_adjust_name'];
	$stock= "";
    //Extract the stock of each item from the database
    $sql=mysql_query("SELECT * FROM products WHERE product_name='$product_name' LIMIT 1");
	while ($row = mysql_fetch_array($sql))
    {
        $stock = $row["stock"];
    }
	//If user attempts to enter a value greater than the number in stock, we automatically adjust it to the number in stock.
	if($quantity_to_adjust > $stock)
	{
	   $quantity_to_adjust=$stock; 
	}
	if($quantity_to_adjust<0)
	{
	    $quantity_to_adjust = 0;
	}
	//We will use this variable to access the index of the multidimensional array
	$index=0;
	//Loop through the multidimensional array, assigning each subarray to the $each_item variable
	foreach($_SESSION["cart_array"]as $each_item)
	{
	    $index++;
		//Look at each key/value pair in the current subarray
		while(list($key, $value) = each($each_item))
		{
		    //If we find that the product to be adjusted is already in the array...
			if($key == "item_id" && $value == $item_to_adjust)
			{
			    //...we adjust its quantity using array_splice()
				array_splice($_SESSION["cart_array"], $index - 1, 1, array(array("item_id" => $item_to_adjust, "quantity" => $quantity_to_adjust)));
			}
		}
	}   
    header("location: cart.php");
	exit();	
}
?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Your Cart</title>
		<link rel="stylesheet" href="style/style.css" type="text/css" media="screen"/>	
	</head>
	
	<body>
	<div align="center" id="mainWrapper">
    <!--Insert the html for the header-->
	<?php include_once("template_header.php");?>
    <div id="pageContent">
	<a href="index.php"><h2 align="right">Return to Products&nbsp;&nbsp;&nbsp;</h2></a>
	<div style="margin:24px; text-align:left;">
    <!--<br/>-->
	<!--Begin the table of products in the cart-->
	<table width="100%" border="1" cellspacing="0" cellpadding="6">
	<!--This first row adds the table titles-->
	<tr>
	<td width="18%" bgcolor="#5ACCF2"><strong>Product</strong></td>
	<td width="47%" bgcolor="#5ACCF2"><strong>Product Description</strong></td>
	<td width="10%" bgcolor="#5ACCF2"><strong>Unit Price</strong></td>
	<td width="9%" bgcolor="#5ACCF2"><strong>Quantity</strong></td>
	<td width="7%" bgcolor="#5ACCF2"><strong>Total</strong></td>
	<td width="9%" bgcolor="#5ACCF2"><strong>Remove</strong></td>
	</tr>
	<!--This dynamically adds in the details of the products in the cart as individual table rows-->
	<?php echo $cartOutput; ?>
	</table>
	<!--This prints the total cost of all the items in the cart. It is generated dynamically as we loop through the array above-->
	<?php echo $cartTotal; ?>
	
    <?php echo $checkoutButton; ?>
	<br/>
	<!--If the user clicks here it sends them to the php code above that unsets the cart session variable-->
	<a href="cart.php?cmd=emptycart">Click Here to Empty Your Shopping Cart</a>
    </div>
    <br/>
	<br/>
    </div>
	<!--Insert the html for the footer-->
    <?php include_once("template_footer.php");?>
    </div>
    </body>    
</html>