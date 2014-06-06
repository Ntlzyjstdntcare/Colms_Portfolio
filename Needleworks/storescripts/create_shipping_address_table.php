<?php
//This script is run once in order to create our table of customers' shipping address in the database. 

//Connect to database
require"connect_to_mysql.php";

//Create table with our desired columns and parameters
$sqlCommand="CREATE TABLE shipping_address (
        id int(11) NOT NULL auto_increment,
		shipping_address varchar(64) NOT NULL,
		shipping_address2 varchar(64),
		city varchar(64) NOT NULL,
		county varchar(64),
		zip_code varchar(64),
		country varchar(40) NOT NULL,
		date_added date NOT NULL,
		customerID int(11) NOT NULL,
		PRIMARY KEY (id),
		CONSTRAINT fk_customerID FOREIGN KEY (customerID)
        REFERENCES users(id)
		)";

//If table is created successfully...
if(mysql_query($sqlCommand))
{
  //...return this message to the user
    echo"Your shipping_address table has been created successfully!";
} else
{
    //Otherwise, return this error message
    echo"CRITICAL ERROR: shipping_address table has not been created.";
}
?>
		