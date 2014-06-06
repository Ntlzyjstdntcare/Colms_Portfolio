<?php
//This script is run once in order to create our table of thoughts in the database. 

 
//Connect to database 
require"connect_to_mysql.php";
//Create a table with our desired columns and parameters. Removed //userID int(11) NOT NULL,
$sqlCommand="CREATE TABLE thoughts (
        id int(11) NOT NULL auto_increment,
		thought varchar(1000) NOT NULL,
		mood varchar (13),
		last_log_date date NOT NULL,
		PRIMARY KEY (id)
		)";
//If the table is created successfully...
if(mysql_query($sqlCommand))
{
    //...echo this message to the user
    echo"Your thoughts table has been created successfully!";
} else
{
    //Otherwise, give this error message
    echo"CRITICAL ERROR: thoughts table has not been created.";
}
?>

<!--,
		CONSTRAINT fk_userID FOREIGN KEY (userID)
        REFERENCES users(id)-->