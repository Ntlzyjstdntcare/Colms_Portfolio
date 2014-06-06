 <?php
//This script is run once in order to create our table of orders in the database. 

//Connect to database
require"connect_to_mysql.php";

//Create table with our desired columns and parameters
$sqlCommand="CREATE TABLE orders (
        order_id int(11) NOT NULL auto_increment,
		quantity varchar(3) ,
		custID int(11) ,
		productID int(11) ,
		date_added date ,
		orders_session varchar(64) ,
		PRIMARY KEY order_id (order_id),
		CONSTRAINT fk_custID FOREIGN KEY (custID)
        REFERENCES users(id),
		CONSTRAINT fk_productID FOREIGN KEY (productID)
        REFERENCES products(id)
		)";

//If table is created successfully...
if(mysql_query($sqlCommand))
{
  //...return this message to the user
    echo"Your orders table has been created successfully!";
} else
{
    //Otherwise, return this error message
    echo"CRITICAL ERROR: orders table has not been created.";
}
?>
		