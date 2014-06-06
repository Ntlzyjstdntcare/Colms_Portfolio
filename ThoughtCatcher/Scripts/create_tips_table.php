<?php
//This script is run once in order to create our table of tips in the database. 

 
//Connect to database 
require"connect_to_mysql.php";
//Create a table with our desired columns and parameters
$sqlCommand="CREATE TABLE tips (
        id int(11) NOT NULL auto_increment,
		tip varchar(1024) NOT NULL,
		PRIMARY KEY (id)
		)";
//If the table is created successfully...
if(mysql_query($sqlCommand))
{
    //...echo this message to the user
    echo"Your tips table has been created successfully!";
} else
{
    //Otherwise, give this error message
    echo"CRITICAL ERROR: tips table has not been created.";
}
?>