<?php
//This script is run once in order to create our table of products in the database. 

//Connect to database
require"connect_to_mysql.php";

//Create table with our desired columns and parameters
$sqlCommand="CREATE TABLE products (
        id int(11) NOT NULL auto_increment,
		product_name varchar(255) ,
		price varchar(16) ,
		details text ,
		category varchar(16) ,
		stock int(4) ,
		date_added date ,
		PRIMARY KEY (id),
		UNIQUE KEY product_name (product_name)
		)";

//If table is created successfully...
if(mysql_query($sqlCommand))
{
    //...return this message to the user
    echo"Your products table has been created successfully!";
} else
{
    //Otherwise, return this error message
    echo"CRITICAL ERROR: products table has not been created.";
}
?>
		