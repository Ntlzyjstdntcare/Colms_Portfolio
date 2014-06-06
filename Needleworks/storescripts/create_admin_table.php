<?php
//This script is run once in order to create our table of administrators in the database. 
 
//Connect to database 
require"connect_to_mysql.php";
//Create a table with our desired columns and parameters
$sqlCommand="CREATE TABLE admin (
        id int(11) NOT NULL auto_increment,
		username varbinary(255) NOT NULL,
		password varbinary(255) NOT NULL,
		last_log_date date NOT NULL,
		PRIMARY KEY (id),
		UNIQUE KEY username (username)
		)";
//If the table is created successfully...
if(mysql_query($sqlCommand))
{
    //...echo this message to the user
    echo"Your admin table has been created successfully!";
} else
{
    //Otherwise, give this error message
    echo"CRITICAL ERROR: admin table has not been created.";
}
?>