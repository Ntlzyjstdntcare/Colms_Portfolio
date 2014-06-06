<?php
//This script is run once in order to create our table of CBT comments in the database. 

 
//Connect to database 
require"connect_to_mysql.php";
//Create a table with our desired columns and parameters
$sqlCommand="CREATE TABLE CBT (
        id int(11) NOT NULL auto_increment,
		before_ varchar(1024) NOT NULL,
		feel varchar(1024) NOT NULL,
		self_image varchar(1024) NOT NULL,
		supporting_evidence varchar(1024) NOT NULL,
		contradictory_evidence varchar(1024) NOT NULL,
		another_explanation varchar(1024) NOT NULL,
		data_entered date NOT NULL,
		PRIMARY KEY (id),
		UNIQUE KEY before_ (before_)
		)";
//If the table is created successfully...
if(mysql_query($sqlCommand))
{
    //...echo this message to the user
    echo"Your CBT table has been created successfully!";
} else
{
    //Otherwise, give this error message
    echo"CRITICAL ERROR: CBT table has not been created.";
}
?>